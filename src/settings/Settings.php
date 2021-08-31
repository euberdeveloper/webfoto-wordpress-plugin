<?php

namespace Webfoto;

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
            ->add_fields(array(
                Field::make('checkbox', 'webfoto_load_scripts_on_footer', 'Load scripts in footer')
            ));
    }
}
