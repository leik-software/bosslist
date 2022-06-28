<?php declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\BaseEntity;
use App\Entity\TimestampableTrait;

/**
 * @ORM\Table(name="article",
 *     indexes={@ORM\Index(name="search_idx", columns={"slug", "has_cover_image"}), @ORM\Index(name="score_idx", columns={"id", "score"})}
 *     )
 * @ORM\Entity()
 */
class Article extends BaseEntity
{
    use TimestampableTrait;

    /**
     * @ORM\Column(name="slug", type="string", length=250)
     */
    protected string $slug;

    /**
     * @ORM\Column(name="title", type="string", length=255)
     */
    protected string $title = '';

    /**
     * @ORM\Column(name="subtitle", type="string", length=255)
     */
    protected string $subtitle = '';

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Author")
     * @ORM\JoinTable(name="article2author",
     *      joinColumns={@ORM\JoinColumn(name="article_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="author_id", referencedColumnName="id")}
     *      )
     */
    private iterable $authors;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Publisher")
     * @ORM\JoinTable(name="article2publisher",
     *      joinColumns={@ORM\JoinColumn(name="article_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="publisher_id", referencedColumnName="id")}
     *      )
     */
    private iterable $publishers;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Translator")
     * @ORM\JoinTable(name="article2translator",
     *      joinColumns={@ORM\JoinColumn(name="article_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="translator_id", referencedColumnName="id")}
     *      )
     */
    private iterable $translators;

    /**
     * 0 = unbekannt (neuer Artikel)
     * 1 = hat ein Bild
     * 2 = hat kein Bild von ciando bekommen, VLB ist dran
     * 3 = hat kein Bild von VLB bekommen
     * @ORM\Column(name="has_cover_image", type="integer", nullable=false, options={"default":0})
     */
    private int $hasCoverImage = 0;

    /**
     * @ORM\Column(name="score", type="decimal", precision=5, scale=2)
     */
    private float $score = 0.0;


}
