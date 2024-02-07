<?php

namespace SigmaNet\SDK\Model\Request\Payment;

use SigmaNet\SDK\Model\Request\AbstractRequestSerializer;

class CapturePaymentSerializer extends AbstractRequestSerializer
{
    /**
     * @inheritDoc
     */
    public function getSerializedData(): array
    {
        /** @var CapturePaymentRequest $paymentRequest */
        $paymentRequest = $this->request;

        return [
            'token' => $paymentRequest->getToken(),
        ];
    }
}
