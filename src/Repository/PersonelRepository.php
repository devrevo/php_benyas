<?php

namespace App\Repository;

use App\Entity\Personel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Personel|null find($id, $lockMode = null, $lockVersion = null)
 * @method Personel|null findOneBy(array $criteria, array $orderBy = null)
 * @method Personel[]    findAll()
 * @method Personel[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PersonelRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Personel::class);
    }

     /**
     * @return Personel[]
     */
    public function findAllTechnicien()

    {}
   // $dql="select p.matricule from App\Entity\Personel p  " ;
    
  // $query = $this->getEntityManager()->createQuery($dql);
    
   // return $query->execute();

   public function findByy($tech):array
{  
 
    return $this->getEntityManager()
            ->createQuery(
                'SELECT p
            FROM App\Entity\Personel p
            where p.matricule = :tech'
            ) ->setParameter('tech', $id)
            ->getResult();
}
    

    
    
}
