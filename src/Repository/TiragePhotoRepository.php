<?php

namespace App\Repository;

use App\Entity\User;
use App\Entity\TiragePhoto;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method TiragePhoto|null find($id, $lockMode = null, $lockVersion = null)
 * @method TiragePhoto|null findOneBy(array $criteria, array $orderBy = null)
 * @method TiragePhoto[]    findAll()
 * @method TiragePhoto[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TiragePhotoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TiragePhoto::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(TiragePhoto $entity, bool $flush = true): void
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
    public function remove(TiragePhoto $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }


     /**
     * cette fonction permet de recupere le prix d'un format par type
     *
     * @param [type] $value
     * @return void
     */
    public function getPrixTirage()
    {
        $query = $this->createQueryBuilder('t')
        ->join('t.tirage', 'ti')
        ->select('ti.prix')
            ;
        return $query->getQuery()->getResult();
    }

    /**
     * cette fonction permet de recupérer la liste des tiragePhoto par type de tirage et par user dans l'ordre DESC
     */
    public function getTiragePhotoUser(User $user, $tirage)
    {
            $query = $this->createQueryBuilder('t');
            $query->join('t.photos' , 'p');
            $query->join('t.tirage' ,'ti')
                ->andwhere($query->expr()->like('ti.tirage', $query->expr()->literal("$tirage")))
                ->andWhere('p.user = :val ')
                ->setParameter('val', $user->getId())
                ->orderBy('t.id', 'DESC')
            ;
            return $query->getQuery()->getResult();
    }



    // /**
    //  * @return TiragePhoto[] Returns an array of TiragePhoto objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TiragePhoto
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
