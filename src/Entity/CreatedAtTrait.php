<?php
declare(strict_types=1);

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

trait CreatedAtTrait
{
    /**
     * @ORM\Column(name="created_at", type="datetime", nullable=false, precision=6, options={"default": "CURRENT_TIMESTAMP(6)"})
     */
    protected DateTime $created_at;

    public function getCreatedAt(): DateTime
    {
        return $this->created_at;
    }
}
