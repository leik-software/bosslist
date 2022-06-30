<?php

declare(strict_types=1);

namespace App\Collection;

use App\Collection\ConditionDBAL\ArticleConditionDBALInterface;
use App\Collection\ListDecoratorDBAL\ArticleListDecoratorInterface;
use App\Collection\Model\ArticleCollectionModel;
use App\Collection\Model\ArticleModel;
use Doctrine\DBAL\Connection;
use Pagination;
use PDO;

final class ArticleDBALCollection implements ArticleCollectionInterface
{
    /** @var ArticleListDecoratorInterface[] */
    private array $listDecorators = [];
    /** @var ArticleConditionDBALInterface[] */
    private array $conditions = [];

    public function __construct(
        private readonly Connection $connection
    ) {}

    public function getCollection(ArticleCollectionRequest $request): ArticleCollectionModel
    {
        $queryBuilder = $this->connection->createQueryBuilder();
        $queryBuilder
            ->select('SQL_CALC_FOUND_ROWS a.id article_id, a.title, a.subtitle, a.slug')
            ->from('article', 'a')
            ->join('a', 'article_format', 'article_format', 'article_format.article_id = a.id')
            ->join('a', 'article_price', 'article_price', 'article_price.article_id = a.id')
            ->groupBy('a.id')
            ->setFirstResult($request->getLimit() * ($request->getPage() - 1))
            ->setMaxResults($request->getLimit())
            ->orderBy('a.title', 'ASC')
            ->andWhere('article_format.statuscode >= :statuscode')
            ->setParameter('statuscode', 1, PDO::PARAM_INT)
        ;

        foreach ($this->conditions as $condition) {
            $condition->addCondition($queryBuilder);
        }

        $results = $queryBuilder->executeQuery()->fetchAllAssociative();
        $countRows = (int) $this->connection->executeQuery('SELECT FOUND_ROWS()')->fetchOne();
        $articleCollection = new ArticleCollectionModel(new Pagination($request->getLimit(), $countRows, $request->getPage()));

        foreach ($results as $result) {
            $articleCollection->addArticle(ArticleModel::fromDbRow($result));
        }

        foreach ($this->listDecorators as $decorator) {
            $decorator->decorate($articleCollection);
        }

        return $articleCollection;
    }

    public function addListDecorator(ArticleListDecoratorInterface $decorator): void
    {
        $this->listDecorators[] = $decorator;
    }

    public function addCondition(ArticleConditionDBALInterface $condition): void
    {
        $this->conditions[] = $condition;
    }

}
