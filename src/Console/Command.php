<?php

namespace SF\Console;

use SF\Http\HttpServer;
use SF\Http\WebSocket;

class Command
{

    const SERVER = [
        'http' => HttpServer::class,
        'webSocket' => WebSocket::class
    ];

    /**
     * @var ParseCommand
     */
	protected $opt;

	protected static $self;

	public function __construct()
	{
	    self::$self = $this;

		$this->opt = new ParseCommand();
	}

	public static function getSelf()
    {
        return self::$self;
    }

	public static function run()
    {
        return (new static())->bootstrap();
    }

    public function bootstrap()
    {
        switch ($this->opt->get(1)) {
            case 'start':
                $this->start();
                break;
            case 'reload':
                $this->reload();
                break;
            case 'stop':
                $this->stop();
                break;
            default:
                $this->writeln('command not found');
        }
    }

    private function getConfig()
    {
        $c = $this->opt->get('c');

        if ($c === null) {
            return [];
        }
        $config = include_once ($c);

        return $config;
    }

    public function getPidFile()
    {
        $file = $this->opt->get('pidfile');

        if ($file === null) {
            return \SF\Support\PHP::getBasePath(). DIRECTORY_SEPARATOR . '.pid';
        } else {
            return $file;
        }
    }

    public function start()
    {
        $server = self::SERVER[$this->opt->get('s', '')] ?? null;

        if ($server === null) {
            $this->writeln('Unsupported Service');
        } else {
            $this->writeln('Starting...');
            (new $server($this->getConfig()))->start();
        }

    }

    public function reload()
    {
        $pid = (int) $this->opt->get('p', 0);

        $this->writeln('Reloading...');
        if ($pid) {
            posix_kill($pid, $this->opt->get('t') === 'task' ? SIGUSR2: SIGUSR1);
            $this->writeln('Done');
        } else {
            get_pid(function($master_pid, $manager_pid) {
                posix_kill($master_pid, $this->opt->get('t') === 'task' ? SIGUSR2: SIGUSR1);
                $this->writeln('Done');
            });
        }
    }

    public function stop()
    {
        $pid = (int) $this->opt->get('p', 0);
        if (empty($pid)) {
            get_pid(function($master_pid, $manager_pid){
                $this->writeln('Stopping...');
                posix_kill($master_pid, SIGTERM);
                $this->writeln('Stopped');
            });
        } else {
            $this->writeln('Stopping...');
            posix_kill($pid, SIGTERM);
            $this->writeln('Stopped');
        }

    }

    public function writeln(string $message)
    {
        echo $message . "\n";
    }


}