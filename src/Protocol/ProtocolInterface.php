<?php

namespace SF\Protocol;

interface ProtocolInterface
{
    const PACKER = 'Protocol_Packer';

    public function getVersion(): string;

    public function handle(string $data):ReceiverInterface;

    public function getReplier(): ReplierInterface;

    public function getAuthenticator(): AuthenticatorInterface;
}