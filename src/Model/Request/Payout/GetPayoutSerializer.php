<?php

namespace SigmaNet\SDK\Model\Request\Payout;

use SigmaNet\SDK\Model\Request\AbstractRequestSerializer;

class GetPayoutSerializer extends AbstractRequestSerializer
{
    /**
     * @inheritDoc
     */
    public function getSerializedData(): array
    {
        $payout = $this->request;
        $serializedData = [];

        if ($payout instanceof GetPayoutRequest) {
            $serializedData['transaction_id'] = $payout->getTransactionId();

            if ($payout->getWalletId()) {
                $serializedData['wallet_id'] = $payout->getWalletId();
            }
        } elseif ($payout instanceof GetPayoutRequestById) {
            $serializedData['id'] = $payout->getId();
        }

        return $serializedData;
    }
}
