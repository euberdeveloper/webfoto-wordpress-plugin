<?php

// Declare strict types
declare(strict_types=1);

// Require the vendor autoloader
require_once(__DIR__ . '/vendor/autoload.php');

// Require the core autoloader
require_once(__DIR__ . '/src/core/autoload.php');

// Require the modules
require_once(__DIR__ . '/src/settings/SettingsService.php');
require_once(__DIR__ . '/src/settings/Settings.php');
require_once(__DIR__ . '/src/injector/Injector.php');
require_once(__DIR__ . '/src/shortcode/Shortcode.php');

require_once(__DIR__ . '/src/database/DatabaseService.php');
require_once(__DIR__ . '/src/cronjob/Cronjob.php');
require_once(__DIR__ . '/src/api/Api.php');