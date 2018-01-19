<?php

namespace SF\Http;

use SF\Context\ContextTrait;
use SF\Http\Exceptions\NotFoundHttpException;

abstract class Controller
{
    protected $id;

    use ContextTrait;

    public static function handle(string $action, array $params = [])
    {

        try {
            $method = new \ReflectionMethod(static::class, $action);
        } catch (\ReflectionException $e) {
            throw new NotFoundHttpException();
        }

        $controller = new static();
        $controller->id = $action;
        $container = $controller->getApplicationContext()->getContainer();

        $paramsNum = count($params);
        foreach ($method->getParameters() as $index => $parameter) {

            if ($index < $paramsNum) {
                //跳过路由参数
                continue;
            }
            if ($parameter->isDefaultValueAvailable()) {
                $params[] = $parameter->getDefaultValue();
            } else {
                $c = $parameter->getClass();
                $params[] = $c === null ? null : $container->get($c->getName());
            }
        }

        return $controller->{$action}(...$params);
    }
}
