<?php

/**
 * Plugin Name: Webfoto
 * Plugin URI: https://api.fotowebcam.it
 * Description: Webfoto is a plugin that allows you to integrate periodically photos into your Wordpress site
 * Version: 1.0.0
 * Author: Eugenio Berretta
 * Author URI: https://github.com/euberdeveloper
 * License: GPLv2 or later
 * Text Domain: webfoto
 */


// Define the plugin directory
define('WEBFOTO_DIR', plugin_dir_path(__FILE__));

// Add autoloader
require_once WEBFOTO_DIR . 'src/autoload.php';

// Import the modules

use Webfoto\Wordpress\Shortcode;
use Webfoto\Wordpress\Injector;
use Webfoto\Wordpress\SettingsService;
use Webfoto\Wordpress\Cronjob;
use Webfoto\Wordpress\Api;


// Add settings page
function webfoto_load_carbon_fields()
{
    SettingsService::bootSettings();
}
add_action('after_setup_theme', 'webfoto_load_carbon_fields');
function webfoto_add_plugin_settings_page()
{
    SettingsService::settingsPage();
}
add_action('carbon_fields_register_fields', 'webfoto_add_plugin_settings_page');

function webfoto_get_settings()
{
    SettingsService::fillSettings();
}
add_action('carbon_fields_fields_registered', 'webfoto_get_settings');

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

// Add cronjob hook
function webfoto_cron_job_handler(): void
{
    Cronjob::executeCron();
}
add_action('webfoto_cron_job', 'webfoto_cron_job_handler');

// Add api endpoints
function webfoto_api_get_images(WP_REST_Request $req): array
{
    return Api::getImages($req->get_param('name'));
}
function webfoto_api_get_last_image_url(WP_REST_Request $req): string
{
    return Api::getLastImageUrl($req->get_param('name'));
}
add_action('rest_api_init', function () {
    register_rest_route('webfoto/v1', '/api/albums/(?P<name>\w+)/images', array(
        'methods' => 'GET',
        'callback' => 'webfoto_api_get_images',
    ));
    register_rest_route('webfoto/v1', '/api/albums/(?P<name>\w+)/images/latest', array(
        'methods' => 'GET',
        'callback' => 'webfoto_api_get_last_image_url',
    ));
});
