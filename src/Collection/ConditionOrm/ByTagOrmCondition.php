<?php
declare(strict_types=1);

namespace App\Collection\ConditionOrm;

use App\Entity\Article2Tag;
use App\Entity\Tag;
use App\ShopRequest;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\ORM\QueryBuilder;

class ByTagOrmCondition implements ConditionOrmInterface
{
    public function __construct(private readonly ShopRequest $shopRequest)
    {
    }

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
            ->innerJoin(Article2Tag::class, 'article2tag', Join::WITH, 'article2tag.article = a')
            ->innerJoin(Tag::class, 'tag',Join::WITH , 'tag = article2tag.tag AND tag.slug IN (:slugs)')
            ->setParameter('slugs', $tags, Connection::PARAM_STR_ARRAY)
        ;
    }
}
