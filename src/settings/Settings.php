<?php

namespace Webfoto\Wordpress;

class Settings
{
    public bool $loadScriptsOnFooter;

    public string $output_photos_path;
    public string $output_photos_url;

    public array $albums;

    function __construct()
    {
        $this->loadScriptsOnFooter = carbon_get_theme_option('webfoto_load_scripts_on_footer');
        $this->output_photos_path = carbon_get_theme_option('webfoto_output_photos_path');
        $this->output_photos_url = carbon_get_theme_option('webfoto_output_photos_url');
        $this->albums = carbon_get_theme_option('webfoto_albums');
    }
}
