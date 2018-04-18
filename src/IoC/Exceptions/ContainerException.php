<?php

namespace SF\IoC\Exceptions;

use SF\Exceptions\UserException;
use Psr\Container\ContainerExceptionInterface;

class ContainerException extends UserException implements ContainerExceptionInterface
{

}
