<?php

namespace SigmaNet\SDK\Model\Request\Wallet;

use SigmaNet\SDK\Model\Request\AbstractRequestSerializer;

class WalletSerializer extends AbstractRequestSerializer
{
    public function getSerializedData(): array
    {
        /** @var WalletRequest $walletRequest */
        $walletRequest = $this->request;

        return [
            'id' => $walletRequest->getId(),
        ];
    }
}
