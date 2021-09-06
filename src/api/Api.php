<?php

namespace Webfoto\Wordpress;

use DateTime;
use Webfoto\Core\Utils\Logger;

use Webfoto\Wordpress\DatabaseService;

class Api
{
    static function getImages(string $name): array
    {
        Logger::$logger->info('Api getting images');

        Logger::$logger->debug('Api Instantiating db service');
        $db = new DatabaseService();

        Logger::$logger->debug('Api Getting images');
        $images = $db->getImages($name);
        $images = array_map(fn ($el) => $el->format(DateTime::ATOM), $images);

        Logger::$logger->info('Api getting images returning result');
        return $images;
    }
}
