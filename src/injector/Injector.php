<?php

namespace Webfoto\Wordpress;

use Webfoto\Wordpress\SettingsService;

class Injector
{
    static function injectScripts(): void
    {
        $loadOnFooter = SettingsService::$settings->loadScriptsOnFooter;

        $vueUri = 'https://unpkg.com/vue';
        wp_enqueue_script('vue', $vueUri, null, false, $loadOnFooter);

        $webfotoUri = 'https://api.fotowebcam.it/webcomponent/web-foto.min.js';
        wp_enqueue_script('web-foto', $webfotoUri, null, false, $loadOnFooter);
    }
}
