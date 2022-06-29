<?php

declare(strict_types=1);

namespace App\DependencyInjection;

use App\Collection\ConditionOrm\ConditionOrmInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final class ShopServicesRegistration
{
    public static function register(ContainerBuilder $containerBuilder): void
    {
        self::registerTags($containerBuilder);
        self::registerServices($containerBuilder);
    }

    private static function registerTags(ContainerBuilder $containerBuilder): void
    {
        $containerBuilder
            ->registerForAutoconfiguration(ConditionOrmInterface::class)
            ->addTag(ConditionOrmInterface::class)
        ;
    }

    private static function registerServices(ContainerBuilder $containerBuilder): void
    {
        $containerBuilder->addCompilerPass(new ArticleDecoratorCompilerPass());
    }
}
