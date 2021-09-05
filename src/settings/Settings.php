<?php

namespace Webfoto\Wordpress;

class Settings
{
    public bool $loadScriptsOnFooter;

    public string $outputPhotosPath;
    public string $outputPhotosUrl;

    public array $albums;

    function __construct()
    {
        $this->loadScriptsOnFooter = carbon_get_theme_option('webfoto_load_scripts_on_footer');
        $this->outputPhotosPath = carbon_get_theme_option('webfoto_output_photos_path');
        $this->outputPhotosUrl = carbon_get_theme_option('webfoto_output_photos_url');
        $this->albums = carbon_get_theme_option('webfoto_albums');
    }
}
