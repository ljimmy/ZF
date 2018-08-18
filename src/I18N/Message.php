<?php

namespace SF\I18N;

use SF\Contracts\IoC\Object;

class Message implements Object
{
    public $messages = [];

    public function init()
    {
    }


    public function translate($source, $language = 'zh-cn')
    {
        return $this->messages[$language][$source] ?? $source;
    }
}