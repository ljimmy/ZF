<?php

namespace SF\Pool;

interface PoolInterface
{

    public function get();

    public function release($connector);
}
