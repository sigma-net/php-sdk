<?php

namespace SigmaNet\SDK\Model\Request\Reports;

use SigmaNet\SDK\Model\Request\AbstractRequestSerializer;

class PaymentsReportSerializer extends AbstractRequestSerializer
{
    /**
     * @inheritDoc
     */
    public function getSerializedData(): array
    {
        /** @var PaymentsReportRequest $paymentsReportRequest */
        $paymentsReportRequest = $this->request;
        $data = [
            'datetime_from' => $paymentsReportRequest->getDatetimeFrom()->format('c'),
            'datetime_to' => $paymentsReportRequest->getDatetimeTo()->format('c'),
        ];

        if ($paymentsReportRequest->getProjectId() !== null) {
            $data['project_id'] = $paymentsReportRequest->getProjectId();
        }

        if ($paymentsReportRequest->getStatus() !== null) {
            $data['status'] = $paymentsReportRequest->getStatus();
        }

        if ($paymentsReportRequest->isShowTest()) {
            $data['show_test'] = true;
        }

        return $data;
    }
}
