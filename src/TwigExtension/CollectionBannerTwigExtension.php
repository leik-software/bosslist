<?php

declare(strict_types=1);

namespace App\TwigExtension;

use App\Collection\Model\UrlBannerModel;
use App\Helper\StringHelper;
use Doctrine\DBAL\Connection;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

final class CollectionBannerTwigExtension extends AbstractExtension
{
    private ?Request $request;
    private Connection $connection;

    public function __construct(
        RequestStack $requestStack,
        Connection $connection
    )
    {
        $this->request = $requestStack->getCurrentRequest();
        $this->connection = $connection;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('findUrlBanner', [$this, 'findUrlBanner']),
        ];
    }

    private function getBreadCrumb(int $currentCategoryId): array
    {
        return $this->connection->executeQuery(
            <<<SQL
                SELECT p.*
                FROM category n, category p
                WHERE n.lft BETWEEN p.lft AND p.rgt
                AND n.id = ?
                ORDER BY n.lft;
            SQL,
            [$currentCategoryId],
            [\PDO::PARAM_INT]
        )->fetchAllAssociative();

    }

    private function getDefaultUrlBannerModel(): UrlBannerModel
    {
        $bannerModel = new UrlBannerModel(
            $this->request->attributes->get('slug-row')['label'] ?? '',
            $this->request->attributes->get('slug-row')['biographical_note'] ?? '',
            'https://komfortshop.s3.eu-central-1.amazonaws.com/banner/detailseite_mobil_800x175px_standardbanner_fliegende_buecher.jpg',
            'https://komfortshop.s3.eu-central-1.amazonaws.com/banner/detailseite_desktop_1955x275px_standardbanner_fliegende_buecher.jpg'
        );
        $this->addLabelIfEmpty($bannerModel);
        return $bannerModel;
    }

    public function findUrlBanner(): UrlBannerModel
    {
        if('category' === $this->request->attributes->get('collection-type')){

            $urlBannerModel = $this->getDefaultUrlBannerModel();
            $urlBannerModel->setBreadcrumb($this->getBreadCrumb((int)$this->request->attributes->get('slug-row')['id']));
            $this->addLabelIfEmpty($urlBannerModel);
            return $urlBannerModel;
        }
        return $this->getDefaultUrlBannerModel();

    }

    private function addLabelIfEmpty(UrlBannerModel $bannerModel): void
    {
        if(StringHelper::endsWith($this->request->attributes->get('_route'), 'tag')){
            $bannerModel->setHeadline(sprintf('Bücher zum Stichwort "%s"', $this->request->attributes->get('slug-row')['label'] ?? ''));
            return;
        }
        if(StringHelper::endsWith($this->request->attributes->get('_route'), 'publisher')){
            $bannerModel->setHeadline(sprintf('Bücher vom Verlag %s', $this->request->attributes->get('slug-row')['label'] ?? ''));
            return;
        }
        if(StringHelper::endsWith($this->request->attributes->get('_route'), 'author')){
            $bannerModel->setHeadline(sprintf('Bücher von %s', $this->request->attributes->get('slug-row')['label'] ?? ''));
            return;
        }
        if(StringHelper::endsWith($this->request->attributes->get('_route'), 'list')){
            $bannerModel->setHeadline($this->request->attributes->get('slug-row')['label']);
            return;
        }
        if(StringHelper::endsWith($this->request->attributes->get('_route'), 'series')){
            $bannerModel->setHeadline(sprintf('Buchreihe "%s"', $this->request->attributes->get('slug-row')['label'] ?? ''));
            return;
        }
        if(StringHelper::endsWith($this->request->attributes->get('_route'), 'classification') && $this->request->attributes->get('slug-row')['classification_type'] === 'time_period'){
            $bannerModel->setHeadline(sprintf('Bücher zum Handlungszeitpunkt "%s"', $this->request->attributes->get('slug-row')['label'] ?? ''));
            return;
        }
        if(StringHelper::endsWith($this->request->attributes->get('_route'), 'classification') && $this->request->attributes->get('slug-row')['classification_type'] === 'subject'){
            $bannerModel->setHeadline(sprintf('Bücher zum Stichwort "%s"', $this->request->attributes->get('slug-row')['label'] ?? ''));
            return;
        }
        if(StringHelper::endsWith($this->request->attributes->get('_route'), 'classification') && $this->request->attributes->get('slug-row')['classification_type'] === 'other-23'){
            $bannerModel->setHeadline(sprintf('Bücher zum Stichwort "%s"', $this->request->attributes->get('slug-row')['label'] ?? ''));
            return;
        }
        if(StringHelper::endsWith($this->request->attributes->get('_route'), 'classification') && $this->request->attributes->get('slug-row')['classification_type'] === 'place'){
            $bannerModel->setHeadline(sprintf('Bücher zum Handlungsort "%s"', $this->request->attributes->get('slug-row')['label'] ?? ''));
            return;
        }
        if(StringHelper::endsWith($this->request->attributes->get('_route'), 'classification') && $this->request->attributes->get('slug-row')['classification_type'] === 'age'){
            $bannerModel->setHeadline(sprintf('Bücher für Zielgruppe "%s"', $this->request->attributes->get('slug-row')['label'] ?? ''));
            return;
        }
        if(StringHelper::endsWith($this->request->attributes->get('_route'), 'classification') && $this->request->attributes->get('slug-row')['classification_type'] === 'education'){
            $bannerModel->setHeadline(sprintf('Bücher für Bildungszweck "%s"', $this->request->attributes->get('slug-row')['label'] ?? ''));
            return;
        }
        if(empty($bannerModel->getHeadline()) && $this->request->attributes->has('slug-row')){
            $bannerModel->setHeadline($this->request->attributes->get('slug-row')['label'] ?? '');
        }
    }
}
