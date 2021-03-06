<?php

namespace SF\IoC;

use Psr\Container\ContainerInterface;
use SF\Contracts\IoC\Instance;
use SF\Exceptions\IoC\ContainerException;

class Container implements ContainerInterface
{

    /**
     * @var array
     */
    private $definitions = [];

    /**
     * @var array
     */
    private $singleton = [];

    public function __construct()
    {
        $this->singleton[self::class] = $this;
    }

    public function has($id)
    {
        return isset($this->singleton[$id]);
    }

    public function setDefinitions(array $definitions)
    {

        foreach ($definitions as $definition) {
            $this->setDefinition($definition);
        }

        return $this;
    }

    public function setDefinition($definition)
    {
        if (is_string($definition)) {
            $definition = [
                'class' => $definition
            ];
        } else {
            if (is_array($definition)) {
                if (!isset($definition['class'])) {
                    throw new ContainerException('The definition class do not set.');
                }
            } else {
                throw new ContainerException('The definition is not valid.');
            }
        }

        $class                     = $definition['class'];
        $this->definitions[$class] = $definition;

        $this->make($definition);

        return $this;
    }

    public function set($class, $object)
    {
        $this->singleton[$class] = $object;
        return $this;
    }

    public function get($class, array $params = [])
    {
        if (isset($this->singleton[$class])) {
            return $this->singleton[$class];
        } else {
            return $this->make($this->definitions[$class] ?? ['class' => $class], $params);
        }

    }

    public function make($object, array $params = [])
    {
        if (is_string($object)) {
            $definition = [
                'class' => $object
            ];
        } else {
            if (is_array($object)) {
                if (!isset($object['class'])) {
                    throw new ContainerException('The definition class do not set.');
                }
                $definition = $object;
            } else {
                throw new ContainerException('The definition is not valid.');
            }
        }

        return $this->create($definition, $params);

    }


    protected function create(array $definition, array $params = [])
    {
        $class = $definition['class'];
        unset($definition['class']);

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
                } else {
                    if ($parameter->isDefaultValueAvailable()) {
                        $dependencies[] = $parameter->getDefaultValue();
                    } else {
                        $c              = $parameter->getClass();
                        $dependencies[] = $c === null ? null : $this->get($c->getName());
                    }
                }
            }

            $instance = $this->injectProperty($reflection->newInstanceArgs($dependencies), $definition);
        }

        if (isset($this->definitions[$class]) && !isset($this->singleton[$class])) {
            $this->singleton[$class] = $instance;
        }

        if ($instance instanceof Instance) {
            $instance->init();
        }

        return $instance;
    }

    /**
     *
     * @param Instance $object 对象
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
        $this->definitions = [];
        $this->singleton   = [];
    }

}
