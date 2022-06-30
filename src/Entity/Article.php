<?php declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;

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
     * @var Author[]
     */
    private PersistentCollection $authors;

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
     * @ORM\OneToMany(targetEntity="App\Entity\ArticleFileCloud", mappedBy="article")
     */
    private PersistentCollection $cloudFiles;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ArticleFormat", mappedBy="article")
     */
    private PersistentCollection $formats;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ArticlePrice", mappedBy="article")
     * @ORM\OrderBy({"activeFrom" = "DESC"})
     */
    private PersistentCollection $prices;

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

    /**
     * @return PersistentCollection|ArticleFileCloud[]
     */
    public function getCloudFiles(): PersistentCollection
    {
        return $this->cloudFiles;
    }

    public function getAuthorString(): string
    {
        if($this->authors->count() === 1){
            return $this->authors->first()->getLabel();
        }
        if($this->authors->count() === 0){
            return '';
        }
        return sprintf('%s und weitere',$this->authors->first()->getLabel());
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getPrice(): ?ArticlePrice
    {
        /** @var ArticlePrice $price */
        foreach ($this->prices as $price){
            if(strtoupper($price->getCountryCode()) !== 'DE'){
                continue;
            }
            if($price->getActiveFrom()->getTimestamp() <= (new \DateTimeImmutable())->getTimestamp()){
                return $price;
            }
        }
        return null;
    }

}
