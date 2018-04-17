<?php

namespace SF\Di;

use Psr\Container\ContainerInterface;
use SF\Di\Exceptions\ContainerException;

class Container implements ContainerInterface
{

    const METHOD = 'init';

    /**
     *
     * @var array
     */
    private $alias       = [];
    private $definitions = [];
    private $singleton   = [];

    public function __construct()
    {
        $this->singleton[self::class] = $this;
    }

    public function getAlias(): array
    {
        return $this->alias;
    }

    public function has($id)
    {
        if (isset($this->alias[$id])) {
            $id = $this->alias[$id];
        }
        return isset($this->singleton[$id]);
    }

    public function setDefinitions(array $definitions)
    {

        foreach ($definitions as $alias => $definition) {
            if (!is_array($definition)) {
                $definition = [$definition];
            }
            $this->setDefinition($definition, $alias);
        }

        return $this;
    }

    public function setDefinition($definition, $alias = null)
    {
        if (is_array($definition)) {
            $class = $definition['class'];
            unset($definition['class']);
        } else if (is_string($definition)) {
            $class      = $definition;
            $definition = [];
        } else {
            throw new ContainerException('The definition is not valid.');
        }
        $this->definitions[$class] = $definition;
        if ($alias && is_string($alias)) {
            $this->alias[$alias] = $class;
        }

        return $this;
    }

    public function set($class, $object, $alia = null)
    {
        $this->singleton[$class] = $object;
        if ($alia) {
            $this->alias[$alia] = $class;
        }
        return $this;
    }

    public function get($id, array $params = [])
    {
        $class = $this->alias[$id] ?? $id;

        if (isset($this->singleton[$class])) {
            return $this->singleton[$class];
        }

        if (isset($this->definitions[$class])) {
            return $this->singleton[$class] = $this->build($class, $params, $this->definitions[$class]);
        } else {
            return $this->build($class, $params);
        }
    }

    public function create($object, array $params = [])
    {
        if (is_array($object)) {
            $class = $object['class'];
            unset($object['class']);
        } else if (is_string($object)) {
            $class      = $object;
            $object = [];
        } else {
            return null;
        }

        return $this->build($class,$params, $object);

    }

    /**
     *
     * @param string $class
     * @param array $params
     * @return object
     * @throws ContainerException
     */
    protected function build(string $class, array $params = [], array $definition = [])
    {
        $reflection = new \ReflectionClass($class);

        if (!$reflection->isInstantiable()) {
            throw new ContainerException('Can not instantiable');
        }

        $constructor = $reflection->getConstructor();

        $dependencies = [];
        if ($constructor === null) {
            $instance = $this->injectProperty($reflection->newInstance(), $definition);
        } else {
            foreach ($constructor->getParameters() as $parameter) {
                if (array_key_exists($parameter->name, $params)) {
                    $dependencies[] = $params[$parameter->name];
                } else if ($parameter->isDefaultValueAvailable()) {
                    $dependencies[] = $parameter->getDefaultValue();
                } else {
                    $c              = $parameter->getClass();
                    $dependencies[] = $c === null ? null : $this->get($c->getName());
                }
            }

            $instance = $this->injectProperty($reflection->newInstanceArgs($dependencies), $definition);
        }

        if ($reflection->hasMethod(self::METHOD)) {
            $instance->{self::METHOD}();
        }
        return $instance;
    }

    /**
     *
     * @param object $object 对象
     * @param array $properties 属性
     * @return object
     */
    protected function injectProperty($object, array $properties)
    {
        foreach ($properties as $name => $value) {
            $object->$name = $value;
        }
        return $object;
    }

    public function clear()
    {

        $this->alias       = [];
        $this->definitions = [];
        $this->singleton   = [];
    }

}
