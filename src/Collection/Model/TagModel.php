<?php

declare(strict_types=1);

namespace App\Collection\Model;

final class TagModel
{
    private string $slug;
    private int $id;
    private string $label;

    public function __construct(array $dbRow)
    {
        $this->slug = $dbRow['slug'];
        $this->id = (int) $dbRow['id'];
        $this->label = $dbRow['label'];
    }

    public function getSlug()
    {
        return $this->slug;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getLabel()
    {
        return $this->label;
    }

    public function __toString(): string
    {
        return $this->slug;
    }

    public function getType(): string
    {
        return 'tag';
    }
}
