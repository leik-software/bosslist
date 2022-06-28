<?php

declare(strict_types=1);

namespace App\Collection\Model;

use function count;

final class ArticleModel implements HasCoverImageInterface
{
    use CountryCodeTrait;

    private array $dbRow;
    /** @var AuthorModel[] */
    private array $authors = [];
    private string $thumbUrl = '';
    private string $iconUrl = '';
    private string $detailUrl = '';
    private string $blurHash = '';
    /** @var PriceModel[] */
    private array $prices = [];
    private array $formats = [];
    private string $headline = '';
    private float $ranking = 0;

    private function __construct()
    {
    }

    public static function fromDbRow(array $dbRow): self
    {
        $article = new ArticleModel();
        $article->dbRow = $dbRow;
        return $article;
    }

    public function getRanking(): float|int
    {
        return $this->ranking;
    }

    public function getArticleId(): int
    {
        return (int) $this->dbRow['article_id'];
    }

    public function addAuthorModel(AuthorModel $authorModel): void
    {
        $this->authors[] = $authorModel;
    }

    public function getAuthors(): array
    {
        return $this->authors;
    }

    public function getFirstAuthorName(): string
    {
        if(count($this->authors) === 1){
            return current($this->authors)->getLabel();
        }
        if(count($this->authors) === 0){
            return '';
        }
        return current($this->authors)->getLabel();
    }

    public function getAuthorString(): string
    {
        if(count($this->authors) === 1){
            return current($this->authors)->getLabel();
        }
        if(count($this->authors) === 0){
            return '';
        }
        return sprintf('%s und weitere',current($this->authors)->getLabel());
    }


    public function addPriceModel(PriceModel $priceModel): void
    {
        $this->prices[] = $priceModel;
    }

    public function setImageUrls(array $dbRow): void
    {
        $this->thumbUrl = $dbRow['aws_url_thumb'];
        $this->iconUrl = $dbRow['aws_url_icon'];
        $this->detailUrl = $dbRow['aws_url_detail'];
        $this->blurHash = $dbRow['blur_hash'];
    }

    public function getThumbUrl(): string
    {
        return $this->thumbUrl;
    }

    public function getBlurHash(): string
    {
        return $this->blurHash;
    }

    public function getIconUrl(): string
    {
        return $this->iconUrl;
    }

    public function getDetailUrl(): string
    {
        return $this->detailUrl;
    }

    public function getTitle(): string
    {
        return $this->dbRow['title'];
    }

    public function getSubtitle(): string
    {
        return $this->dbRow['subtitle'];
    }

    public function getSlug(): string
    {
        return $this->dbRow['slug'];
    }

    public function getPriceModel(): PriceModel
    {
        return current($this->prices);
    }

    public function hasPrices(): bool
    {
        return count($this->prices) > 0;
    }


}
