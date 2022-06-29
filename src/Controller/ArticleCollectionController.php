<?php

declare(strict_types=1);

namespace App\Controller;

use App\Collection\ArticleCollectionInterface;
use App\Collection\ArticleCollectionRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @see \App\EventSubscriber\ArticleCollectionCheckEventSubsciber::onKernelController
 * @Route("/a/tag/{slug}", name="articles-by-tag")
 * @Route("/a/cat/{slug}", name="articles-by-category")
 * @Route("/a/publisher/{slug}", name="articles-by-publisher")
 * @Route("/a/author/{slug}", name="articles-by-author")
 * @Route("/a/article-list/{slug}", name="articles-by-article_list")
 */
final class ArticleCollectionController extends AbstractController
{
    public function __construct(
        private readonly ArticleCollectionInterface $articleCollection
    ) {}

    public function __invoke(string $slug, Request $request): Response
    {
        $articleCollection = $this->articleCollection->getCollection(
            new ArticleCollectionRequest(
                abs($request->query->getInt('l', 100)),
                abs($request->query->getInt('p', 1)),
                $request->query->has('inf'),
                $request->isXmlHttpRequest()
            )
        );

        return $this->render('Article/Collection/default.html.twig', ['articleCollection' => $articleCollection]);
    }
}
