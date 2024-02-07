<?php

namespace SigmaNet\SDK\Model\Request\Payment;

use SigmaNet\SDK\Model\Request\AbstractRequestSerializer;

class GetPaymentSerializer extends AbstractRequestSerializer
{
    /**
     * @inheritDoc
     */
    public function getSerializedData(): array
    {
        /** @var GetPaymentRequest $getPaymentRequest */
        $getPaymentRequest = $this->request;

        return [
            'token' => $getPaymentRequest->getToken(),
        ];
    }
}
