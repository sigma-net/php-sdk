<?php

namespace SigmaNet\SDK\Model\Request\Wallet;

use SigmaNet\SDK\Model\Request\AbstractRequestTransport;
use SigmaNet\SDK\Transport\AbstractApiTransport;

class WalletTransport extends AbstractRequestTransport
{
    public const PATH = 'wallet/get';

    public function getPath(): string
    {
        return self::PATH;
    }

    public function getMethod(): string
    {
        return AbstractApiTransport::METHOD_POST;
    }
}
