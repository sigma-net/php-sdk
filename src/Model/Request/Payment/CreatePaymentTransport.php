<?php

namespace SigmaNet\SDK\Model\Request\Payment;

use SigmaNet\SDK\Model\Request\AbstractRequestTransport;
use SigmaNet\SDK\Transport\AbstractApiTransport;

class CreatePaymentTransport extends AbstractRequestTransport
{
    public const PATH = 'payment/create';

    /**
     * @inheritDoc
     */
    public function getPath(): string
    {
        return self::PATH;
    }

    /**
     * @inheritDoc
     */
    public function getMethod(): string
    {
        return AbstractApiTransport::METHOD_POST;
    }
}
