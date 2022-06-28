<?php

declare(strict_types=1);

namespace App\DependencyInjection;

use App\Collection\ArticleDBALCollection;
use App\Collection\ConditionDBAL\ArticleConditionDBALInterface;
use App\Collection\ListDecoratorDBAL\ArticleListDecoratorInterface;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

final class ArticleDecoratorCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        $definition = $container->getDefinition(ArticleDBALCollection::class);
        $taggedServices = $container->findTaggedServiceIds(ArticleListDecoratorInterface::class);
        foreach ($taggedServices as $id => $service) {
            $definition->addMethodCall('addListDecorator', [new Reference($id)]);
        }
        $taggedServices = $container->findTaggedServiceIds(ArticleConditionDBALInterface::class);
        foreach ($taggedServices as $id => $service) {
            $definition->addMethodCall('addCondition', [new Reference($id)]);
        }
    }
}
