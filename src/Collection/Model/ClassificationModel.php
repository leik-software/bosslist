<?php
declare(strict_types=1);

namespace App\Collection\Model;

final class ClassificationModel
{
    private string $label;
    private string $slug;

    public function __construct(string $label, string $slug)
    {
        $this->label = $label;
        $this->slug = $slug;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function __toString(): string
    {
        return $this->slug;
    }

    public function getType(): string
    {
        return 'classification';
    }
}
