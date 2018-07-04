<?php

namespace SF\Exceptions\IoC;

use SF\Exceptions\UserException;
use Psr\Container\ContainerExceptionInterface;

class ContainerException extends UserException implements ContainerExceptionInterface
{

}
