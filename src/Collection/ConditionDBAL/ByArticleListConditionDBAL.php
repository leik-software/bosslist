<?php
declare(strict_types=1);

namespace App\Collection\ConditionDBAL;

use App\ShopRequest;
use Doctrine\DBAL\Query\QueryBuilder;

class ByArticleListConditionDBAL implements ArticleConditionDBALInterface
{

    public function __construct(
        private readonly ShopRequest $shopRequest
    ) {}

    public function addCondition(QueryBuilder $queryBuilder): void
    {
        if (!$this->shopRequest->hasRequest()) {
            return;
        }
        $slug = $this->shopRequest->getRequest()->attributes->get('article_list-slug');
        if (!$slug) {
            return;
        }
        $articleList = $this->shopRequest->getRequest()->attributes->get('slug-row');

        $queryBuilder
            ->innerJoin('a', 'article2list', 'article2list', 'article2list.article_id = a.id AND article2list.article_list_id = :list_id')
            ->setParameter('list_id', $articleList['id'], \PDO::PARAM_INT)
        ;
    }
}
