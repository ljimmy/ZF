<?php

namespace SF\IoC\Exceptions;

use SF\Exceptions\UserException;
use Psr\Container\NotFoundExceptionInterface;

class NotFoundException extends UserException implements NotFoundExceptionInterface
{

}
