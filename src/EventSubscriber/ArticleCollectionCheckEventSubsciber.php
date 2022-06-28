<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use App\Controller\ArticleCollectionController;
use Assert\Assertion;
use Doctrine\DBAL\Connection;
use Nette\Utils\Strings;
use PDO;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Routing\RouterInterface;
use Throwable;
use Twig\Environment;

final class ArticleCollectionCheckEventSubsciber implements EventSubscriberInterface
{
    private SessionInterface|Session $session;

    public function __construct(
        private readonly Connection $connection,
        private readonly RouterInterface $router,
        SessionInterface $session,
        private readonly Environment $environment
    ) {
        $this->session = $session;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::CONTROLLER => 'onKernelController',
        ];
    }

    public function onKernelController(ControllerEvent $event): void
    {
        $controller = $event->getController();
        if (!$controller instanceof ArticleCollectionController) {
            return;
        }
        $request = $event->getRequest();
        try {
            if ('articles-by-search' === $request->attributes->get('_route')) {
                $sword = $request->query->get('sword');
                if ($sword !== strip_tags($sword)) {
                    $homeRoute = $this->router->generate('home');
                    $this->session->getFlashBag()->add('warning', 'Der Suchbegriff enthält unerlaubte Zeichen');
                    $event->setController(static fn () => new RedirectResponse($homeRoute));
                }
                $request->attributes->set('sword', $sword);
                $request->attributes->set('_route_params', ['slug' => $sword]);

                return;
            }
            if (Strings::startsWith($request->attributes->get('_route'), 'articles-by-')) {
                $this->prepareCollectionByTable($event->getRequest());
            }
        } catch (Throwable $exception) {
            $notFoundPage = $this->environment->render('/Exception/404.html.twig', ['errorMessage' => $exception->getMessage()]);
            $event->setController(static fn () => new Response($notFoundPage, 404));
        }
    }

    private function prepareCollectionByTable(Request $request): void
    {
        $route = explode('-', $request->attributes->get('_route'));
        $tableName = array_pop($route);
        $slug = $this->getSlug($request);
        $this->checkSlug($slug, $tableName, $request);
        $request->attributes->set(sprintf('%s-slug', $tableName), $slug);
        $request->attributes->set('collection-type', $tableName);
    }

    private function checkSlug(string $slug, string $tableName, Request $request): void
    {
        $row = $this->connection->executeQuery(
            <<<SQL
                    SELECT * FROM $tableName WHERE slug = ?
                SQL,
            [$slug], [PDO::PARAM_STR]
        )->fetchAssociative();
        Assertion::notEmpty($row);
        if (isset($row['title'])) {
            $row['label'] = $row['title'];
        }
        $request->attributes->set('slug-row', $row);
    }

    private function getSlug(Request $request): string
    {
        $params = $request->attributes->get('_route_params');
        Assertion::isArray($params);
        Assertion::keyExists($params, 'slug');

        return $params['slug'];
    }
}
