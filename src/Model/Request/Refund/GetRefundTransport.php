<?php

namespace SigmaNet\SDK\Model\Request\Refund;

use SigmaNet\SDK\Model\Request\AbstractRequestTransport;

class GetRefundTransport extends AbstractRequestTransport
{
    public const PATH = 'refund/get';

    /**
     * @inheritDoc
     */
    public function getPath(): string
    {
        return self::PATH;
    }
}
