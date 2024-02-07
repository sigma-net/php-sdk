<?php

namespace SigmaNet\SDK\Model\Request\Reports;

use SigmaNet\SDK\Model\Request\AbstractRequestTransport;
use SigmaNet\SDK\Transport\AbstractApiTransport;

class PaymentsReportTransport extends AbstractRequestTransport
{
    public const PATH = 'report/payments/registry.csv';

    /**
     * @inheritDoc
     */
    public function getPath(): string
    {
        return self::PATH;
    }

    /**
     * @inheritDoc
     */
    public function getMethod(): string
    {
        return AbstractApiTransport::METHOD_GET;
    }

    public function getBodyForRequest()
    {
        return $this->getBody();
    }
}
