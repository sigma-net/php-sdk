<?php

namespace SigmaNet\SDK\Model\Request\Payout;

use SigmaNet\SDK\Model\Request\AbstractRequestSerializer;

class CreatePayoutSerializer extends AbstractRequestSerializer
{
    /**
     * @inheritDoc
     */
    public function getSerializedData(): array
    {
        /** @var CreatePayoutRequest $payout */
        $payout = $this->request;

        $payoutMethodData = [
            'type' => $payout->getPayoutMethodData()->getType(),
            'account' => $payout->getPayoutMethodData()->getAccount(),
        ];

        if ($payout->getPayoutMethodData()->getMemberId()) {
            $payoutMethodData['member_id'] = $payout->getPayoutMethodData()->getMemberId();
        }

        $orderData = [
            'amount' => $payout->getOrder()->getAmount(),
            'currency' => $payout->getOrder()->getCurrency(),
            'description' => $payout->getOrder()->getDescription(),
        ];

        $serializedData = [
            'transaction_id' => $payout->getTransactionId(),
            'payout_method_data' => $payoutMethodData,
            'order' => $orderData,
        ];

        if ($payout->getWalletId()) {
            $serializedData['wallet_id'] = $payout->getWalletId();
        }

        if ($payout->getFeeType()) {
            $serializedData['fee_type'] = $payout->getFeeType();
        }

        $customParameters = $payout->getCustomParameters();

        if (!empty($customParameters)) {
            $serializedData['custom_parameters'] = $customParameters;
        }

        return $serializedData;
    }
}
