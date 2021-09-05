<?php

namespace Webfoto\Wordpress;

class Injector
{
    static function injectScripts(): void
    {
        $loadOnFooter = carbon_get_theme_option('webfoto_load_scripts_on_footer');

        $vueUri = 'https://unpkg.com/vue';
        wp_enqueue_script('vue', $vueUri, null, false, $loadOnFooter);

        $webfotoUri = 'https://api.fotowebcam.it/webcomponent/web-foto.min.js';
        wp_enqueue_script('web-foto', $webfotoUri, null, false, $loadOnFooter);
    }
}
