<?php

namespace SF\Support;

class Str
{
    public static function contains($haystack, $needles)
    {
        foreach ((array)$needles as $needle) {
            if ($needle != '' && strpos($haystack, $needle) !== false) {
                return true;
            }
        }
        return false;
    }

    public static function getUniqid(string $prefix = "", bool $more_entropy = false)
    {
        return uniqid($prefix, $more_entropy);
    }
}
