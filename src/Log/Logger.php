<?php

namespace SF\Log;

use Monolog\Logger as MonologLogger;


class Logger extends  MonologLogger
{

    public function addRecord(int $level, string $message, array $context = []): bool
    {
        // check if any handler will handle this message so we can return early and save cycles
        $handlerKey = null;
        foreach ($this->handlers as $key => $handler) {
            if ($handler->isHandling(['level' => $level])) {
                $handlerKey = $key;
                break;
            }
        }

        if (null === $handlerKey) {
            return false;
        }

        $levelName = static::getLevelName($level);

        $record = [
            'message' => $message,
            'context' => $context,
            'level' => $level,
            'level_name' => $levelName,
            'channel' => $this->name,
            'datetime' => new \DateTimeImmutable($this->microsecondTimestamps, $this->timezone),
            'extra' => [],
        ];

        foreach ($this->processors as $processor) {
            $record = call_user_func($processor, $record);
        }

        // advance the array pointer to the first handler that will handle this record
        reset($this->handlers);
        while ($handlerKey !== key($this->handlers)) {
            next($this->handlers);
        }

        while ($handler = current($this->handlers)) {
            if (true === $handler->handle($record)) {
                break;
            }

            next($this->handlers);
        }

        return true;
    }
}