<?php

namespace SigmaNet\SDK\Model\Request\Subscription;

use SigmaNet\SDK\Model\Request\AbstractRequestTransport;

class GetSubscriptionTransport extends AbstractRequestTransport
{
    public const PATH = 'subscription/get';

    public function getPath(): string
    {
        return self::PATH;
    }
}
