<?php declare(strict_types=1);

namespace App\Collection\Model;

use RtLopez\Decimal;

final class FormatModel
{
    private array $dbRow;
    private bool $selected;

    public function __construct(array $dbRow, bool $selected)
    {
        $this->dbRow = $dbRow;
        $this->selected = $selected;
    }

    public function getId(): int
    {
        return (int)$this->dbRow['id'];
    }

    public function getFormat(): string
    {
        return $this->dbRow['format'];
    }

    public function getDrm(): string
    {
        return $this->dbRow['drm'];
    }

    public function getDiscount(): Decimal
    {
        return Decimal::create($this->dbRow['discount']);
    }

    public function getIsbn(): string
    {
        return $this->dbRow['isbn13'];
    }

    public function getDeliveryDate(): string
    {
        return (string)$this->dbRow['delivery_date'];
    }

    public function isDeliveryAble(): bool
    {
        if(!$this->dbRow['delivery_date']){
            return true;
        }
        return (\DateTimeImmutable::createFromFormat('Y-m-d', $this->dbRow['delivery_date'])) < new \DateTimeImmutable();
    }

    public function getDeliveryDateFormatted(): string
    {
        if(!$this->dbRow['delivery_date']){
            return '';
        }
        return (\DateTimeImmutable::createFromFormat('Y-m-d', $this->dbRow['delivery_date']))->format('d.m.Y');
    }

    public function isSelected(): bool
    {
        return $this->selected;
    }

    public function getStatusCode(): int
    {
        return (int)$this->dbRow['statuscode'];
    }
}
