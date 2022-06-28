<?php

namespace App\Collection\ConditionDBAL;

use Doctrine\DBAL\Query\QueryBuilder;

interface ArticleConditionDBALInterface
{
    public function addCondition(QueryBuilder $queryBuilder);
}
