<?php

namespace SigmaNet\SDK\Model\Response\Payout;

use SigmaNet\SDK\Model\Response\AbstractResponse;
use SigmaNet\SDK\Model\Response\Item\SbpMemberItem;
use SigmaNet\SDK\Model\Traits\RecursiveRestoreTrait;

class GetPayoutSbpMembersResponse extends AbstractResponse
{
    use RecursiveRestoreTrait;

    /**
     * @var SbpMemberItem[]
     */
    private $members;

    public function getRequiredFields(): array
    {
        return [
            'members' => [SbpMemberItem::class],
        ];
    }

    public function getOptionalFields(): array
    {
        return [];
    }
}
