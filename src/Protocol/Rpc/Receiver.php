<?php

namespace SF\Protocol\Rpc;

use SF\Contracts\Protocol\Message as MessageInterface;
use SF\Contracts\Protocol\Receiver as ReceiverInterface;
use SF\Protocol\Rpc\Exceptions\DeniedException;
use SF\Protocol\Rpc\Exceptions\Denied\MissingParameter;
use SF\Protocol\Rpc\Exceptions\Denied\RpcMisMatchException;

class Receiver implements ReceiverInterface
{

    /**
     *
     * @var Protocol
     */
    protected $protocol;

    /**
     *
     * @var string
     */
    protected $data;

    /**
     *
     * @var Message
     */
    private $message;

    public function __construct(Protocol $protocol, string $data)
    {
        $this->data = $data;
        $this->protocol = $protocol;
    }

    /**
     * @param string $data
     * pack
     * a    以NUL字节填充字符串空白
     * A    以SPACE(空格)填充字符串
     * h    十六进制字符串，低位在前
     * H    十六进制字符串，高位在前
     * c    有符号字符
     * C    无符号字符
     * s    有符号短整型(16位，主机字节序)
     * S    无符号短整型(16位，主机字节序)
     * n    无符号短整型(16位，大端字节序)
     * v    无符号短整型(16位，小端字节序)
     * i    有符号整型(机器相关大小字节序)
     * I    无符号整型(机器相关大小字节序)
     * l    有符号长整型(32位，主机字节序)
     * L    无符号长整型(32位，主机字节序)
     * N    无符号长整型(32位，大端字节序)
     * V    无符号长整型(32位，小端字节序)
     * q    有符号长长整型(64位，主机字节序)
     * Q    无符号长长整型(64位，主机字节序)
     * J    无符号长长整型(64位，大端字节序)
     * P    无符号长长整型(64位，小端字节序)
     * f    单精度浮点型(机器相关大小)
     * d    双精度浮点型(机器相关大小)
     * x    NUL字节
     * X    回退一字节
     * Z    以NUL字节填充字符串空白(new in PHP 5.5)
     * @    NUL填充到绝对位置
     *
     *
     * @return MessageInterface
     */
    public function unpack(): MessageInterface
    {
        $data = $this->data;

        if (strlen($data) < Header::HEADER_LENGTH) {
            throw new DeniedException();
        }

        $header = new Header(
            (array) unpack(
                'Jid/Nlength/nversion/nflavor/Jcredential',
                substr($data, 0, Header::HEADER_LENGTH)
            )
        );

        $body = substr($data, Header::HEADER_LENGTH);
        $header->action = strstr($data, Header::DELIMITER, true);


        $this->message =  new Message($header, substr($body, strlen($header->action . Header::DELIMITER)));

        $version = $this->message->getPackageHeader('version');

        if ($this->message->getPackageHeader('id') == '') {
            throw new MissingParameter('id');
        }

        if (($this->protocol->high && $version > $this->protocol->high) || ($this->protocol->low && $version < $this->protocol->low)) {
            throw new RpcMisMatchException($this->protocol->low, $this->protocol->high);
        }

        $this->protocol->getAuthenticator()->validate($this->message);

        $this->message->withPackageBody($this->protocol->getPacker()->unpack($this->message->getPackageBody()));

        return $this->message;

    }

    public function getMessage()
    {
        if ($this->message === null) {
            $this->message = $this->unpack();
        }

        return $this->message;
    }


}