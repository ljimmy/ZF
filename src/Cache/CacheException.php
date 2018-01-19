<?php

namespace SF\Cache;

use SF\Exceptions\UserException;

class CacheException extends UserException implements \Psr\SimpleCache\CacheException
{

}
