<?php

namespace SF\Base;

class Config implements \ArrayAccess
{

    private $config;

    public function __construct(array $config = [])
    {
        $this->config = $config;
    }

    public function get(string $key, $default = null)
    {
        $data = $this->config;
        foreach (explode('.', $key) as $segment) {
            if (array_key_exists($segment, $data)) {
                $data = $data[$segment];
                continue;
            } else {
                return $default;
            }
        }
        return $data;
    }

    public function getServer()
    {
        return $this->config['server'] ?? [];
    }

    public function getHttp()
    {
        return $this->config['http'] ?? [];
    }

    public function getComponents()
    {
        return $this->config['components'] ?? [];
    }

    public function offsetExists($offset): bool
    {
        return isset($this->config[$offset]);
    }

    public function offsetGet($offset)
    {
        return $this->config[$offset] ?? null;
    }

    public function offsetSet($offset, $value)
    {
        if (is_string($offset)) {
            $this->config[$offset] = $value;
        }
    }

    public function offsetUnset($offset)
    {
        unset($this->config[$offset]);
    }

}
