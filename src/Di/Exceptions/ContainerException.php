<?php

namespace SF\Di\Exceptions;

use SF\Exceptions\UserException;
use Psr\Container\ContainerExceptionInterface;

class ContainerException extends UserException implements ContainerExceptionInterface
{

}
