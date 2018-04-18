<?php

namespace SF\Base;

use SF\Support\Collection;

class Config extends Collection
{

    public function __construct(array $config = [])
    {
        $this->items = $config;
    }

    public function get($key, $default = null)
    {
        $data = $this->items;
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

    public function getApplication()
    {
        return $this->items['application'] ?? [];
    }

    public function getServer()
    {
        return $this->items['setting'] ?? [];
    }

    public function getComponents()
    {
        return $this->items['components'] ?? [];
    }

}
