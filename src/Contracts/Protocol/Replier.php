<?php

namespace SF\Contracts\Protocol;

interface Replier
{

    public function pack($data): string;
}
