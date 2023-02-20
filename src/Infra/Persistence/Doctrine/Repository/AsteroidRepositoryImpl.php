<?php

namespace Neo\Infra\Persistence\Doctrine\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Neo\Domain\Entity\AsteroidEntity;
use Neo\Domain\Exception\NoAsteroidsFoundException;
use Neo\Domain\Filter\AsteroidFilter;
use Neo\Domain\Repository\AsteroidRepository;
use Neo\Domain\ValueObject\BestMonth;
use Neo\Domain\ValueObject\Month;

class AsteroidRepositoryImpl extends ServiceEntityRepository implements AsteroidRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AsteroidEntity::class);
    }

    public function findHazardous(): array
    {
       return $this->findBy(['isHazardous' => true], ['date' => 'DESC']);
    }

    /**
     * @throws NoAsteroidsFoundException
     */
    public function getBestMonthInCurrentYear(AsteroidFilter $asteroidFilter): BestMonth
    {
        $qb = $this->createQueryBuilder('a')
                   ->select('MONTH(a.date) AS month, COUNT(a) AS asteroidsCount')
                   ->andWhere('YEAR(a.date) = :currentYear')
                   ->groupBy('month')
                   ->setParameter('currentYear', date("Y"))
                   ->setMaxResults(1)
                   ->addOrderBy('asteroidsCount', 'DESC')
                   ->addOrderBy('month', 'DESC');

        $this->applyFilter($qb, $asteroidFilter);

        $bestMonth = $qb->getQuery()->getOneOrNullResult();

        if ($bestMonth === null) {
            throw new NoAsteroidsFoundException();
        }

        return new BestMonth(Month::fromNumber((int)$bestMonth['month']), $bestMonth['asteroidsCount']);
    }

    /**
     * @throws NoAsteroidsFoundException
     */
    public function getFastest(AsteroidFilter $asteroidFilter): AsteroidEntity
    {
        $qb = $this->createQueryBuilder('a')
                   ->addOrderBy('a.speed', 'DESC')
                   ->setMaxResults(1);

        $this->applyFilter($qb, $asteroidFilter);

        $fastestAsteroid = $qb->getQuery()->getOneOrNullResult();

        if ($fastestAsteroid === null) {
            throw new NoAsteroidsFoundException();
        }

        return $fastestAsteroid;
    }

    public function applyFilter(QueryBuilder $queryBuilder, AsteroidFilter $asteroidFilter): void
    {
        $queryBuilder
            ->andWhere(sprintf('%s.isHazardous = :isHazardous', $queryBuilder->getRootAliases()[0]))
            ->setParameter('isHazardous', $asteroidFilter->getIsHazardous());
    }
}
