<?php

namespace SF\Console;

use SF\Http\HttpServer;

class Command
{

    protected $opts = [];

    const SERVER_MODE = [
        'http' => HttpServer::class
    ];

    public function __construct()
    {
        $this->opts = ParseCommand::get();
    }

    public static function run()
    {
        return (new static())->bootstrap();
    }

    protected function bootstrap()
    {
        $config = $this->getOpt('c');

        if ($config) {
            if (!is_file($config)) {
                $this->writeln('配置文件不存在!');
                return;
            }
            $config = include_once ($config);
        } else {
            $config = [];
        }

        $server = $this->getOpt('s');

        if (empty($server)) {
            $this->writeln('请选择服务模式,如：php server.php -shttp');
            return;
        }
        $mode = static::SERVER_MODE[strtolower($server)] ?? null;

        if (!$mode) {
            $this->writeln('未支持的服务模式');
            return;
        }
        $app = new $mode($config);

        switch (strtolower($this->opts[1])) {
            case 'start':
                $app->start();
                break;
            case 'stop':
                $app->stop();
                break;
            case 'reload':
                $app->reload();
                break;
            case 'restart':
                break;
            default:
                break;
        }
        return;
    }

    public function getOpt($name, $default = null)
    {
        return $this->opts[$name] ?? $default;
    }

    public function getOpts()
    {
        return $this->opts;
    }

    public function writeln(string $message)
    {
        echo $message . "\n";
    }

}
