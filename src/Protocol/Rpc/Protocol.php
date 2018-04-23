<?php

namespace SF\Protocol\Rpc;

use SF\Contracts\Packer\Packer as PackerInterface;
use SF\Contracts\Protocol\Authenticator as AuthenticatorInterface;
use SF\Contracts\Protocol\Client as ClientInterface;
use SF\Contracts\Protocol\Server as ServerInterface;
use SF\Packer\NonPacker;
use SF\Protocol\AbstractProtocol;

class Protocol extends AbstractProtocol
{
    const NAME = 'rpc';

    /**
     * low version
     * @var int
     */
    public $low;

    /**
     * high version
     * @var int
     */
    public $high;


    /**
     * @var AuthenticatorInterface
     */
    public $authenticator = Authenticator::class;

    /**
     * @var ServerInterface
     */
    public $server = Server::class;

    /**
     * @var ClientInterface
     */
    public $client = Client::class;

    /**
     * @var PackerInterface
     */
    public $packer = NonPacker::class;

    public function init()
    {
        parent::init();
        $this->authenticator = $this->container->make($this->authenticator);
        $this->packer = $this->container->make($this->packer);
    }

    public function getName()
    {
        return self::NAME;
    }

    public function getAuthenticator(): AuthenticatorInterface
    {
        return $this->authenticator;
    }

    public function getPacker():PackerInterface
    {
        return $this->packer;
    }

}