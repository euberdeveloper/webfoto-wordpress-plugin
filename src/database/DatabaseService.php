<?php

namespace Webfoto\Wordpress;

use DateTime;

use Webfoto\Core\Types\Image;
use Webfoto\Core\Utils\BaseDatabaseService;

class DatabaseService extends BaseDatabaseService
{

    private $wpdb;
    private string $tableName = 'webfoto_images';
    private string $tableAlertsName = 'webfoto_alerts';

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

    private function createTableAlertsIfNotExists(): void
    {
        $this->wpdb->query("
            CREATE TABLE IF NOT EXISTS {$this->tableAlertsName} (
                id INTEGER NOT NULL AUTO_INCREMENT, 
                name VARCHAR(255) NOT NULL, 
                timestamp DATETIME,
                PRIMARY KEY (id)
            );
        ");
    }

    private function parseTimestamp(string $timestamp): DateTime
    {
        return new DateTime("{$timestamp} UTC");
    }


    function __construct()
    {
        global $wpdb;
        $this->wpdb = $wpdb;
        $this->createTableIfNotExists();
        $this->createTableAlertsIfNotExists();
    }

    public function getLastImageDate($name): ?DateTime
    {
        $row = $this->wpdb->get_row(
            "SELECT timestamp FROM {$this->tableName} WHERE name = '{$name}' ORDER BY timestamp DESC"
        );
        $data = $row->timestamp;

        return $data ? $this->parseTimestamp($data) : null;
    }

    public function getLastImagePath($name): ?string
    {

        $row = $this->wpdb->get_row(
            "SELECT path FROM {$this->tableName} WHERE name = '{$name}' ORDER BY timestamp DESC"
        );
        $data = $row->path;

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
            "SELECT timestamp FROM {$this->tableName} WHERE name = '{$name}' ORDER BY timestamp ASC"
        );


        $result = [];
        foreach ($rows as $row) {
            array_push($result, $this->parseTimestamp($row->timestamp));
        }

        return $result;
    }

    public function removeImage(string $path): void
    {
        $this->wpdb->delete(
            $this->tableName,
            [
                'path' => $path
            ]
        );
    }

    public function updateAlertIfNeeded(string $name): bool
    {
        // Get current alert timestamp if exists
        $row = $this->wpdb->get_row(
            "SELECT timestamp FROM {$this->tableAlertsName} WHERE name = '{$name}'"
        );
        $noElements = !$row;

        // Get timestamp and current timestamp
        $timestamp = $row->timestamp;
        $timestamp = $timestamp ? $this->parseTimestamp($timestamp) : null;
        $currentTimestamp = new DateTime();

        // If timestamp is older than 1 day, insert or update alert
        $isOlderThanOneDay = $timestamp === null || $timestamp->diff($currentTimestamp)->days > 1;

        if ($isOlderThanOneDay) {
            if ($noElements) {
                $this->wpdb->insert(
                    $this->tableAlertsName,
                    [
                        'name' => $name,
                        'timestamp' => $currentTimestamp->format('Y-m-d H:i:s')
                    ]
                );
            } else {
                $this->wpdb->update(
                    $this->tableAlertsName,
                    [
                        'timestamp' => $currentTimestamp->format('Y-m-d H:i:s')
                    ],
                    [
                        'name' => $name
                    ]
                );
            }
        }

        return $isOlderThanOneDay;
    }
    public function resetAlert(string $name): void
    {
        // Check if alert exists
        $row = $this->wpdb->get_row(
            "SELECT timestamp FROM {$this->tableAlertsName} WHERE name = '{$name}'"
        );
        $exists = !!$row;

        // Create alert tuple if not exists
        if (!$exists) {
            $this->wpdb->insert(
                $this->tableAlertsName,
                [
                    'name' => $name,
                    'timestamp' => null
                ]
            );
        }
        // Otherwise update its timestamp to null
        else {
            $this->wpdb->update(
                $this->tableAlertsName,
                [
                    'timestamp' => null
                ],
                [
                    'name' => $name
                ]
            );
        }
    }
}
