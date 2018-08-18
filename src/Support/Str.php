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

    public static function UUid(int $lenght = 13, string $prefix = '')
    {
        if (function_exists("random_bytes")) {
            $bytes = random_bytes(ceil($lenght / 2));
        } elseif (function_exists("openssl_random_pseudo_bytes")) {
            $bytes = openssl_random_pseudo_bytes(ceil($lenght / 2));
        } else {
            throw new Exception("no cryptographically secure random function available");
        }
        return $prefix . substr(bin2hex($bytes), 0, $lenght);
    }

    public static function getRandomNumberString(int $length)
    {
        $str = '0123456789';
        $randomString = $str[mt_rand(1, 9)];
        for($i = 1; $i < $length; $i++) {
            $randomString .= $str[mt_rand(0, 9)];
        }

        return $randomString;
    }
}
