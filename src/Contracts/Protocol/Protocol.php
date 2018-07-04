<?php

namespace SF\Contracts\Protocol;

interface Protocol
{

    public function getName();

    public function getServer(): Server;

    public function getClient(): Client;
}