<?php

declare(strict_types=1);

namespace App\Collection;

use App\Collection\Model\ArticleCollectionModel;
use App\ShopRequest;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\ParameterType;
use Pagination;

final class ArticleSqlCollection implements ArticleCollectionInterface
{

    public function __construct(
        private readonly Connection $connection,
        private readonly ShopRequest $shopRequest
    ) {}

    public function getCollection(ArticleCollectionRequest $request): ArticleCollectionModel
    {
        $categorySlug = $this->shopRequest->getRequest()->attributes->get('category-slug');
        $categoryCondition = '';
        if ($categorySlug) {
            $categoryCondition = <<<SQL
                INNER JOIN category2article ON category2article.article_id = a.id AND category2article.category_id IN (
                    SELECT node.id
                    FROM category AS node, category AS parent
                    WHERE node.lft BETWEEN parent.lft AND parent.rgt
                    AND parent.slug = '$categorySlug'
                )
                SQL;
        }

        $tagSlug = $this->shopRequest->getRequest()->attributes->get('tag-slug');
        $tagCondition = '';
        if($tagSlug){
            $tagCondition = <<<SQL
                INNER JOIN article2tag ON article2tag.article_id = a.id
                INNER JOIN tag ON tag.id = article2tag.tag_id AND tag.slug = '$tagSlug'
                SQL;

        }

        $authorSlug = $this->shopRequest->getRequest()->attributes->get('author-slug');
        $authorCondition = '';
        if($authorSlug){
            $authorCondition = sprintf('AND author.slug = "%s"', $authorSlug);
        }

        $results = $this->connection->executeQuery(
            <<<SQL
            SELECT SQL_CALC_FOUND_ROWS a.id article_id, a.title, a.subtitle, a.slug,
                   GROUP_CONCAT(DISTINCT CONCAT(author.label,'|',author.slug) ORDER BY author.label SEPARATOR ';') as authors,
                   afc.blur_hash, afc.aws_url_thumb,
                   p.price, current_prices.active_from, p.striked_price
            FROM article a 
            INNER JOIN article_format ON article_format.article_id = a.id
            INNER JOIN article_price AS p ON p.article_id = a.id AND p.country_code = 'DE'
            INNER JOIN (
                SELECT MAX(ap.active_from) active_from, ap.article_id
                    FROM article_price ap
                    WHERE ap.active_from < NOW()
                    AND ap.country_code = 'DE'
                    GROUP BY ap.article_id
                ) current_prices ON current_prices.active_from = p.active_from AND current_prices.article_id = p.article_id
            INNER JOIN article2author ON article2author.article_id = a.id
            INNER JOIN author ON author.id = article2author.author_id
            INNER JOIN article_file_cloud AS afc ON afc.article_id = a.id
            $categoryCondition
            $tagCondition
            WHERE article_format.statuscode >= :statuscode
            $authorCondition
            GROUP BY a.id
            ORDER BY a.title ASC
            LIMIT :offset, :limit
            SQL,
            [
                'statuscode' => 1,
                'offset' => $request->getLimit() * ($request->getPage() - 1),
                'limit' => $request->getLimit()
            ],
            [
                'statuscode' => ParameterType::INTEGER,
                'offset' => ParameterType::INTEGER,
                'limit' => ParameterType::INTEGER
            ]

        )->fetchAllAssociative();

        $countRows = (int) $this->connection->executeQuery('SELECT FOUND_ROWS()')->fetchOne();
        return new ArticleCollectionModel(new Pagination($request->getLimit(), $countRows, $request->getPage()), $results);
    }


}
