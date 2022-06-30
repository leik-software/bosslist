<?php

declare(strict_types=1);

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="article_list", indexes={
 *     @ORM\Index(columns={"label"}, flags={"fulltext"}),
 *     @ORM\Index(columns={"slug"}, flags={"fulltext"})
 * })
 * @ORM\Entity()
 */
class ArticleList extends BaseEntity
{
    use SlugTrait, TimestampableTrait;

    /**
     * @ORM\Column(name="label", type="string", length=255, nullable=false)
     */
    private string $label;

    /**
     * @ORM\Column(name="new_releases", type="boolean", nullable=false, options={"default":false})
     */
    private bool $newReleases = false;

    /**
     * @ORM\Column(name="new_releases_from", type="date", nullable=true)
     */
    private ?DateTime $newReleasesFrom;

    /**
     * @ORM\Column(name="new_releases_to", type="date", nullable=true)
     */
    private ?DateTime $newReleasesTo;



    public function __construct(string $label, string $slug)
    {
        $this->label = $label;
        $this->setSlug($slug);
        $this->created_at = new DateTime();
        $this->updated_at = new DateTime();
    }

    public function update(string $label, string $slug): void
    {
        $this->label = $label;
        $this->slug = $slug;
        $this->updated_at = new DateTime();
    }

    public function getLabel(): string
    {
        return $this->label;
    }


}
