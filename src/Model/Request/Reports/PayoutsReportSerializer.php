<?php

namespace SigmaNet\SDK\Model\Request\Reports;

use SigmaNet\SDK\Model\Request\AbstractRequestSerializer;

class PayoutsReportSerializer extends AbstractRequestSerializer
{
    /**
     * @inheritDoc
     */
    public function getSerializedData(): array
    {
        /** @var PayoutsReportRequest $payoutsReportRequest */
        $payoutsReportRequest = $this->request;
        $data = [
            'datetime_from' => $payoutsReportRequest->getDatetimeFrom()->format('c'),
            'datetime_to' => $payoutsReportRequest->getDatetimeTo()->format('c'),
        ];

        if ($payoutsReportRequest->getWalletId() !== null) {
            $data['wallet_id'] = $payoutsReportRequest->getWalletId();
        }

        if ($payoutsReportRequest->getStatus() !== null) {
            $data['status'] = $payoutsReportRequest->getStatus();
        }

        return $data;
    }
}
