<?php declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\BaseEntity;
use App\Entity\TimestampableTrait;

/**
 * @ORM\Table(name="article_format",
 *     uniqueConstraints={@ORM\UniqueConstraint(name="unique_entry", columns={"article_id", "vendor_id", "format", "extern_id"})},
 *     indexes={@ORM\Index(name="IDX_B47DE55FEBD1F0C", columns={"extern_id", "format"}), @ORM\Index(name="isbn", columns={"isbn13", "statuscode"})})
 * @ORM\Entity()
 */
class ArticleFormat extends BaseEntity
{
    use TimestampableTrait;

    public const FORMAT_EPUB = 'epub';
    public const FORMAT_PDF = 'pdf';
    
    public const DRM_ADOBE = 'adobe';
    public const DRM_WATERMARK = 'watermark';
    public const DRM_FREE = 'free';
    
    public const PRESENTATION_DL = 'dl';
    public const PRESENTATION_OL = 'ol';
    
    public const COPY_ALL = 'all';
    public const COPY_PARTIAL = 'partial';
    public const COPY_NONE = 'none';
    
    public const PRINT_ALL = 'all';
    public const PRINT_PARTIAL = 'partial';
    public const PRINT_NONE = 'none';
    
    /**
     * @ORM\ManyToOne(targetEntity="Article", inversedBy="formats")
     * @ORM\JoinColumn(name="article_id", referencedColumnName="id")
     */
    protected Article $article;

    /**
     * @ORM\ManyToOne(targetEntity="Vendor")
     * @ORM\JoinColumn(name="vendor_id", referencedColumnName="id")
     */
    protected Vendor $vendor;

    /**
     * @ORM\Column(name="isbn13", type="string", length=13)
     */
    protected string $isbn13 = '';

    /**
     * @ORM\Column(name="format", type="string", length=10)
     */
    protected string $format = '';

    /**
     * adobe = ADOBE DRM
     * watermark = Wasserzeichenschutz
     * fileopen = File Open DRM
     * free = ungeschützt
     *
     * @ORM\Column(name="drm", type="string", length=10)
     */
    protected string $drm = '';

    /**
     * dl = download
     * ol = online lesen
     * @ORM\Column(name="presentation", type="string", length=2)
     */
    protected string $presentation = '';

    /**
     * all = der Inhalt des gesamten Dokuments kann herauskopiert werden
     * none = es darf nichts herauskopiert werden
     * partial = es kann teilweise herauskopiert werden - in 7 Tagen 10% der Buchseiten
     * @ORM\Column(name="copy", type="string", length=10)
     */
    protected string $copy = '';

    /**
     * all = der Inhalt des gesamten Dokuments kann gedruckt werden
     * none = es darf nichts gedruckt werden
     * partial = es kann teilweise gedruckt werden
     * @ORM\Column(name="print", type="string", length=10)
     */
    protected string $print = '';

    /**
     * Anzahl der Downloads je eBook
     * @ORM\Column(name="downloads", type="integer")
     */
    protected int $downloads = 0;

    /**
     * Maximale Anzahl der Lesegeräte, auf denen das eBook pro Kauf gelesen werden kann
     * @ORM\Column(name="max_devices", type="integer")
     */
    protected int $maxDevices = 0;

    /**
     * @ORM\Column(name="ciando_iscp", type="string", length=10)
     */
    protected string $ciandoIscp = '';

    /**
     * @ORM\Column(name="extern_id", type="integer")
     */
    protected int $externId = 0;

    /**
     * Der Rabatt, der dem Händler gewährt wird in %.
     * Z.B. 25%: Vom Nettoverkaufspreis werden 75% abgerechnet, 25% bleiben beim Händler als Gewinn
     * @ORM\Column(name="discount", type="float")
     */
    protected float $discount = 0.0;

    /**
     * @ORM\Column(name="delivery_date", type="date", nullable=true)
     */
    protected \DateTime $deliveryDate;

    /**
     * @ORM\Column(name="fsk", type="integer", nullable=true)
     */
    protected ?int $fsk = 0;

    /**
     * 0 = Verkauf verboten, Download verboten
     * 1 = Verkauf erlaubt, Download erlaubt
     * 2 = Verkauf verboten, Download erlaubt
     * @ORM\Column(name="statuscode", type="integer")
     */
    protected int $statuscode = 0;

    /**
     * @ORM\Column(name="agency_model", type="integer")
     */
    protected int $agencyModel = 0;



}
