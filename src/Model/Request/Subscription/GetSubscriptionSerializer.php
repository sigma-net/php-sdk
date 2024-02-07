<?php

namespace SigmaNet\SDK\Model\Request\Subscription;

use SigmaNet\SDK\Model\Request\AbstractRequestSerializer;

class GetSubscriptionSerializer extends AbstractRequestSerializer
{
    public function getSerializedData(): array
    {
        /** @var GetSubscriptionRequest $request */
        $request = $this->request;

        return [
            'token' => $request->getToken(),
        ];
    }
}
