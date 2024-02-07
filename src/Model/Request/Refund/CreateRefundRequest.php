<?php

namespace SigmaNet\SDK\Model\Request\Refund;

use SigmaNet\SDK\Model\Request\AbstractRequest;
use SigmaNet\SDK\Model\Request\Item\RefundReceiptRequestItem;
use SigmaNet\SDK\Model\Request\Item\RefundRequestItem;
use SigmaNet\SDK\Model\Traits\RecursiveRestoreTrait;

class CreateRefundRequest extends AbstractRequest
{
    use RecursiveRestoreTrait;

    /**
     * @var string
     */
    private $token;

    /**
     * @var RefundRequestItem
     */
    private $refund;

    /**
     * @var string|null
     */
    private $partnerPaymentId;

    /**
     * @var int|null
     */
    private $splitId;

    /**
     * @var RefundReceiptRequestItem
     */
    private $receipt;

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param string $token
     *
     * @return $this
     */
    public function setToken($token): self
    {
        $this->token = $token;

        return $this;
    }

    /**
     * @return RefundRequestItem
     */
    public function getRefund()
    {
        return $this->refund;
    }

    /**
     * @param RefundRequestItem $refund
     *
     * @return $this
     */
    public function setRefund($refund): self
    {
        $this->refund = $refund;

        return $this;
    }

    /**
     * @return RefundReceiptRequestItem
     */
    public function getReceipt()
    {
        return $this->receipt;
    }

    /**
     * @param RefundReceiptRequestItem $receipt
     *
     * @return $this
     */
    public function setReceipt($receipt): self
    {
        $this->receipt = $receipt;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPartnerPaymentId()
    {
        return $this->partnerPaymentId;
    }

    /**
     * @param string|null $partnerPaymentId
     *
     * @return $this
     */
    public function setPartnerPaymentId($partnerPaymentId): self
    {
        $this->partnerPaymentId = $partnerPaymentId;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getSplitId()
    {
        return $this->splitId;
    }

    /**
     * @param int|null $splitId
     *
     * @return $this
     */
    public function setSplitId($splitId): self
    {
        $this->splitId = $splitId;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getRequiredFields(): array
    {
        return [
            'token' => self::TYPE_STRING,
            'refund' => RefundRequestItem::class,
        ];
    }

    /**
     * @inheritDoc
     */
    public function getOptionalFields(): array
    {
        return [
            'partner_payment_id' => self::TYPE_STRING,
            'receipt' => RefundReceiptRequestItem::class,
            'split_id' => self::TYPE_INTEGER,
        ];
    }
}
