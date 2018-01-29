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

    public static function create(string $type, array $rules): ValidatorInterface
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