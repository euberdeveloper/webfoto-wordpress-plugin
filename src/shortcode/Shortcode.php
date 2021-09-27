<?php

namespace Webfoto\Wordpress;

class Shortcode
{
    private static $attributes = [
        [
            'name' => 'name',
            'type' => 'string',
            'required' => true
        ],
        [
            'name' => 'api-url',
            'type' => 'string',
            'required' => true
        ],
        [
            'name' => 'images-url',
            'type' => 'string',
            'required' => true
        ],
        [
            'name' => 'width',
            'type' => 'string',
            'required' => false
        ],
        [
            'name' => 'height',
            'type' => 'string',
            'required' => false
        ],
        [
            'name' => 'show-spinner',
            'type' => 'boolean',
            'required' => false
        ],
        [
            'name' => 'spinner-color',
            'type' => 'string',
            'required' => false
        ],
        [
            'name' => 'logo-src',
            'type' => 'string',
            'required' => false
        ],
        [
            'name' => 'logo-href',
            'type' => 'string',
            'required' => false
        ],
        [
            'name' => 'logo-width',
            'type' => 'string',
            'required' => false
        ],
        [
            'name' => 'logo-width-mobile',
            'type' => 'string',
            'required' => false
        ],
        [
            'name' => 'min-zindex',
            'type' => 'string',
            'required' => false
        ],
        [
            'name' => 'legacy-time-lapse',
            'type' => 'boolean',
            'required' => false
        ],
        [
            'name' => 'time-lapse-max-items',
            'type' => 'number',
            'required' => false
        ],
        [
            'name' => 'youtube-id',
            'type' => 'string',
            'required' => false
        ]
    ];

    private static function attributeToString(string $name, ?string $value, string $type): ?string
    {
        if ($value === null) {
            return null;
        }

        return match ($type) {
            'string', 'number' => "{$name}=\"{$value}\"",
            'boolean' => $value ? "{$name}" : null,
            default => null
        };
    }

    private static function getAttributesDefaults(): array
    {
        $result = [];

        foreach (self::$attributes as $attr) {
            $result[$attr['name']] = null;
        }

        return $result;
    }

    private static function getAttributes(array $parsedAttrs): array
    {
        return array_filter(array_map(function ($el) use ($parsedAttrs) {
            $name = $el['name'];
            $value = $parsedAttrs[$name];
            $type = $el['type'];
            
            return self::attributeToString($name, $value, $type);
        }, self::$attributes));
    }

    static function executeShortcode(array $atts = []): string
    {
        $atts = array_change_key_case((array) $atts, CASE_LOWER);

        $parsedAttrs = shortcode_atts(
            self::getAttributesDefaults(),
            $atts
        );

        $strAttrs = implode(' ', self::getAttributes($parsedAttrs));

        $result = "<web-foto {$strAttrs} style=\"display: block\"></web-foto>";

        return $result;
    }
}
