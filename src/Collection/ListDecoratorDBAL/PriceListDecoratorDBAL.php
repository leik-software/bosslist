<?php

declare(strict_types=1);

namespace App\Collection\ListDecoratorDBAL;

use App\Collection\Model\ArticleCollectionModel;
use App\Collection\Model\PriceModel;
use Doctrine\DBAL\Connection;

final class PriceListDecoratorDBAL implements ArticleListDecoratorInterface
{
    public function __construct(
        private readonly Connection $connection
    ) {}

    public function decorate(ArticleCollectionModel $articleCollectionModel): void
    {
        $prices = $this->connection->executeQuery(
            <<<'SQL'
                    SELECT p.price, current_prices.active_from, current_prices.article_id, p.striked_price
                    FROM article_price p
                    INNER JOIN (
                        SELECT MAX(ap.active_from) active_from, ap.article_id
                            FROM article_price ap
                            WHERE ap.article_id IN (?)
                            AND ap.active_from < NOW()
                            AND ap.country_code = 'DE'
                            GROUP BY ap.article_id
                        ) current_prices ON current_prices.active_from = p.active_from AND current_prices.article_id = p.article_id
                    WHERE p.country_code = 'DE'
                    GROUP BY p.article_id
                SQL,
            [$articleCollectionModel->getArticleIds()],
            [Connection::PARAM_INT_ARRAY]
        )->fetchAllAssociative();
        if (!$prices) {
            return;
        }

        foreach ($prices as $price) {
            $articleCollectionModel->getArticleById((int) $price['article_id'])->addPriceModel(new PriceModel($price));
        }
    }
}
