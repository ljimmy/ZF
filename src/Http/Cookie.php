<?php

namespace SF\Http;

class Cookie
{

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $value = '';

    /**
     * @var string
     */
    public $domain = '';

    /**
     * @var int
     */
    public $expire = 0;

    /**
     * @var string
     */
    public $path = '/';

    /**
     * @var bool
     */
    public $secure = false;

    /**
     * @var bool
     */
    public $httpOnly = true;

    public function __construct(
            string $name,
            string $value = '',
            string $domain = '',
            int $expire = 0,
            string $path = '/',
            bool $secure = false,
            bool $httpOnly = true
        )
    {
        $this->name     = $name;
        $this->value    = $value;
        $this->domain   = $domain;
        $this->expire   = $expire;
        $this->path     = $path;
        $this->secure   = $secure;
        $this->httpOnly = $httpOnly;
    }

    public function __toString()
    {
        return (string) $this->value;
    }

}
