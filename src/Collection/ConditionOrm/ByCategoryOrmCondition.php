<?php

declare(strict_types=1);

namespace App\Collection\ConditionOrm;

use App\Entity\Category;
use App\Entity\Category2Article;
use App\ShopRequest;
use Doctrine\DBAL\ParameterType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\ORM\QueryBuilder;

class ByCategoryOrmCondition implements ConditionOrmInterface
{
    public function __construct(
        private readonly ShopRequest $shopRequest,
        private readonly EntityManagerInterface $entityManager
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

        $subQueryBuilder = $this->entityManager->createQueryBuilder();
        $subQueryBuilder
            ->select('node')
            ->from(Category::class, 'node')
            ->join(Category::class, 'parent', Join::WITH, 'node.lft BETWEEN parent.lft AND parent.rgt')
            ->where('parent.slug = :slug')

        ;

        $queryBuilder
            ->join(
                Category2Article::class,
                'category2article',
                Join::WITH,
                sprintf('category2article.article = a AND category2article.category IN (%s)', $subQueryBuilder->getDQL())
            )
            ->setParameter('slug', $slug, ParameterType::STRING)
        ;
    }
}
