<?php

namespace Webfoto\Wordpress;

class Settings
{
    public bool $loadScriptsOnFooter;

    public string $outputPhotosPath;
    public string $outputPhotosUrl;

    public int $keepLastDays;
    public int $alertThresholdHours;

    public array $emailOptions;

    public array $albums;

    private function parseAlbumSetting(array $setting): array
    {
        return [
            'name' => $setting['name'],
            'inputPath' => $setting['input_path'],
            'driver' => $setting['driver'],
            'keepEverySeconds' => intval($setting['keep_every_seconds'])
        ];
    }

    function __construct()
    {
        $this->loadScriptsOnFooter = carbon_get_theme_option('webfoto_load_scripts_on_footer');
        $this->outputPhotosPath = carbon_get_theme_option('webfoto_output_photos_path');
        $this->outputPhotosUrl = carbon_get_theme_option('webfoto_output_photos_url');
        $this->keepLastDays = (int) carbon_get_theme_option('webfoto_keep_last_days');
        $this->alertThresholdHours = (int) carbon_get_theme_option('webfoto_alert_threshold_hours');

        $this->emailOptions = [
            'authType' => carbon_get_theme_option('webfoto_email_auth_type'),
            'host' => carbon_get_theme_option('webfoto_email_host'),
            'username' => carbon_get_theme_option('webfoto_email_username'),
            'password' => carbon_get_theme_option('webfoto_email_password'),
            'googleClientId' => carbon_get_theme_option('webfoto_email_google_client_id'),
            'googleClientSecret' => carbon_get_theme_option('webfoto_email_google_client_secret'),
            'googleRefreshToken' => carbon_get_theme_option('webfoto_email_google_refresh_token'),
            'recipient' => carbon_get_theme_option('webfoto_email_recipient'),
            'subject' => carbon_get_theme_option('webfoto_email_subject'),
            'body' => carbon_get_theme_option('webfoto_email_body')
        ];

        $this->albums = array_map(fn ($settings) => $this->parseAlbumSetting($settings), carbon_get_theme_option('webfoto_albums'));
    }
}
