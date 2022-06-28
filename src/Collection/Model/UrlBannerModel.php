<?php
declare(strict_types=1);

namespace App\Collection\Model;

final class UrlBannerModel
{
    private string $headline;
    private string $description;
    private string $mobileUrl;
    private string $desktopUrl;
    private array $breadcrumb=[];

    public function __construct(string $headline, string $description, string $mobileUrl, string $desktopUrl)
    {
        $this->headline = $headline;
        $this->description = $description;
        $this->mobileUrl = $mobileUrl;
        $this->desktopUrl = $desktopUrl;
    }

    public function getBreadcrumb(): array
    {
        return $this->breadcrumb;
    }

    public function setBreadcrumb(array $breadcrumb): void
    {
        $this->breadcrumb = $breadcrumb;
    }

    public function setHeadline(string $headline): void
    {
        $this->headline = $headline;
    }


    public function getHeadline(): string
    {
        return $this->headline;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getMobileUrl(): string
    {
        return $this->mobileUrl;
    }

    public function getDesktopUrl(): string
    {
        return $this->desktopUrl;
    }


}
