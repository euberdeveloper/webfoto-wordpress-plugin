<?php

namespace Webfoto\Wordpress;

use DateTime;
use Webfoto\Core\Utils\Logger;

use Webfoto\Wordpress\DatabaseService;
use Webfoto\Wordpress\SettingsService;

class Api
{
    static function getImages(string $name): array
    {
        Logger::$logger->info('Api getting images', [$name]);

        Logger::$logger->debug('Api Instantiating db service');
        $db = new DatabaseService();

        Logger::$logger->debug('Api Getting images');
        $images = $db->getImages($name);
        $images = array_map(fn ($el) => $el->format(DateTime::ATOM), $images);

        Logger::$logger->info('Api getting images returning result', [$name]);
        return $images;
    }
    static function getLastImageUrl(string $name): string
    {
        Logger::$logger->info('Api getting last image url', [$name]);

        Logger::$logger->debug('Api Instantiating db service');
        $db = new DatabaseService();

        Logger::$logger->debug('Api Getting last image url');
        $path = $db->getLastImagePath($name);
        $outputPhotosUri = SettingsService::$settings->outputPhotosUrl;
        $fotosUri = substr($outputPhotosUri, -1) !== '/' ? $outputPhotosUri : substr($outputPhotosUri, 0, -1);
        $imageLink = "{$fotosUri}{$path}";

        Logger::$logger->info('Api getting images url returning result', [$name]);
        return $imageLink;
    }
}
