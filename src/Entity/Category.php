<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="category", indexes={@ORM\Index(name="search_idx", columns={"slug"})})
 * @ORM\Entity()
 */
class Category extends BaseEntity
{

    /**
     * @ORM\Column(name="title", type="string", length=255)
     */
    protected string $title;

    /**
     * @ORM\Column(name="lft", type="integer")
     */
    protected int $lft;

    /**
     * @ORM\Column(name="rgt", type="integer")
     */
    protected int $rgt;

    /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="children")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected ?Category $parent;

    /**
     * @ORM\Column(length=250, unique=true, options={"default":"slug"})
     */
    private string $slug;

    /**
     * @ORM\Column(name="visible_in_tree", type="boolean", options={"default":"0"})
     */
    private bool $visibleInTree = false;

    public function getTitle(): string
    {
        return $this->title;
    }

    public function isVisibleInTree(): bool
    {
        return $this->visibleInTree;
    }

}
