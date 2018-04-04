<?php

namespace SF\Protocol;

interface ProtocolInterface
{
    const PACKER = 'Protocol_Packer';

    public function getVersion(): string;

    public function getReceiver(): ReceiverInterface;

    public function getReplier(): ReplierInterface;

    public function getVerifier(): VerifierInterface;
}