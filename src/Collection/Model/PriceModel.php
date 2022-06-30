<?php

declare(strict_types=1);

namespace App\Collection\Model;

use DateTimeImmutable;
use RtLopez\Decimal;

final class PriceModel
{
    private Decimal $price;
    private Decimal $strikedPrice;
    private DateTimeImmutable $activeFrom;

    public function __construct(array $dbRow)
    {
        $this->price = Decimal::create($dbRow['price']);
        $this->strikedPrice = Decimal::create($dbRow['striked_price']);
        $this->activeFrom = new DateTimeImmutable($dbRow['active_from']);
    }

    public function getPriceFormatted(): string
    {
        return sprintf('%s €', $this->price->format(2,',','.'));
    }

    public function getPrice(): Decimal
    {
        return $this->price;
    }

    public function getStrikedPriceFormatted(): string
    {
        return $this->strikedPrice ? sprintf('%s €', $this->strikedPrice->format(2,',','.')) : '';
    }

    public function hasStrikedPrice(): bool
    {

        return $this->strikedPrice->gt('0');
    }

    public function getActiveFrom(): DateTimeImmutable
    {
        return $this->activeFrom;
    }

}
