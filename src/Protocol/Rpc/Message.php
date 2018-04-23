<?php

namespace SF\Protocol\Rpc;

use SF\Contracts\Protocol\Message as MessageInterface;

/**
 * Class Message
 *
 * header structure:
 *
 * 0    1    2    3    4    5    6    7    8   byte
 *
 * 0    8   16   24   32   40   48   56   64   bit
 * +-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+
 * |                  id                   |
 * +-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+
 * |   length          | version | flavor  |
 * +-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+
 * |       Authentication credential       |      //Authentication flavor Number see SF\AbstractProtocol\Rpc\Authenticator
 * +-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+
 *
 * body structure
 *
 * [action]\r\n\r\n[data]
 *
 *
 *
 * @package SF\Protocol\Rpc
 */

class Message implements MessageInterface
{
    /**
     * @var Header
     */
    protected $header;

    /**
     * @var string
     */
    protected $body;

    public function __construct(Header $header, string $body)
    {
        $this->header = $header;

        $this->body = $body;
    }


    public function getPackageHeaders(): array
    {
        return $this->header->toArray();
    }

    public function getPackageHeader(string $name)
    {
        return $this->header->get($name);
    }


    public function hasPackageHeader(string $name): bool
    {
        return isset($this->header[$name]);
    }

    public function withPackageHeader(array $header)
    {
        $this->header = $header;
    }

    public function withAddPackageHeader(string $name, $value)
    {
        $this->header[$name] = $value;
    }

    public function withOutPackageHeader(string $name)
    {
        unset($this->header[$name]);
    }

    public function getPackageBody()
    {
        return $this->body;
    }

    public function withPackageBody($body)
    {
        $this->body = $body;
    }


}