<?php

namespace SF\Support;


use SF\Contracts\Support\Arrayable;
use SF\Contracts\Support\Jsonable;

class Collection implements \ArrayAccess, \Countable, \JsonSerializable, Arrayable, Jsonable
{
    protected $items = [];

    public function count()
    {
        return count($this->items);
    }

    public function jsonSerialize()
    {
        return $this->items;
    }

    public function __get($key)
    {
        return $this->offsetGet($key);
    }

    public function __set($key, $value)
    {
        $this->offsetSet($key, $value);
    }

    public function offsetGet($key)
    {
        return $this->items[$key];
    }

    public function offsetSet($key, $value)
    {
        if (is_null($key)) {
            $this->items[] = $value;
        } else {
            $this->items[$key] = $value;
        }
    }

    public function __isset($key)
    {
        return $this->offsetExists($key);
    }

    public function offsetExists($key)
    {
        return array_key_exists($key, $this->items);
    }

    public function __unset($key)
    {
        $this->offsetUnset($key);
    }

    public function offsetUnset($key)
    {
        unset($this->items[$key]);
    }

    public function __toString()
    {
        return $this->toJson();
    }

    public function toArray(): array
    {
        return $this->items;
    }

    public function toJson($options = 0)
    {
        return Json::enCode($this->jsonSerialize(), $options);
    }


}