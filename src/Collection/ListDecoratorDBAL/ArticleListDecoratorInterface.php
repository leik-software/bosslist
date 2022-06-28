<?php

declare(strict_types=1);

namespace App\Collection\ListDecoratorDBAL;

use App\Collection\Model\ArticleCollectionModel;

interface ArticleListDecoratorInterface
{
    public function decorate(ArticleCollectionModel $articleCollectionModel): void;
}
