<?php

/**
 * Plugin Name: Webfoto
 */

// Load composer packages
require_once(plugin_dir_path(__FILE__) . '/vendor/autoload.php');

// Include packages
use Webmozart\PathUtil\Path;

// Define global vars
$webfoto_plugin_dir = plugin_dir_url(__FILE__);

// Add script to head
function webfoto_enqueue_scripts(): void
{
    global $webfoto_plugin_dir;

    $vue_path = Path::join($webfoto_plugin_dir, '_inc', 'vue.min.js');
    wp_enqueue_script('vue', $vue_path);

    $webfoto_path = Path::join($webfoto_plugin_dir, '_inc', 'web-foto.min.js');
    wp_enqueue_script('web-foto', $webfoto_path);
}
add_action('wp_enqueue_scripts', 'webfoto_enqueue_scripts');

// Add plugin shortcode
function webfoto_shortcode($atts = []): string
{
    // Change case of shortcode attributes
    $atts = array_change_key_case((array) $atts, CASE_LOWER);

    // Merge default values with given ones
    $parsed_atts = shortcode_atts(
        array(
            'apiurl' => 'http://localhost:3000',
            'name' => 'cortevalier',
            'width' => '100%',
            'spinnercolor' => 'green'
        ),
        $atts
    );

    $api_url = $parsed_atts['apiurl'] ? 'api-url="' . $parsed_atts['apiurl'] . '"' : '';
    $name = $parsed_atts['name'] ? 'name="' . $parsed_atts['name'] . '"' : '';
    $width = $parsed_atts['width'] ? 'width: ' . $parsed_atts['width'] . ';' : '';
    $spinner_color = $parsed_atts['spinnercolor'] ? 'spinner-color="' . $parsed_atts['spinnercolor'] . '"' : '';

    $result = "
        <div style=\"display: block; {$width}\">
            <web-foto {$api_url} {$name} {$spinner_color} width=\"100%\"></web-foto>
        </div>
    ";
    return $result;
}
add_shortcode('webfoto', 'webfoto_shortcode');
