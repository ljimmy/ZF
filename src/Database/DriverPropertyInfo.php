<?php

namespace SF\Database;

use SF\Exceptions\Database\ConnectException;

class DriverPropertyInfo
{

    /**
     * @var string
     */
    public $driver;

    /**
     * @var string
     */
    public $host;

    /**
     * @var int
     */
    public $port;

    /**
     * @var string
     */
    public $database;

    /**
     * @var string
     */
    public $charset;

    /**
     * @var string
     */
    public $unix_socket;

    /**
     * @var string
     */
    public $username;

    /**
     * @var string
     */
    public $password;

    /**
     * @var array
     */
    public $options = [];

    /**
     * @var int
     */
    public $maxConnections = 0;


    public function __construct(string $dsn, string $username = null, string $password = null, int $maxConnections = 0, array $options = [])
    {
        $this->username = $username;
        $this->password = $password;
        $this->maxConnections = $maxConnections;
        $this->options = $options;
        $this->parseDsn($dsn);
    }

    protected function parseDsn(string $dsn): void
    {
        $driver = strstr($dsn, ':', true);

        if ($driver === false) {
            throw new ConnectException('invalid data source name');
        }

        $this->driver = $driver;

        foreach (explode(';', substr($dsn, strlen($driver) + 1)) as $element) {
            list($name, $value) = explode('=', $element);
            switch ($name) {
                case 'host':
                    $this->host = $value;
                    break;
                case 'port':
                    $this->port = $value;
                    break;
                case 'database':
                    $this->database = $value;
                    break;
                case 'charset':
                    $this->charset = $value;
                    break;
                case 'unix_socket':
                    $this->unix_socket = $value;
                    break;
            }

        }
    }

}
