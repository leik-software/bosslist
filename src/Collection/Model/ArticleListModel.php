<?php
declare(strict_types=1);

namespace App\Collection\Model;

final class ArticleListModel
{
    private string $label;
    private string $slug;

    public function __construct(array $dbRow)
    {
        $this->label = $dbRow['label'];
        $this->slug = $dbRow['slug'];
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }
}
