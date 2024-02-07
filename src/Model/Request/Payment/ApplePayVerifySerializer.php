<?php

namespace SigmaNet\SDK\Model\Request\Payment;

use SigmaNet\SDK\Model\Request\AbstractRequestSerializer;

class ApplePayVerifySerializer extends AbstractRequestSerializer
{
    /**
     * @inheritDoc
     */
    public function getSerializedData(): array
    {
        /** @var ApplePayVerifyRequest $applePayVerifyRequest */
        $applePayVerifyRequest = $this->request;

        return [
            'token' => $applePayVerifyRequest->getToken(),
            'host' => $applePayVerifyRequest->getHost(),
            'validation_url' => $applePayVerifyRequest->getValidationUrl(),
        ];
    }
}
