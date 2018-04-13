<?php

namespace SF\Contracts\Protocol;

use SF\Support\Collection;

interface Message
{
    public function getHeader(): Collection;

    public function withHeader(Collection $header);

    public function getStream(): Stream;

    public function withStream(Stream $stream);
}