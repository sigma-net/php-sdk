<?php

namespace SigmaNet\SDK\Model\Request\Refund;

use SigmaNet\SDK\Model\Request\AbstractRequestSerializer;

class GetRefundSerializer extends AbstractRequestSerializer
{
    /**
     * @inheritDoc
     */
    public function getSerializedData(): array
    {
        /** @var GetRefundRequest $request */
        $request = $this->request;

        return [
            'token' => $request->getToken(),
        ];
    }
}
