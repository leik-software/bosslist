<?php

declare(strict_types=1);

namespace App\Collection\ListDecoratorDBAL;

use App\Collection\Model\ArticleCollectionModel;
use App\Collection\Model\AuthorModel;
use Doctrine\DBAL\Connection;

final class AuthorListDecoratorDBAL implements ArticleListDecoratorInterface
{
    public function __construct(
        private readonly Connection $connection
    ) {}

    public function decorate(ArticleCollectionModel $articleCollectionModel): void
    {
        $authors = $this->connection->executeQuery(
            <<<'SQL'
                    SELECT a.label, a.id, a.slug, aa.article_id
                    FROM author a, article2author aa
                    WHERE aa.article_id IN (?)
                    AND aa.author_id = a.id
                SQL,
            [$articleCollectionModel->getArticleIds()],
            [Connection::PARAM_INT_ARRAY]
        )->fetchAllAssociative();
        if (!$authors) {
            return;
        }

        foreach ($authors as $author) {
            $articleCollectionModel->getArticleById((int) $author['article_id'])->addAuthorModel(new AuthorModel($author));
        }
    }
}
