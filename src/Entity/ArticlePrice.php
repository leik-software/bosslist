<?php declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use RtLopez\Decimal;

/**
 * @ORM\Table(name="article_price", indexes={@ORM\Index(name="search_idx", columns={"article_id", "active_from", "price", "striked_price", "extern_id", "country_code", "currency"})})
 * @ORM\Entity()
 */
class ArticlePrice extends BaseEntity
{
    use TimestampableTrait;

    /**
     * @ORM\ManyToOne(targetEntity="Article", inversedBy="prices")
     * @ORM\JoinColumn(name="article_id", referencedColumnName="id")
     */
    protected Article $article;

    /**
     * @ORM\ManyToOne(targetEntity="Vendor")
     * @ORM\JoinColumn(name="vendor_id", referencedColumnName="id")
     */
    protected Vendor $vendor;

    /**
     * @ORM\Column(name="active_from", type="datetime", nullable=false)
     */
    protected \DateTime $activeFrom;

    /**
     * Brutto
     * @ORM\Column(name="price", type="decimal", precision=10, scale=2)
     */
    protected float $price  = 0.0;

    /**
     * Brutto
     * @ORM\Column(name="striked_price", type="decimal", precision=10, scale=2)
     */
    protected float $strikedPrice  = 0.0;

    /**
     * @ORM\Column(name="extern_id", type="integer", nullable=false)
     */
    protected int $externId = 0;

    /**
     * @ORM\Column(name="country_code", type="string", length=5, nullable=false)
     */
    protected string $countryCode = '';

    /**
     * @ORM\Column(name="currency", type="string", length=5, nullable=false)
     */
    protected string $currency = '';

    public function getActiveFrom(): \DateTime
    {
        return $this->activeFrom;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getStrikedPrice(): float
    {
        return $this->strikedPrice;
    }

    public function getCountryCode(): string
    {
        return $this->countryCode;
    }

    public function getPriceFormatted(): string
    {
        return sprintf('%s €', Decimal::create($this->price)->format(2,',','.'));
    }

    public function getStrikedPriceFormatted(): string
    {
        return $this->strikedPrice ? sprintf('%s €', Decimal::create($this->strikedPrice)->format(2,',','.')) : '';
    }

    public function hasStrikedPrice(): bool
    {

        return $this->strikedPrice > 0;
    }

}
