<?php

declare(strict_types=1);

namespace App\Collection\Model;

final class SeriesModel
{
    private string $label;
    private string $slug;
    private int $part;

    public function __construct(array $dbRow)
    {
        $this->label = $dbRow['label'];
        $this->slug = $dbRow['slug'];
        $this->part = (int)$dbRow['part'];
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function getPart(): int
    {
        return $this->part;
    }

}
