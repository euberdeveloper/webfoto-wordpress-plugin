<?php

namespace Webfoto\Wordpress;

use Webfoto\Core\Utils\ImagesHandler;
use Webfoto\Core\Utils\Logger;

use Webfoto\Wordpress\SettingsService;
use Webfoto\Wordpress\DatabaseService;

class Cronjob
{
    static function executeCron(): void
    {
        Logger::$logger->info('Executing cronjob');

        $settings = SettingsService::$settings;

        Logger::$logger->debug('Creating db service');
        $db = new DatabaseService();

        foreach ($settings->albums as $album) {
            Logger::$logger->info("Handling {$album['name']}");
            $handler = new ImagesHandler($album, $settings->outputPhotosPath, $db, get_theme_root());
            $handler->handle();
        }

        Logger::$logger->info('Executed cronjob');
    }
}
