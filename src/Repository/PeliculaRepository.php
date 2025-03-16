<?php

namespace App\Repository;

use App\Entity\Pelicula;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Pelicula>
 */
class PeliculaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Pelicula::class);
    }

    //    /**
    //     * @return Pelicula[] Returns an array of Pelicula objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('p.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Pelicula
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
    
    public function findByFilters(array $filters): array
    {
        $qb = $this->createQueryBuilder('p');

        if (!empty($filters['inicio'])) {
            $qb->andWhere('p.anio >= :inicio')
                ->setParameter('inicio', $filters['inicio']);
        }

        if (!empty($filters['fin'])) {
            $qb->andWhere('p.anio <= :fin')
                ->setParameter('fin', $filters['fin']);
        }

        if (!empty($filters['titulo'])) {
            $qb->andWhere('p.titulo LIKE :titulo')
                ->setParameter('titulo', '%' . $filters['titulo'] . '%');
        }

        if (!empty($filters['orden'])) {
            $qb->orderBy('p.anio', $filters['orden']);
        }

        return $qb->getQuery()->getResult();
    }

}
