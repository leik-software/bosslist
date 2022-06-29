<?php

declare(strict_types=1);

namespace App\Collection\Model;

use App\Entity\Article;

final class ArticleCollectionModel
{
    /** @var Article[] */
    private array $articles = [];
    private \Pagination $pagination;

    public function __construct(\Pagination $pagination, array $articles)
    {
        $this->pagination = $pagination;
        $this->articles = $articles;
    }

    public function getPagination(): \Pagination
    {
        return $this->pagination;
    }

    public function getArticles(): array
    {
        return $this->articles;
    }

}
