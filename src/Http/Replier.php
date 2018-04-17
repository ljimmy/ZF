<?php
/**
 * Created by PhpStorm.
 * User: xfb_user
 * Date: 2018/4/17
 * Time: 下午5:31
 */

namespace SF\Http;

use SF\Contracts\Protocol\Replier as ReplierInterface;
use SF\Contracts\Protocol\Http\Response;
use Swoole\Http\Response as swooleHttpResponse;


class Replier implements ReplierInterface
{

    /**
     * @var swooleHttpResponse
     */
    private $swooleHttpResponse;

    public function __construct(swooleHttpResponse $swooleHttpResponse)
    {
        $this->swooleHttpResponse = $swooleHttpResponse;
    }

    public function pack(Response $response = null): string
    {
        if ($response === null) {
            $this->swooleHttpResponse->end();
        } else {
            foreach ($response->getHeaders() as $key => $value) {
                $this->swooleHttpResponse->header($key, implode(';', $value));
            }

            if ($response->getCharset()) {
                $this->swooleHttpResponse->header('Content-Type', sprintf('charset=%s', $response->getCharset()));
            }

            $this->swooleHttpResponse->gzip($response->gzip);
            $statusCode = $response->getStatusCode();
            $this->swooleHttpResponse->status($statusCode);

            if ($statusCode === 200 || $statusCode === 204) {
                $this->swooleHttpResponse->end($response->getBody()->getContents());
            } else {
                $this->swooleHttpResponse->end($response->getReasonPhrase());
            }
        }

        return '';
    }


    public function setRawCookie(
        string $name,
        string $value = '',
        int $expires = 0,
        string $path = '/',
        string $domain = '',
        bool $secure = false,
        bool $httpOnly = false
    ) {
        $this->swooleHttpResponse->rawcookie($name, $value, $expires, $path, $domain, $secure, $httpOnly);
        return $this;
    }

    public function setCookie(
        string $name,
        string $value = '',
        int $expires = 0,
        string $path = '/',
        string $domain = '',
        bool $secure = false,
        bool $httpOnly = false
    ) {
        $this->swooleHttpResponse->cookie($name, $value, $expires, $path, $domain, $secure, $httpOnly);
        return $this;
    }


}