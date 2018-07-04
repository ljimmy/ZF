<?php

namespace SF\Exceptions\IoC;

use SF\Exceptions\UserException;
use Psr\Container\NotFoundExceptionInterface;

class NotFoundException extends UserException implements NotFoundExceptionInterface
{

}
