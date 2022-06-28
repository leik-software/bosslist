<?php

declare(strict_types=1);

namespace App\Collection\ConditionDBAL;

use App\ShopRequest;
use Doctrine\DBAL\Query\QueryBuilder;

final class BySeriesConditionDBAL implements ArticleConditionDBALInterface
{
    public function __construct(
        private readonly ShopRequest $shopRequest
    ) {}

    public function addCondition(QueryBuilder $queryBuilder): void
    {
        if (!$this->shopRequest->hasRequest()) {
            return;
        }
        $slug = $this->shopRequest->getRequest()->attributes->get('article_series-slug');
        if (!$slug) {
            return;
        }
        $series = $this->shopRequest->getRequest()->attributes->get('slug-row');

        $queryBuilder
            ->innerJoin('a', 'article2series', 'article2series', 'article2series.article_id = a.id AND article2series.article_series_id = :series')
            ->setParameter('series', $series['id'], \PDO::PARAM_INT)
            ->orderBy('article2series.part', 'asc')
        ;
    }
}
