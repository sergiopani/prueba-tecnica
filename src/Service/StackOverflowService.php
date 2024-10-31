<?php

namespace App\Service;

use App\Entity\Query;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use App\Entity\Question;
use Doctrine\ORM\EntityManagerInterface;

class StackOverflowService
{

    private HttpClientInterface $client;
    private EntityManagerInterface $entityManager;
    private $url = 'https://api.stackexchange.com/2.3/questions?order=desc&sort=activity&site=stackoverflow&tagged=';

    public function __construct(
        HttpClientInterface $client,
        EntityManagerInterface $entityManager
    ) {
        $this->client = $client;
        $this->entityManager = $entityManager;
    }

    public function fetchQuestions($tagged, $toDate, $fromDate)
    {

        $url = $this->url . urlencode($tagged);

        if ($toDate) {
            $url .= '&todate=' . urlencode($toDate);
        }

        if ($fromDate) {
            $url .= '&fromdate=' . urlencode($fromDate);
        }

        return [
            $url,
            $this->client->request('GET', $url)
        ];
    }

    public function createQuery(Query $query)
    {
        $this->entityManager->persist($query);
        $this->entityManager->flush();
    }

    public function readQuery($tagged, $toDate = null, $fromDate = null): ?Query
    {
        $query = $this->entityManager->getRepository(Query::class)->findOneBy([
            'queryString' => $this->url . urlencode($tagged) . '&todate=' . urlencode($toDate) . '&fromdate=' . urlencode($fromDate)
        ]);

        return $query;
    }

    
}
