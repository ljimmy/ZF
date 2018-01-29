<?php

namespace SF\Log;

use Psr\Log\LoggerInterface;
use Monolog\Handler\HandlerInterface;
use Monolog\Formatter\FormatterInterface;
use Monolog\Handler\FormattableHandlerInterface;
use Monolog\Handler\ProcessableHandlerInterface;

class LoggerFactory
{
    public $logger;


    public function getLogger(): LoggerInterface
    {
        if ($this->logger === null) {
            return new Logger();
        }

        $class = $this->logger['class'] ?? Logger::class;

        $logger = new $class();

        foreach ($this->logger['handles'] ?? [] as $handle) {
            if (is_string($handle)) {
                $handle = ['class' => $handle];
            }

            if (!isset($handle['class'])) {
                continue;
            }
            $handle = $this->createHandle($handle['class'], $handle['config'] ?? null);

            if (isset($handle['formatter']) && ($handle instanceof FormattableHandlerInterface)) {
                $handle->setFormatter($this->createFormatter($handle['formatter']));
            }

            $logger->pushHandler($handle);

            if (isset($handle['processors']) && ($handle instanceof ProcessableHandlerInterface)) {
                $handle = $this->pushProcessors($handle, (array)$handle['processors']);
            }
            $logger->pushHandler($handle);
        }
        if (isset($this->logger['processors'])) {
            $logger = $this->pushProcessors($logger, (array)$this->logger['processors']);
        }
        return $logger;
    }


    public function createHandle(string $class, array $config = null): HandlerInterface
    {
        if ($config === null) {
            return new $class();
        } else {
            return new $class(...array_values($config));
        }
    }

    public function createFormatter($class): FormatterInterface
    {
        $config = [];
        if (is_array($class)) {
            $formatter = $class['class'];
            unset($class['class']);
            $config = $class;
        } else {
            if (is_string($class)) {
                $formatter = $class;
            } else {
                throw new LogException("can not initialize formatter class.");
            }
        }

        return new $class(...array_values($config));
    }

    public function pushProcessors(ProcessableHandlerInterface $handler, array $processors): HandlerInterface
    {
        foreach ($processors as $processor) {
            $handler->pushProcessor($processor);
        }
        return $handler;
    }
}