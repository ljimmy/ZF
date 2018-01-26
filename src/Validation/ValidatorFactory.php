<?php

namespace SF\Validation;


class ValidatorFactory
{
    const BOOLEAN = 'boolean';
    const EMAIL   = 'email';

    const Validator = [
        'boolean' => Boolean::class,
        'email'   => Email::class,
        'inline'  => Inline::class,
        'integer' => Integer::class,
        'ip'      => Ip::class,
        'regexp'  => Regexp::class,
        'url'     => Url::class,
    ];

    public static function make(string $type, array $rules)
    {
        $validator = self::Validator[$type] ?? null;

        if ($validator === null) {
            return false;
        }

        $validator = new $validator();

        foreach ($rules as $rule => $value) {
            $validator->$rule = $value;
        }

        return $validator;
    }
}