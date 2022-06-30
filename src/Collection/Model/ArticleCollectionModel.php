<?php

declare(strict_types=1);

namespace App\Collection\Model;

use Pagination;

final class ArticleCollectionModel
{
    /** @var ArticleModel[] */
    private array $articles = [];
    private Pagination $pagination;

    public function __construct(Pagination $pagination)
    {
        $this->pagination = $pagination;
    }

    public function addArticle(ArticleModel $articleModel): void
    {
        $this->articles[$articleModel->getArticleId()] = $articleModel;
    }

    public function getPagination(): Pagination
    {
        return $this->pagination;
    }

    public function getArticleIds(): array
    {
        return array_keys($this->articles);
    }

    public function getArticleById(int $articleId): ArticleModel
    {
        return $this->articles[$articleId];
    }

    public function getArticles(): array
    {
        return $this->articles;
    }

    public function getNotIndexedArticles(): array
    {
        return array_values($this->articles);
    }

}
