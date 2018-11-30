<?php

namespace SF\ShareMemory;

use SF\Memory\Channel;

class ChannelManager
{
    /**
     * @var Channel[]
     */
    private static $channel = [];

    public static function setChannel(string $key, int $capacity = 0)
    {
        self::$channel[$key] = new Channel($capacity);
    }

    /**
     * @param string $key
     * @return null|Channel
     */
    public static function getChannel(string $key)
    {
        return self::$channel[$key] ?? null;
    }
}