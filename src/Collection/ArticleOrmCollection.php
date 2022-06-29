<?php
declare(strict_types=1);

namespace App\Collection;

use App\Collection\ConditionOrm\ConditionOrmInterface;
use App\Collection\Model\ArticleCollectionModel;
use App\Entity\Article;
use App\Entity\ArticleFormat;
use App\Entity\ArticlePrice;
use Doctrine\DBAL\ParameterType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\Expr\Join;

class ArticleOrmCollection implements ArticleCollectionInterface
{
    /** @var ConditionOrmInterface[] */
    private array $conditions=[];

    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    public function getCollection(ArticleCollectionRequest $request): ArticleCollectionModel
    {
        $qb = $this->entityManager->createQueryBuilder();
        $qb
            ->select('count(a.id)')
            ->from(Article::class, 'a')
            ->join(ArticleFormat::class, 'af',Join::WITH, 'af.article = a')
            ->join(ArticlePrice::class, 'ap', Join::WITH, 'ap.article = a')
            ->where('af.statuscode = :statuscode')
            ->andWhere('ap.countryCode = :countryCode')
            ->setParameter('statuscode', 1, ParameterType::INTEGER)
            ->setParameter('countryCode', 'DE', ParameterType::STRING);

        $countRows = $qb->getQuery()->getSingleScalarResult();

        $qb
            ->select('a')
            ->groupBy('a.id')
            ->orderBy('a.title', 'asc')
            ->setFirstResult($request->getLimit() * ($request->getPage() - 1))
            ->setMaxResults($request->getLimit());

        foreach ($this->conditions as $condition){
            $condition->addCondition($qb);
        }

        return new ArticleCollectionModel(
            new \Pagination($request->getLimit(), $countRows, $request->getPage()),
            $qb->getQuery()->getResult()
        );

    }

    public function addCondition(ConditionOrmInterface $conditionOrm): void
    {
        $this->conditions[] = $conditionOrm;
    }
}
