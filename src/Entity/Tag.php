<?php declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\BaseEntity;
use App\Entity\CreatedAtTrait;
use App\Entity\SlugTrait;

/**
 * @ORM\Table(name="tag",indexes={
 *     @ORM\Index(columns={"label"}, flags={"fulltext"}),
 *     @ORM\Index(columns={"slug"}, flags={"fulltext"}),
 *     @ORM\Index(name="search_idx", columns={"slug", "visible", "label"})
 * })
 * @ORM\Entity()
 */
class Tag extends BaseEntity
{
    use SlugTrait, CreatedAtTrait;

    /**
     * @ORM\ManyToOne(targetEntity="Vendor")
     * @ORM\JoinColumn(name="vendor_id", referencedColumnName="id")
     */
    protected Vendor $vendor;

    /**
     * @ORM\Column(name="label", type="string", length=255)
     */
    protected string $label = '';

    /**
     * @ORM\Column(name="visible", type="boolean", options={"default":"0"})
     */
    protected bool $visible = false;


}
