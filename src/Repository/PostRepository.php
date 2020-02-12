<?php

namespace App\Repository;

use App\Entity\Post;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Post|null find($id, $lockMode = null, $lockVersion = null)
 * @method Post|null findOneBy(array $criteria, array $orderBy = null)
 * @method Post[]    findAll()
 * @method Post[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Post::class);
    }

    public function getMonthsWithPosts()
    {
        return $this
            ->createQueryBuilder('p')
            ->distinct()
            ->select('MONTH(p.created) AS month, YEAR(p.created) AS year')     
            ->getQuery()
            ->getResult()
        ;
        // $conn = $this->getEntityManager()->getConnection();        
        // $sql = "SELECT DISTINCT MONTH(created) AS month, YEAR(created) AS year FROM post";
        // $stmt = $conn->prepare($sql);
        // $stmt->execute();        
        // return $stmt->fetchAll();
    }

    public function getPostsForMonth($year, $month)
    {
        return $this
            ->createQueryBuilder('p')
            ->select('p.id, p.title')
            ->where('MONTH(p.created) = :month AND YEAR(p.created) = :year')
            ->setParameters([
                'month' => $month,
                'year' => $year,
            ])
            ->getQuery()
            ->getResult()
        ;
    }
}
