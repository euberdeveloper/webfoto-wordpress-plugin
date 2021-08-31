<?php

/**
 * Plugin Name: Webfoto
 */


// Define the plugin directory
define('WEBFOTO_DIR', plugin_dir_path(__FILE__));

// Add autoloader
require_once WEBFOTO_DIR . 'src/autoload.php';

use Webfoto\Shortcode;

// Add script to head
function webfoto_enqueue_scripts(): void
{
    $vue_path = 'https://unpkg.com/vue';
    wp_enqueue_script('vue', $vue_path);

    $webfoto_path = 'https://api.fotowebcam.it/webcomponent/web-foto.min.js';
    wp_enqueue_script('web-foto', $webfoto_path);
}
add_action('wp_enqueue_scripts', 'webfoto_enqueue_scripts');


// Add shortcode
function webfoto_shortcode($atts = []): string
{
    return Shortcode::executeShortcode($atts);
}
add_shortcode('webfoto', 'webfoto_shortcode');
