<?php

namespace SF\Console;

class ParseCommand
{

    private $params;
    public $opts;

    private function __construct(array $params = null)
    {
        if ($params === null) {
            $this->params = $_SERVER['argv'] ?? [];
        } else {
            $this->params = $params;
        }
    }

    public function parse()
    {
        while (list(, $param) = each($this->params)) {
            if ($param[0] === '-') {
                $param = substr($param, 1);
                $param[0] === '-' ? $this->getLongOpt(substr($param, 1)) : $this->getOpt($param);
            }else {
                $this->opts[] = $param;
            }
        }
        return $this;
    }

    private function getLongOpt($param)
    {
        if (strpos($param, '=')) {
            list($name, $value) = explode('=', $param);
        } else {
            $name = $param;
            $value = '';
        }
        $nextParam = current($this->params);
        if (empty($value) && $nextParam && $nextParam[0] !== '-') {
            list(, $value) = each($this->params);
        }
        $this->opts[$name] = $value;
    }

    private function getOpt($param)
    {
        $name      = substr($param, 0, 1);
        $value     = substr($param, 1);
        $nextParam = current($this->params);

        if (empty($value) && $nextParam && $nextParam[0] !== '-') {
            list(, $value) = each($this->params);
        }
        $this->opts[$name] = $value;
    }

    public static function get(array $params = null)
    {
        $self = new static($params);
        return $self->parse()->opts;
    }

}
