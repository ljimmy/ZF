<?php

namespace SF\Validation;

use SF\Contracts\Validation\Validator;

class ValidatorFactory
{

    const Validator = [
        'boolean' => Boolean::class,
        'email'   => Email::class,
        'inline'  => Inline::class,
        'integer' => Integer::class,
        'ip'      => Ip::class,
        'regexp'  => Regexp::class,
        'url'     => Url::class,
    ];

    public static function create(string $type, array $rules): Validator
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