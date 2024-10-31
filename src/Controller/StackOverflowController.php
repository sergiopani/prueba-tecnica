<?php

namespace App\Controller;

use App\Entity\Query;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\StackOverflowService;

class StackOverflowController extends AbstractController
{

    
    private StackOverflowService $stackOverflowService;

    public function __construct(StackOverflowService $stackOverflowService)
    {
        $this->stackOverflowService = $stackOverflowService;
    }

    #[Route(path: '/questions', name: 'questions', methods: ['GET'])]
    public function getQuestions(Request $request): Response
    {
        //1. Comprobar los parametros de la url        
        $tagged = $request->query->get('tagged');
        $toDate = $request->query->get('todate');
        $fromDate = $request->query->get('fromdate');

        if (!$tagged) {
            return new Response('El parámetro "tagged" es obligatorio.', Response::HTTP_BAD_REQUEST);
        }

        //2. Comprobar si ya existe la query en la base de datos
        $existingQuery = $this->stackOverflowService->readQuery($tagged, $toDate, $fromDate);


        if ($existingQuery) {
            return new Response(json_encode($existingQuery->getQuestionsData()), Response::HTTP_OK, ['Content-Type' => 'application/json']);
        }
        
        //3. No existe la query en la base de datos, hacer la petición a la API
        [$url, $response] = $this->stackOverflowService->fetchQuestions($tagged, $toDate, $fromDate);
        
        if ($response->getStatusCode() !== 200) {
            return new Response('Error al obtener datos de Stack Overflow.', Response::HTTP_BAD_GATEWAY);
        }
        
        //4. Guardar la query en la base de datos
        $query = new Query();
        $query->setQueryString($url);
        $query->setQuestionsData(json_decode($response->getContent(), true));


        $this->stackOverflowService->createQuery($query);
        
        return new Response($response->getContent(), Response::HTTP_OK, ['Content-Type' => 'application/json']);
    }
}
