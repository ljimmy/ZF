<?php

namespace SF\Di\Exceptions;

use SF\Exceptions\UserException;
use Psr\Container\NotFoundExceptionInterface;

class NotFoundException extends UserException implements NotFoundExceptionInterface
{

}
