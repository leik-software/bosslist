<?php

declare(strict_types=1);

namespace App\Collection\ConditionDBAL;

use App\ShopRequest;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

final class ByTagsConditionDBAL implements ArticleConditionDBALInterface
{
    public function __construct(
        private readonly ShopRequest $shopRequest
    ) {}

    public function addCondition(QueryBuilder $queryBuilder): void
    {
        if (!$this->shopRequest->hasRequest()) {
            return;
        }
        $tags = [];
        if ($this->shopRequest->getRequest()->get('tags')) {
            $tags = (array) $this->shopRequest->getRequest()->get('tags');
        }
        if ($this->shopRequest->getRequest()->attributes->has('tag-slug')) {
            $tags = [$this->shopRequest->getRequest()->attributes->get('tag-slug')];
        }
        if (!$tags) {
            return;
        }
        $queryBuilder
            ->innerJoin('a', 'article2tag', 'article2tag', 'article2tag.article_id = a.id')
            ->innerJoin('article2tag', 'tag', 'tag', 'tag.id = article2tag.tag_id AND tag.slug IN (:slugs)')
            ->setParameter('slugs', $tags, Connection::PARAM_STR_ARRAY)
        ;
    }
}
