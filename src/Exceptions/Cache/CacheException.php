<?php

namespace SF\Exceptions\Cache;

use SF\Exceptions\UserException;

class CacheException extends UserException implements \Psr\SimpleCache\CacheException
{

}