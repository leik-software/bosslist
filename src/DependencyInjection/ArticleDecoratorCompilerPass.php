<?php

declare(strict_types=1);

namespace App\DependencyInjection;

use App\Collection\ArticleOrmCollection;
use App\Collection\ConditionOrm\ConditionOrmInterface;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

final class ArticleDecoratorCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        $definition = $container->getDefinition(ArticleOrmCollection::class);

        $taggedServices = $container->findTaggedServiceIds(ConditionOrmInterface::class);
        foreach ($taggedServices as $id => $service) {
            $definition->addMethodCall('addCondition', [new Reference($id)]);
        }
    }
}
