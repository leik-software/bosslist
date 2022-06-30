<?php

declare(strict_types=1);

namespace App\Collection\ConditionDBAL;

use App\ShopRequest;
use Doctrine\DBAL\Query\QueryBuilder;

final class ByCategoryConditionDBAL implements ArticleConditionDBALInterface
{
    public function __construct(
        private readonly ShopRequest $shopRequest
    ) {}

    public function addCondition(QueryBuilder $queryBuilder): void
    {
        if (!$this->shopRequest->hasRequest()) {
            return;
        }
        $slug = $this->shopRequest->getRequest()->attributes->get('category-slug');
        if (!$slug) {
            return;
        }
        $naviSelect = <<<SQL
                SELECT node.id
                FROM category AS node, category AS parent
                WHERE node.lft BETWEEN parent.lft AND parent.rgt
                AND parent.slug = '$slug'
            SQL;

        $queryBuilder
            ->innerJoin(
                'a',
                'category2article',
                'category2article',
                sprintf('category2article.article_id = a.id AND category2article.category_id IN (%s)', $naviSelect)
            )
        ;
    }
}
