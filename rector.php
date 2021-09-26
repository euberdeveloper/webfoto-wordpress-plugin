<?php

declare(strict_types=1);

use Rector\Core\Configuration\Option;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Rector\Set\ValueObject\DowngradeSetList;

return static function (ContainerConfigurator $containerConfigurator): void {
    $parameters = $containerConfigurator->parameters();
    $parameters->set(Option::PATHS, [
        __DIR__ . '/src/core/src',
        __DIR__ . '/src/core/autoload.php',
        __DIR__ . '/src/api',
        __DIR__ . '/src/cronjob',
        __DIR__ . '/src/database',
        __DIR__ . '/src/injector',
        __DIR__ . '/src/settings',
        __DIR__ . '/src/shortcode',
        __DIR__ . '/autoload.php',
        __DIR__ . '/webfoto.php'
    ]);
    $parameters->set(Option::BOOTSTRAP_FILES, [
        __DIR__ . '/autoload.php',
    ]);

    $containerConfigurator->import(DowngradeSetList::PHP_53);
    $containerConfigurator->import(DowngradeSetList::PHP_70);
    $containerConfigurator->import(DowngradeSetList::PHP_71);
    $containerConfigurator->import(DowngradeSetList::PHP_72);
    $containerConfigurator->import(DowngradeSetList::PHP_73);
    $containerConfigurator->import(DowngradeSetList::PHP_74);
    $containerConfigurator->import(DowngradeSetList::PHP_80);
};
