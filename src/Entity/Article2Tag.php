<?php
declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="article2tag", uniqueConstraints={@ORM\UniqueConstraint(name="unique_entry", columns={"article_id", "tag_id"})})
 * @ORM\Entity()
 */
class Article2Tag
{

    /**
     * @ORM\ManyToOne(targetEntity="Article")
     * @ORM\JoinColumn(name="article_id", referencedColumnName="id")
     * @ORM\Id()
     */
    private Article $article;

    /**
     * @ORM\ManyToOne(targetEntity="Tag")
     * @ORM\JoinColumn(name="tag_id", referencedColumnName="id")
     * @ORM\Id()
     */
    private Tag $tag;

}
