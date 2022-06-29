<?php declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="author", indexes={@ORM\Index(name="search_idx", columns={"slug"})})
 * @ORM\Entity()
 */
class Author extends BaseEntity
{
    use SlugTrait;

    /**
     * @ORM\Column(name="label", type="string", length=255)
     */
    protected string $label = '';

    /**
     * @ORM\Column(name="biographical_note", type="text", nullable=false, options={"default":""})
     */
    protected string $biographicalNote = '';

    public function getLabel(): string
    {
        return $this->label;
    }

}
