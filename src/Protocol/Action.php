<?php

namespace SF\Protocol;

use SF\Context\ContextTrait;
use SF\Contracts\Protocol\Action as ActionInterface;
use SF\Contracts\Protocol\Middleware as MiddlewareInterface;
use SF\Support\PHP;

class Action implements ActionInterface
{
    use ContextTrait;

    protected $method;

    /**
     *
     * @var \Closure
     */
    private $handler;

    /**
     *
     * @var array
     */
    private $params = [];

    /**
     *
     * @var MiddlewareInterface[]
     */
    private $middleware = [];

    public function __construct(string $method)
    {
        $this->method = $method;
    }


    public function setHandler(\Closure $handler = null)
    {
        $this->handler = $handler;
    }

    public function isSetHandler(): bool
    {
        return null !== $this->handler;
    }

    public function addParams(array $params = [])
    {
        $this->params = array_merge($this->params, $params);
    }

    public function addMiddleware(MiddlewareInterface $middleware)
    {
        $this->middleware[] = $middleware;
    }


    public function getMiddleware(): array
    {
        return $this->middleware;
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function run()
    {
        if ($this->handler === null) {
            return null;
        }

        if ($this->handler instanceof \Closure) {
            $this->getClosureParameters();
        }

        return PHP::call($this->handler, $this->params);
    }

    protected function getClosureParameters()
    {
        try {
            $func = new \ReflectionFunction($this->handler);
        } catch (\ReflectionException $e) {
            return;
        }

        $container = $this->getApplicationContext()->getContainer();
        $paramsNum = count($this->params);
        foreach ($func->getParameters() as $index => $parameter) {
            if ($index < $paramsNum) {
                //跳过参数
                continue;
            }
            if ($parameter->isDefaultValueAvailable()) {
                $this->params[] = $parameter->getDefaultValue();
            } else {
                $c = $parameter->getClass();
                $this->params[] = $c === null ? null : $container->get($c->getName());
            }
        }

        return;

    }


}