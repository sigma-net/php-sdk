<?php

namespace SigmaNet\SDK\Model\Request\Refund;

use SigmaNet\SDK\Model\Request\AbstractRequestTransport;

class CreateRefundTransport extends AbstractRequestTransport
{
    public const PATH = 'refund/create';

    /**
     * @inheritDoc
     */
    public function getPath(): string
    {
        return self::PATH;
    }
}
