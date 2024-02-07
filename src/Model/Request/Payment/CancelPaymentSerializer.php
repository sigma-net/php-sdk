<?php

namespace SigmaNet\SDK\Model\Request\Payment;

use SigmaNet\SDK\Model\Request\AbstractRequestSerializer;

class CancelPaymentSerializer extends AbstractRequestSerializer
{
    /**
     * @inheritDoc
     */
    public function getSerializedData(): array
    {
        /** @var CancelPaymentRequest $cancelPaymentRequest */
        $cancelPaymentRequest = $this->request;
        $serializedData = [
            'token' => $cancelPaymentRequest->getToken(),
        ];

        if ($cancelPaymentRequest->getReason()) {
            $serializedData['reason'] = $cancelPaymentRequest->getReason();
        }

        return $serializedData;
    }
}
