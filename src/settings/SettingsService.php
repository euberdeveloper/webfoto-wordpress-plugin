<?php

namespace Webfoto\Wordpress;

use Carbon_Fields\Container;
use Carbon_Fields\Field;

use Webfoto\Wordpress\Settings;

class SettingsService
{

    static ?Settings $settings = null;

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
                Field::make('text', 'webfoto_output_photos_url', 'The base url, used by the last photo api'),
                Field::make('text', 'webfoto_keep_last_days', 'Keep the last n days')
            ))
            ->add_tab('Alerts', array(
                Field::make('text', 'webfoto_alert_threshold_hours', 'After how many hours of no input photos will an alert be sent via email'),
                Field::make('select', 'webfoto_email_auth_type', 'The type of email auth')
                    ->set_options([
                        'credentials' => 'Credentials',
                        'google' => 'Google (gmail)'
                    ]),
                Field::make('text', 'webfoto_email_host', 'The smtp host'),
                Field::make('text', 'webfoto_email_username', 'The email address that will send the alerts'),
                Field::make('text', 'webfoto_email_password', 'The password for the email address (if type is credentials)'),
                Field::make('text', 'webfoto_email_google_client_id', 'The client id of the sending address if auth type is google'),
                Field::make('text', 'webfoto_email_google_client_secret', 'The client secret of the sending address if auth type is google'),
                Field::make('text', 'webfoto_email_google_refresh_token', 'The refresh token of the sending address if auth type is google'),
                Field::make('text', 'webfoto_email_recipient', 'The recipient of the email alert'),
                Field::make('text', 'webfoto_email_subject', 'The subject of the email alert (use {{ALBUM}} as placeholder for the webcam)'),
                Field::make('text', 'webfoto_email_body', 'The body of the email alert (use {{ALBUM}} as placeholder for the webcam)')
            ))
            ->add_tab('Albums', array(
                Field::make('complex', 'webfoto_albums', 'The albums served by the API')
                    ->add_fields('album', array(
                        Field::make('text', 'name', 'The name of the album'),
                        Field::make('text', 'input_path', 'The path were the photos of the albums are found'),
                        Field::make('select', 'driver', 'The driver to use to handle the input photos')
                            ->set_options([
                                'dahua' => 'Dahua',
                                'hikvision' => 'Hikvision'
                            ]),
                        Field::make('text', 'keep_every_seconds', 'The lowest amount of seconds between two saved photos')
                    ))
            ));
    }

    static function fillSettings(): void
    {
        if (self::$settings === null) {
            self::$settings = new Settings();
        }
    }
}
