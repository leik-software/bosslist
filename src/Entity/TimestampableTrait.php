<?php

declare(strict_types=1);

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

trait TimestampableTrait
{
    use CreatedAtTrait;

    /**
     * @ORM\Column(name="updated_at", type="datetime", nullable=false, precision=6, options={"default": "CURRENT_TIMESTAMP(6)"})
     */
    protected DateTime $updated_at;

    public function getUpdatedAt(): DateTime
    {
        return $this->updated_at;
    }

}
