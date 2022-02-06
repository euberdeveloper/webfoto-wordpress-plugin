# webfoto-wordpress-plugin

This is the wordpress plugin of the project "Webfoto".

## The project

The "Webfoto" project's purpose is to put some cameras, that take a photo every a certain amount of time, in some hotels, so that a web component can show the timeline of the view of that hotel in the hotel's website.

## The wordpress backend

The wordpress plugin unifies both the webcomponent and the php backend in a single plugin, so that it can be used with wordpress by almost anyone.

## What does it exactly do

What it provides is:
* A configuration page that contains both the `.env` and the `settings.json` options of the php backend. There is an additional option that allows you to choose if you want to import the webcomponent in the header or in the footer of the html page.
* A shortcode `webfoto` that has exactly the same properties of the webcomponent
* A php hook that does the same that is done by the php backend's cronjob
* A worpress api endpoits that do the same that the php backend's cronjob would do

## How to use it

To use it:
1. Create a wordpress project
2. Install the plugin (or add its folder directly in the `plugins` folder)
3. Activate the plugin
4. Go to the settings page (Settings/WebFoto) and update them referencing to the [php backend readme](https://github.com/Dev-digitalgarda/webfoto-php-backend)
5. Periodically call the cronjob-hook `webfoto_cron_job`, a very good way of doing it would be by using the `wp control` plugin
6. Add a shortcode `webcomponent`, the api-url should point to `/wp-json/webfoto/v1` of your wordpress site and the other properties are the same of the [webcomponent](https://github.com/Dev-digitalgarda/webfoto-webcomponent)
## Automatic deploy

The deploy is actually automatically handled through a **github action**.

The github action:
1. Starts an ubuntu docker container
2. Adds php and composer
3. Installs the dependencies
4. Uses rector to downgrade the php version
5. Compresses the code
6. Gets the composer.json version
7. Pulishes a new release with that version and with the compressed plugin

## Were is the generated plugin?

Every automatic deploy creates a **[new release](https://github.com/Dev-digitalgarda/webfoto-wordpress-plugin/releases)**. In that release, there is attached a compressed (.tar.gz) file containing the generated plugin.

## How should I contribute

Whoever will contribute and work on this code:

1. Should install locally **php**, **composer** 
2. Clone the project and checkout on the **dev branch**
3. Change the code
4. Add the submodule with `composer run pull-core`
5. Test locally the changes
6. Push the code **on dev**
7. Only when you want a new release to be published, you should **update the version in composer.json and merge the dev branch into main**
