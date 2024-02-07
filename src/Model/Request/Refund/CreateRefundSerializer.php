<?php

namespace SigmaNet\SDK\Model\Request\Refund;

use SigmaNet\SDK\Model\Request\AbstractRequestSerializer;
use SigmaNet\SDK\Model\Request\Item\RefundReceiptRequestItem;

class CreateRefundSerializer extends AbstractRequestSerializer
{
    /**
     * @inheritDoc
     */
    public function getSerializedData(): array
    {
        /** @var CreateRefundRequest $request */
        $request = $this->request;
        $receipt = $request->getReceipt();

        $serializedData = [
            'token' => $request->getToken(),
            'refund' => $request->getRefund()->jsonSerialize(),
        ];

        if ($request->getPartnerPaymentId()) {
            $serializedData['partner_payment_id'] = $request->getPartnerPaymentId();
        }

        if ($receipt instanceof RefundReceiptRequestItem) {
            $serializedData['receipt'] = $receipt->jsonSerialize();
        }

        return $serializedData;
    }
}
