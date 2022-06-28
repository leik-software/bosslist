<?php declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\CreatedAtTrait;

/**
 * @ORM\Table(name="article_file_cloud")
 * @ORM\Entity()
 */
class ArticleFileCloud
{
    use CreatedAtTrait;

    /**
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="Article")
     * @ORM\JoinColumn(name="article_id", referencedColumnName="id")
     */
    protected Article $article;

    /**
     * @ORM\Column(name="aws_url_detail", type="string", length=255, options={"default":""})
     */
    private string $awsUrlDetail = '';

    /**
     * @ORM\Column(name="aws_url_thumb", type="string", length=255, options={"default":""})
     */
    private string $awsUrlThumb = '';

    /**
     * @ORM\Column(name="aws_url_icon", type="string", length=255, options={"default":""})
     */
    private string $awsUrlIcon = '';

    /**
     * @ORM\Column(name="blur_hash", type="string", length=255, options={"default":""})
     */
    private string $blurHash = '';

}
