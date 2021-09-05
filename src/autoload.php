<?php

// Declare strict types
declare(strict_types=1);

// Require the vendor autoloader
require_once(WEBFOTO_DIR . '/vendor/autoload.php');

// Require the core autoloader
require_once(WEBFOTO_DIR . '/src/core/autoload.php');

// Require the modules
require_once(WEBFOTO_DIR . 'src/settings/SettingsService.php');
require_once(WEBFOTO_DIR . 'src/settings/Settings.php');
require_once(WEBFOTO_DIR . 'src/injector/Injector.php');
require_once(WEBFOTO_DIR . 'src/shortcode/Shortcode.php');

require_once(WEBFOTO_DIR . 'src/database/DatabaseService.php');
require_once(WEBFOTO_DIR . 'src/cronjob/Cronjob.php');