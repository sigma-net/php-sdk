<?php

namespace SigmaNet\SDK\Model\Request\Reports;

use SigmaNet\SDK\Model\Request\AbstractRequest;
use SigmaNet\SDK\Model\Traits\RecursiveRestoreTrait;
use SigmaNet\SDK\Model\Types\PaymentStatusType;

class PaymentsReportRequest extends AbstractRequest
{
    use RecursiveRestoreTrait;

    /**
     * Начала периода, в формате datetime
     *
     * @var \DateTime
     */
    private $datetimeFrom;

    /**
     * Завершение периода, в формате datetime
     *
     * @var \DateTime
     */
    private $datetimeTo;

    /**
     * Идентификатор проекта
     *
     * @var integer|null
     */
    private $projectId;

    /**
     * Идентификатор статуса платежа.
     *
     * @var string|null
     */
    private $status;

    /**
     * Отображать тестовые платежи (по умолчанию: false)
     *
     * @var boolean|null
     */
    private $showTest;

    /**
     * @return \DateTime
     */
    public function getDatetimeFrom()
    {
        return $this->datetimeFrom;
    }

    /**
     * @param \DateTime $datetimeFrom
     *
     * @return $this
     */
    public function setDatetimeFrom($datetimeFrom): self
    {
        $this->datetimeFrom = $datetimeFrom;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDatetimeTo()
    {
        return $this->datetimeTo;
    }

    /**
     * @param \DateTime $datetimeTo
     *
     * @return $this
     */
    public function setDatetimeTo($datetimeTo): self
    {
        $this->datetimeTo = $datetimeTo;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getProjectId()
    {
        return $this->projectId;
    }

    /**
     * @param int $projectId
     *
     * @return $this
     */
    public function setProjectId($projectId): self
    {
        $this->projectId = $projectId;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $status
     *
     * @return $this
     */
    public function setStatus($status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function isShowTest()
    {
        return $this->showTest;
    }

    /**
     * @param bool $showTest
     *
     * @return $this
     */
    public function setShowTest($showTest): self
    {
        $this->showTest = $showTest;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getRequiredFields(): array
    {
        return [
            'datetime_from' => AbstractRequest::TYPE_DATE,
            'datetime_to' => AbstractRequest::TYPE_DATE,
        ];
    }

    /**
     * @inheritDoc
     */
    public function getOptionalFields(): array
    {
        return [
            'project_id' => AbstractRequest::TYPE_INTEGER,
            'status' => new PaymentStatusType($this),
            'show_test' => AbstractRequest::TYPE_BOOLEAN,
        ];
    }
}
