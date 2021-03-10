<?php

namespace App\Repository;

use App\Entity\Module;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Module|null find($id, $lockMode = null, $lockVersion = null)
 * @method Module|null findOneBy(array $criteria, array $orderBy = null)
 * @method Module[]    findAll()
 * @method Module[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ModuleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Module::class);
    }


    public function findFiltersType($typeId ){

        $qb = $this->createQueryBuilder('m')
            ->innerJoin('m.type', 't')
             ->andWhere('t = :typeId')
               ->setParameter('typeId', $typeId );




dump($qb->getQuery()->getResult());
        return $qb->getQuery()->getResult();

    }


    public function findFiltersPower($powerId){

        $qb = $this->createQueryBuilder('m')
            ->innerJoin('m.typePower', 'mt')


               ->andWhere('mt = :powerId')
                   ->setParameter('powerId', $powerId )
                    ->groupBy('m.id');


dump($qb->getQuery()->getResult());
        return $qb->getQuery()->getResult();

    }




    public function findFiltersSensor($sensorId) {


        $qb = $this->createQueryBuilder('m')
            ->innerJoin('m.sensor', 'ms')




                ->andWhere('ms = :sensorId')
                ->setParameter('sensorId', $sensorId )
                ->groupBy('m.id');



        //dump($qb->getQuery()->getResult());
        return $qb->getQuery()->getResult();

    }


    public function findFiltersConnex($connexId) {


        $qb = $this->createQueryBuilder('m')
            ->innerJoin('m.connection', 'mc')


                 ->andWhere('mc = :connexId')
                    ->setParameter('connexId', $connexId )
                    ->groupBy('m.id');


       // dump($qb->getQuery()->getResult());
        return $qb->getQuery()->getResult();

    }



        public function moduleKo() {

            $table = $this->count(['functionState' => false]);

            $qb =$this->createQueryBuilder('m')
                ->andWhere('m.functionState = 0')
                ->setFirstResult(rand(0, $table - 1 ));


            return $qb->getQuery()->getResult();
        }




    public function filterConnex(){

            $qb = $this->createQueryBuilder('m')
//            ->innerJoin('m.connection', 'mc')
//            ->andWhere('mc.typeConnex = :connexName')
//            ->setParameter('connexName', $connexName )
            ->setMaxResults(6);
//                ->groupBy('m.id');

      //  dump($qb->getQuery()->getResult());
        return $qb->getQuery()->getResult();
    }



    /*

            public function findCaroussel(?int $limit = 3): ?iterable{

                $count = $this->count([]);

                $qb = $this->createQueryBuilder('m')
                    ->setMaxResults($limit)
                    ->setFirstResult(rand(0, $count - 1));
        dump($qb);
                return $qb->getQuery()->getResult();
            }

        */




    // /**
    //  * @return Module[] Returns an array of Module objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Module
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
