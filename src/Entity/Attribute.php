<?php declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\BaseEntity;
use App\Entity\SlugTrait;

/**
 * @ORM\Table(name="attribute")
 * @ORM\Entity()
 */
class Attribute extends BaseEntity
{
    use SlugTrait;
    public const ATTR_NUMPAGES = 'Anzahl Seiten';
    public const ATTR_BOOKSIZE_EPUB = 'Dateigröße epub';
    public const ATTR_BOOKSIZE_PDF = 'Dateigröße PDF';
    public const ATTR_RELEASEYEAR = 'Erscheinungsjahr';
    public const ATTR_EDITION = 'Edition';
    public const ATTR_DRM = 'Kopierschutz';
    public const ATTR_DEVICES = 'Geräte';
    public const ATTR_AGEFROM = 'Alter von';
    public const ATTR_AGETO = 'Alter bis';
    public const ATTR_LANG = 'Sprache';
    public const ATTR_WIDGET = 'Widget';

    /**
     * @ORM\Column(name="label", type="string", length=255, unique=true)
     */
    protected string $label = '';

}
