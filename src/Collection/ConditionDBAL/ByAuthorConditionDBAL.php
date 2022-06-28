<?php

declare(strict_types=1);

namespace App\Collection\ConditionDBAL;

use App\ShopRequest;
use Doctrine\DBAL\Query\QueryBuilder;

final class ByAuthorConditionDBAL implements ArticleConditionDBALInterface
{
    public function __construct(
        private readonly ShopRequest $shopRequest
    ) {}

    public function addCondition(QueryBuilder $queryBuilder): void
    {
        if (!$this->shopRequest->hasRequest()) {
            return;
        }
        $slug = $this->shopRequest->getRequest()->attributes->get('author-slug');
        if (!$slug) {
            return;
        }
        $authorRow = $this->shopRequest->getRequest()->attributes->get('slug-row');

        $queryBuilder
            ->innerJoin('a', 'article2author', 'article2author', 'article2author.article_id = a.id AND article2author.author_id = :author')
            ->setParameter('author', $authorRow['id'], \PDO::PARAM_INT)
        ;
    }
}
