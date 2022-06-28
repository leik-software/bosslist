<?php declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\BaseEntity;

/**
 * @ORM\Table(name="article2country", indexes={@ORM\Index(name="search_idx", columns={"article_id", "country_code"})})
 * @ORM\Entity()
 */
class Article2Country extends BaseEntity
{
    /**
     * @ORM\ManyToOne(targetEntity="Article")
     * @ORM\JoinColumn(name="article_id", referencedColumnName="id")
     */
    protected Article $article;

    /**
     * @ORM\Column(name="country_code", type="string", length=5)
     */
    protected string $countryCode = '';


}
