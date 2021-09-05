<?php

/**
 * Plugin Name: Webfoto
 */


// Define the plugin directory
define('WEBFOTO_DIR', plugin_dir_path(__FILE__));

// Add autoloader
require_once WEBFOTO_DIR . 'src/autoload.php';

// Import the modules

use Webfoto\Wordpress\Shortcode;
use Webfoto\Wordpress\Settings;
use Webfoto\Wordpress\Injector;

// Add settings page

function webfoto_load_carbon_fields()
{
    Settings::bootSettings();
}
add_action('after_setup_theme', 'webfoto_load_carbon_fields');
function webfoto_add_plugin_settings_page()
{
    Settings::settingsPage();
}
add_action('carbon_fields_register_fields', 'webfoto_add_plugin_settings_page');

// Add script to head
function webfoto_enqueue_scripts(): void
{
    Injector::injectScripts();   
}
add_action('wp_enqueue_scripts', 'webfoto_enqueue_scripts');


// Add shortcode
function webfoto_shortcode($atts = []): string
{
    return Shortcode::executeShortcode($atts);
}
add_shortcode('webfoto', 'webfoto_shortcode');
