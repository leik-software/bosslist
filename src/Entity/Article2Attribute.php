<?php declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\BaseEntity;

/**
 * @ORM\Table(name="article2attribute", indexes={@ORM\Index(columns={"label", "article_id", "attribute_id"})}, uniqueConstraints={@ORM\UniqueConstraint(name="unique_entry", columns={"article_id", "attribute_id"})})
 * @ORM\Entity()
 */
class Article2Attribute extends BaseEntity
{
    /**
     * @ORM\ManyToOne(targetEntity="Article")
     * @ORM\JoinColumn(name="article_id", referencedColumnName="id")
     */
    protected Article $article;
    
    /**
     * @ORM\ManyToOne(targetEntity="Attribute")
     * @ORM\JoinColumn(name="attribute_id", referencedColumnName="id")
     */
    protected Attribute $attribute;

    /**
     * @ORM\ManyToOne(targetEntity="Vendor")
     * @ORM\JoinColumn(name="vendor_id", referencedColumnName="id")
     */
    protected Vendor $vendor;

    /**
     * @ORM\Column(name="label", type="string", length=255)
     */
    protected string $label = '';

}
