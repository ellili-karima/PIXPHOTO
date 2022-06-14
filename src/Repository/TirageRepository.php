<?php

namespace App\Repository;

use App\Entity\User;
use App\Entity\Tirage;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Tirage|null find($id, $lockMode = null, $lockVersion = null)
 * @method Tirage|null findOneBy(array $criteria, array $orderBy = null)
 * @method Tirage[]    findAll()
 * @method Tirage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TirageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tirage::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Tirage $entity, bool $flush = true): void
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
    public function remove(Tirage $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * on recupere le prix min du tirage standard
     *
     * @return void
     */
    public function getPrixMinTirageStandard(){
        $query = $this->createQueryBuilder('t');
        $query->select('t.prix')
            ->andwhere($query->expr()->like('t.tirage', $query->expr()->literal("Tirage Standard")))
            ->orderBy('t.prix' , 'ASC')
            ->setMaxResults(1)
            ;
        return $query->getQuery()->getOneOrNullResult();
    }
    /**
     * on recupere le prix min du tirage identité
     *
     * @return void
     */
    public function getPrixMinTirageIdentite(){
        $query = $this->createQueryBuilder('t');
        $query->select('t.prix')
            // ->andwhere($query->expr()->like('t.tirage', $query->expr()->literal("Tirage Identite")))
            ->andWhere('t.tirage = :val')
            ->setParameter('val', 'Tirage Identite')
            ->orderBy('t.prix' , 'ASC')
            ->setMaxResults(1)
            ;
        return $query->getQuery()->getOneOrNullResult();
    }

    /**
     * on recupere l id et  le prix d'un tiragePhoto
     *
     * @return void
     */
    public function getId(){
        $query = $this->createQueryBuilder('t')
            ->select('t.id' ,'t.prix') 
            ;
        return $query->getQuery()->getResult();;
    }

    // /**
    //  * cette requette permet de recuperer la liste des types dans la table tirage
    //  */
    // public function getTypesTirage()
    // {
    //     $query = $this->createQueryBuilder('t')
    //         ->select('DISTINCT t.typeTirage')
    //         ;
    //     return $query->getQuery()->getResult();
    // }
  
   

    // /**
    //  * cette fonction permet de recupere la liste des format par type
    //  *
    //  * @param [type] $value
    //  * @return void
    //  */
    // public function getFormatsTirage($value)
    // {
    //     $query = $this->createQueryBuilder('t')
    //         ->select('t.format')
    //         ->andWhere('t.typeTirage = :val')
    //         ->setParameter('val', $value)
    //         ;
    //     return $query->getQuery()->getResult();
    // }


    // /**
    //  * cette fonction permet de recupere le prix d'un format par type
    //  *
    //  * @param [type] $value
    //  * @return void
    //  */
    // public function getPrixFormatTirage($type , $format)
    // {
    //     $query = $this->createQueryBuilder('t')
    //         ->select('t.prix')
    //         ->andWhere('t.format = :val')
    //         ->setParameter('val', $format)
    //         ->andWhere('t.typeTirage = :val')
    //         ->setParameter('val', $type)
    //         ;
    //     return $query->getQuery()->getOneOrNullResult();
    //  }
  


    // /**
    //  * @return Tirage[] Returns an array of Tirage objects
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
    public function findOneBySomeField($value): ?Tirage
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
