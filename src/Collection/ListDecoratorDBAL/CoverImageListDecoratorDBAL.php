<?php

declare(strict_types=1);

namespace App\Collection\ListDecoratorDBAL;

use App\Collection\Model\ArticleCollectionModel;
use Doctrine\DBAL\Connection;

final class CoverImageListDecoratorDBAL implements ArticleListDecoratorInterface
{
    public function __construct(
        private readonly Connection $connection
    ) {}

    public function decorate(ArticleCollectionModel $articleCollectionModel): void
    {
        $images = $this->connection->executeQuery(
            <<<'SQL'
                    SELECT afc.article_id, afc.blur_hash,
                    afc.aws_url_thumb, afc.aws_url_icon, afc.aws_url_detail
                    FROM article_file_cloud afc
                    WHERE afc.article_id IN (?)
                SQL,
            [$articleCollectionModel->getArticleIds()],
            [Connection::PARAM_INT_ARRAY]
        )->fetchAllAssociative();
        if (!$images) {
            return;
        }

        foreach ($images as $image) {
            $articleCollectionModel->getArticleById((int) $image['article_id'])->setImageUrls($image);
        }
    }
}
