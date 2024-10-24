<?php

namespace App\Repository;

use App\Entity\Book;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Book>
 */
class BookRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Book::class);
    }

    //    /**
    //     * @return Book[] Returns an array of Book objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('b.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Book
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

    public function getBooksOrdredByTitle(){
        $em = $this->getEntityManager();
        $query = $em->createQuery('Select b from App\Entity\Book b order by b.title ASC');
        return $query->getResult();
    }

    public function getBooksOrdredByTitleQueryBuilder(){
        $query = $this->createQueryBuilder('b')
                    ->orderBy('b.title','ASC');
        
        return $query->getQuery()->getResult();
    }

    public function getBooksByTitleQueryBuilder($title){
        return $this->createQueryBuilder('b')
                    ->where('b.title LIKE :t')
                    ->setParameter('t',$title)
                    ->getQuery()
                    ->getResult();
    }

     public function getBooksByTitle($title){
        $em= $this->getEntityManager();
        $query = $em->createQuery
        ('Select b from App\Entity\Book b where b.title LIKE :t');
        $query->setParameter('t',$title);
        return $query->getResult();

    }

    public function getBooksByDate($startDate,$endDate){
        $em= $this->getEntityManager();
        $query = $em->createQuery
        ('Select b from App\Entity\Book b 
        where b.publicationDate >= :date1 AND b.publicationDate <= :date2');
      //  $query->setParameter('date1',$startDate);
       // $query->setParameter('date2',$endDate);
        $query->setParameters(['date1'=>$startDate,'date2'=>$endDate]);
        return $query->getResult();
    }

    public function getBooksByDateQueryBuilder($startDate,$endDate){
        return $this->createQueryBuilder('b')
                    ->where('b.publicationDate >= :date1')
                    ->andWhere('b.publicationDate <= :date2')
                    ->setParameter('date1',$startDate)
                    ->setParameter('date2',$endDate)
                    ->getQuery()
                    ->getResult();
    }
    public function getNbBooks(){
        $em = $this->getEntityManager();
        $query = $em->createQuery('Select COUNT(b) from App\Entity\Book b');
        return $query->getSingleScalarResult();
    }

     public function getNbBooksQueryBuilder(){
        return $this->createQueryBuilder('COUNT(b)')
                    ->getQuery()
                    ->getSingleScalarResult();
    }

    public function getBookByAuthor($idAuthor){
        $em = $this->getEntityManager();
        $query = $em->createQuery
        ('Select b from App\Entity\Book b join b.idAuthor a where a.id = :id');
        $query->setParameter('id',$idAuthor);
        return $query->getResult();
    }

    public function getBookByAuthorQueryBuilder($idAuthor){
       return $this->createQueryBuilder('b')
                    ->join('b.idAuthor','a')
                    ->where('a.id = :id')
                    ->setParameter('id',$idAuthor)
                    ->getQuery()
                    ->getResult();
    }
}
