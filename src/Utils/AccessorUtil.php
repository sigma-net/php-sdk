<?php

namespace SigmaNet\SDK\Utils;

class AccessorUtil
{
    public static function property($text): string
    {
        $text = strtolower($text);

        return lcfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', $text))));
    }

    public static function getter($text): string
    {
        return 'get' . ucfirst(self::property($text));
    }

    public static function isser($text): string
    {
        return 'is' . ucfirst(self::property($text));
    }

    public static function adder($text): string
    {
        return 'add' . ucfirst(self::property($text));
    }
}
