<?php

namespace SigmaNet\SDK\Model\Request\Payment;

use SigmaNet\SDK\Model\Request\AbstractRequestTransport;

class ApplePayVerifyTransport extends AbstractRequestTransport
{
    public const PATH = 'payment/apple/verify';

    /**
     * @inheritDoc
     */
    public function getPath(): string
    {
        return self::PATH;
    }
}
