<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="article2list")
 * @ORM\Entity()
 */
class Article2List
{
    use TimestampableTrait;
    
    /**
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="Article")
     * @ORM\JoinColumn(name="article_id", referencedColumnName="id", nullable=false)
     */
    private Article $article;
    
    /**
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="ArticleList")
     * @ORM\JoinColumn(name="article_list_id", referencedColumnName="id", nullable=false)
     */
    private ArticleList $articleList;

    /**
     * @ORM\Column(name="rank", type="integer", nullable=false, options={"default": 1})
     */
    private int $rank = 0;


}
