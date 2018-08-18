<?php

namespace SF\Http;

use SF\Contracts\Protocol\Receiver as ReceiverInterface;
use SF\Contracts\Protocol\Message;
use SF\Protocol\Http\Request;
use Swoole\Http\Request as SwooleHttpRequest;

class Receiver implements ReceiverInterface
{

    /**
     * @var SwooleHttpRequest
     */
    public $request;

    public function __construct(SwooleHttpRequest $request)
    {
        $this->request = $request;
    }

    public function unpack(): Message
    {
        $request = new Request($this->request->get, $this->request->post);

        $request->setServer((array)$this->request->server)
            ->setHeaders((array)$this->request->header)
            ->setUploadedFile((array)$this->request->files)
            ->setCookies((array)$this->request->cookie);

        $request->get        = $this->request->get;
        $request->post       = $this->request->post;
        $request->rawContent = $this->request->rawContent();

        return $request;
    }


}