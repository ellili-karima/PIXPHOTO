<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\ORM\ORMException;
use App\Entity\DecoMuralePhoto;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method DecoMuralePhoto|null find($id, $lockMode = null, $lockVersion = null)
 * @method DecoMuralePhoto|null findOneBy(array $criteria, array $orderBy = null)
 * @method DecoMuralePhoto[]    findAll()
 * @method DecoMuralePhoto[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DecoMuralePhotoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DecoMuralePhoto::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(DecoMuralePhoto $entity, bool $flush = true): void
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
    public function remove(DecoMuralePhoto $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function getDecoMuralePhotoTilesUser(User $user)
    {
            $query = $this->createQueryBuilder('d');
            $query->join('d.photos' , 'p');
            $query->join('d.decoMurale' , 'deco')
                ->andWhere('p.user = :val ')
                ->setParameter('val', $user->getId())
                ->andwhere($query->expr()->like('deco.support', $query->expr()->literal("Tiles")))
                ->orderBy('d.id', 'DESC')
            ;
            return $query->getQuery()->getResult();
    }
     

    // /**
    //  * @return DecoMuralePhoto[] Returns an array of DecoMuralePhoto objects
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
    public function findOneBySomeField($value): ?DecoMuralePhoto
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
