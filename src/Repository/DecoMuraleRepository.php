<?php

namespace App\Repository;

use App\Entity\DecoMurale;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DecoMurale|null find($id, $lockMode = null, $lockVersion = null)
 * @method DecoMurale|null findOneBy(array $criteria, array $orderBy = null)
 * @method DecoMurale[]    findAll()
 * @method DecoMurale[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DecoMuraleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DecoMurale::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(DecoMurale $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(DecoMurale $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }


    /**
     * on recupere l id et  le prix d'un tiragePhoto
     *
     * @return void
     */
    public function getIdDeco(){
        $query = $this->createQueryBuilder('d')
        ->join('d.couleur' ,'c')
            ->select('d.id' , 'd.format','d.prix', 'c.couleur') 
            ;
        return $query->getQuery()->getResult();;
    }
    // /**
    //  * @return DecoMurale[] Returns an array of DecoMurale objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?DecoMurale
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
