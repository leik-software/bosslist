<?php

namespace App\Collection\ConditionOrm;

use Doctrine\ORM\QueryBuilder;

interface ConditionOrmInterface
{
    public function addCondition(QueryBuilder $queryBuilder);
}
