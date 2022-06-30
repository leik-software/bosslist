<?php

declare(strict_types=1);

namespace App\TwigExtension;

use Assert\Assertion;
use Doctrine\DBAL\Connection;
use PDO;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Throwable;
use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use function is_array;

final class CollectionSidebarTwigExtension extends AbstractExtension
{
    private ?Request $request;

    public function __construct(
        private readonly Connection $connection,
        private readonly Environment $twig,
        RequestStack $requestStack
    ) {
        $this->request = $requestStack->getCurrentRequest();
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('getSubCategories', [$this, 'getSubCategories']),
        ];
    }

    public function getSubCategories(): string
    {
        try {
            Assertion::isInstanceOf($this->request, Request::class);
            Assertion::same($this->request->attributes->get('collection-type'), 'category');
            Assertion::true(is_array($this->request->attributes->get('slug-row')));
            $currentCat = $this->request->attributes->get('slug-row');
            Assertion::keyExists($currentCat, 'id');
            $childCategories = $this->connection->executeQuery(
                <<<'SQL'
                        SELECT category.*
                        FROM category
                        INNER JOIN category child ON child.lft BETWEEN category.lft AND category.rgt
                        INNER JOIN category2article ca ON ca.category_id IN (child.id)
                        WHERE category.parent_id = ?
                        GROUP BY category.id
                        ORDER BY category.lft
                    SQL,
                [$currentCat['id']],
                [PDO::PARAM_INT]
            )->fetchAllAssociative();
            Assertion::notEmpty($childCategories);

            return $this->twig->render('/Article/Collection/SideBar/_child-categories.html.twig', ['categories' => $childCategories]);
        } catch (Throwable $exception) {
            return '';
        }
    }
}
