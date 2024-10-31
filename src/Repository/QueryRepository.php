<?php

namespace App\Repository;

use App\Entity\Query;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class QueryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Query::class);
    }

    // Aquí puedes agregar métodos personalizados para interactuar con la entidad Query
}
