<?php

namespace SigmaNet\SDK\Model\Request\Payout;

use SigmaNet\SDK\Model\Request\AbstractRequest;
use SigmaNet\SDK\Model\Traits\RecursiveRestoreTrait;

class GetPayoutSbpMembersRequest extends AbstractRequest
{
    use RecursiveRestoreTrait;

    public function getRequiredFields(): array
    {
        return [];
    }

    public function getOptionalFields(): array
    {
        return [];
    }
}
