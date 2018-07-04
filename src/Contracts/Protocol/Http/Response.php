<?php

namespace SF\Contracts\Protocol\Http;

use Psr\Http\Message\ResponseInterface;
use SF\Contracts\Protocol\Message;

interface Response extends ResponseInterface, Message
{

    public function withCharset(string $charset);

    public function getCharset();

    public function withContent(string $content);

    public function redirect(string $url, int $status = 302);

    public function auto($data, array $accepts = []);
}