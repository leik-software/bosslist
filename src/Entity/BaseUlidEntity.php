<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\MappedSuperclass()
 */
abstract class BaseUlidEntity
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\Column(type="string", length=26, nullable=false, name="ulid")
     */
    protected string $ulid;

    public function getUlid(): string
    {
        return $this->ulid;
    }

}
