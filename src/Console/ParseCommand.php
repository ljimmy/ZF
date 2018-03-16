<?php

namespace SF\Console;

class ParseCommand
{

    private $params;

    private $opts;

    public function __construct(array $params = null)
    {
        if ($params === null) {
            $this->params = $_SERVER['argv'] ?? [];
        } else {
            $this->params = $params;
        }
        $this->parse();
    }

    public function parse()
    {
        do {
            $param = current($this->params);
            if ($param[0] === '-') {
                $param = substr($param, 1);
                $param[0] === '-' ? $this->getLongOpt(substr($param, 1)) : $this->getOpt($param);
            }else {
                $this->opts[] = $param;
            }

        } while (next($this->params));

        return $this;
    }

    private function getLongOpt($param)
    {
        if (strpos($param, '=')) {
            list($name, $value) = explode('=', $param);
        } else {
            $name = $param;
            $value = null;
        }

        $this->opts[$name] = $value;
    }

    private function getOpt($param)
    {

        $name      = substr($param, 0, 1);
        $value     = substr($param, 1);

        if (empty($value)) {
            $next = next($this->params);
            if ($next && $next[0] !== '-') {
                $value = $next;
            } else {
                prev($this->params);
            }
        }
        $this->opts[$name] = $value;
    }

    public function get(string $name, $value = null)
    {
        return $this->opts[$name] ?? $value;
    }

}
