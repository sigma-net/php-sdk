<?php

namespace SigmaNet\SDK\Model\Request\Payout;

use SigmaNet\SDK\Model\Request\AbstractRequestTransport;

class GetPayoutSbpMembersTransport extends AbstractRequestTransport
{
    public const PATH = 'payout/sbp-members';

    /**
     * @inheritDoc
     */
    public function getPath(): string
    {
        return self::PATH;
    }
}
