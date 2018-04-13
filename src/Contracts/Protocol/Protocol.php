<?php

namespace SF\Contracts\Protocol;


interface Protocol
{
    public function getVersion(): string;

    public function handle(string $data): Receiver;

    public function getReplier(): Replier;

    public function getAuthenticator(): Authenticator;
}