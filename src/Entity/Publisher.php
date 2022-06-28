<?php declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\BaseEntity;
use App\Entity\SlugTrait;

/**
 * @ORM\Table(name="publisher", indexes={@ORM\Index(name="search_idx", columns={"slug"})})
 * @ORM\Entity()
 */
class Publisher extends BaseEntity
{
    use SlugTrait;

    /**
     * @ORM\Column(name="label", type="string", length=255)
     */
    protected string $label = '';

}
