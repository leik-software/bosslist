<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\CreatedAtTrait;

/**
 * @ORM\Table(name="category2article")
 * @ORM\Entity()
 */
class Category2Article
{
    use CreatedAtTrait;

    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Article")
     * @ORM\JoinColumn(name="article_id", referencedColumnName="id", nullable=false)
     */
    private Article $article;

    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Category")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id", nullable=false)
     */
    private Category $category;

    /**
     * @ORM\Column(name="is_new", type="integer", nullable=false, options={"default":0})
     */
    private int $isNew = 0;


}
