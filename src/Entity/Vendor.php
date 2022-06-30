<?php declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="vendor")
 * @ORM\Entity()
 */
class Vendor extends BaseEntity
{
    public const VENDOR_ID_CIANDO = 1;
    public const VENDOR_ID_VLB = 2;
    /**
     * @ORM\Column(name="label", type="string", length=255)
     */
    protected string $label = '';

}
