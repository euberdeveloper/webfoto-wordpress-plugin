<?php

namespace Webfoto\Wordpress;

use Carbon_Fields\Container;
use Carbon_Fields\Field;

class Settings
{
    static function bootSettings(): void
    {
        \Carbon_Fields\Carbon_Fields::boot();
    }

    static function settingsPage(): void
    {
        Container::make('theme_options', 'Web foto')
            ->set_page_parent('options-general.php')
            ->add_tab('Includes', array(
                Field::make('checkbox', 'webfoto_load_scripts_on_footer', 'Load scripts in footer')
            ))
            ->add_tab('Outputs', array(
                Field::make('text', 'webfoto_output_photos_path', 'The path where the photos will be saved'),
                Field::make('text', 'webfoto_output_photos_url', 'The base url, used by the last photo api')
            ))
            ->add_tab('Albums', array(
                Field::make('complex', 'webfoto_albums', 'The albums served by the API')
                    ->add_fields('album', array(
                        Field::make('text', 'name', 'The name of the album'),
                        Field::make('text', 'input_path', 'The path were the photos of the albums are found'),
                        Field::make('text', 'driver', 'The driver to use to handle the input photos (dahua, hikvision)'),
                        Field::make('text', 'keep_every_seconds', 'The lowest amount of seconds between two saved photos')
                    ))
            ));
    }
}
