<?php

namespace Webfoto\Wordpress;

use DateTime;

use Webfoto\Core\Types\Image;
use Webfoto\Core\Utils\BaseDatabaseService;

class DatabaseService extends BaseDatabaseService
{

    private $wpdb;
    private string $tableName = 'webfoto_images';

    private function createTableIfNotExists(): void
    {

        $this->wpdb->query("
            CREATE TABLE IF NOT EXISTS {$this->tableName} (
                id INTEGER NOT NULL AUTO_INCREMENT, 
                name VARCHAR(255) NOT NULL, 
                path VARCHAR(1000) NOT NULL,
                timestamp DATETIME NOT NULL,
                PRIMARY KEY (id)
            );
        ");

        // TODO: add index by solving IF NOT EXISTS
        /*
            ALTER TABLE images
            ADD INDEX images_name_index(name)
            USING HASH;
        */
    }

    private function parseTimestamp(string $timestamp): DateTime {
        return new DateTime("{$timestamp} UTC");
    }


    function __construct()
    {
        global $wpdb;
        $this->wpdb = $wpdb;
        $this->createTableIfNotExists();
    }

    public function getLastImageDate($name): ?DateTime
    {
        $rows = $this->wpdb->get_row(
            "SELECT timestamp FROM {$this->tableName} ORDER BY timestamp DESC WHERE name = {$name}"
        );
        $data = $rows->timestamp;

        return $data ? $this->parseTimestamp($data) : null;
    }

    public function getLastImagePath($name): ?string
    {

        $rows = $this->wpdb->get_row(
            "SELECT path FROM {$this->tableName} ORDER BY timestamp DESC WHERE name = {$name}"
        );
        $data = $rows->path;

        return $data ?? null;
    }

    public function insertImage(Image $image): void
    {
        $this->wpdb->insert(
            $this->tableName,
            [
                'name' => $image->name,
                'path' => $image->path,
                'timestamp' => $image->timestamp->format('Y-m-d H:i:s')
            ]
        );
    }

    public function getImages(string $name): array
    {
        $rows = $this->wpdb->get_results(
            "SELECT timestamp FROM {$this->tableName} ORDER BY timestamp ASC WHERE name = {$name}"
        );

       
        $result = [];
        foreach ($rows as $row) {
            array_push($result, $this->parseTimestamp($row->timestamp));
        }

        return $result;
    }
}
