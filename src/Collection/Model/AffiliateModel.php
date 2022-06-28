<?php
declare(strict_types=1);

namespace App\Collection\Model;

final class AffiliateModel
{
    public const PRODUCT_TYPE_HARDCOVER = 'HC';
    public const PRODUCT_TYPE_EBOOK = 'EB';
    public const PRODUCT_TYPE_SOFTCOVER = 'SC';
    public const PRODUCT_TYPE_BOOK = 'BK';
    public const PRODUCT_TYPE_SPIRAL_COVER = 'SC';
    public const PRODUCT_TYPE_AUDIO = 'AU';
    private string $partnerDomain;
    private string $partnerIdentifier;
    private string $productType;

    public function __construct(string $partnerDomain, string $partnerIdentifier, string $productType)
    {
        $this->partnerDomain = $partnerDomain;
        $this->partnerIdentifier = $partnerIdentifier;
        $this->productType = $productType;
    }

    public function getPartnerDomain(): string
    {
        return $this->partnerDomain;
    }

    public function getPartnerIdentifier(): string
    {
        return $this->partnerIdentifier;
    }

    public function getProductType(): string
    {
        return $this->productType;
    }

    public function getProductTypeName(): string
    {
        return match ($this->getProductType()){
            self::PRODUCT_TYPE_HARDCOVER => 'Gebundenes Buch',
            self::PRODUCT_TYPE_EBOOK => 'eBook',
            self::PRODUCT_TYPE_SOFTCOVER => 'Taschenbuch',
            self::PRODUCT_TYPE_AUDIO => 'Hörbuch',
            default => ''
        };
    }
}
