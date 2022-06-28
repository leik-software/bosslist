<?php

namespace App\Collection;

use App\Collection\Model\ArticleCollectionModel;

interface ArticleCollectionInterface
{
    public function getCollection(ArticleCollectionRequest $request): ArticleCollectionModel;
}
