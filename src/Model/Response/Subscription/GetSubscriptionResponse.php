<?php

namespace SigmaNet\SDK\Model\Response\Subscription;

use SigmaNet\SDK\Model\Response\AbstractResponse;
use SigmaNet\SDK\Model\Response\Item\ErrorDetailsItem;
use SigmaNet\SDK\Model\Response\Item\PaymentItem;
use SigmaNet\SDK\Model\Traits\RecursiveRestoreTrait;

class GetSubscriptionResponse extends AbstractResponse
{
    use RecursiveRestoreTrait;

    public const STATUS_INIT = 'init';
    public const STATUS_ACTIVE = 'active';
    public const STATUS_DISABLED = 'disabled';
    public const STATUS_DECLINE = 'decline';

    /**
     * @var string
     */
    private $token;

    /**
     * @var string
     */
    private $status;

    /**
     * @var \DateTime
     */
    private $createDate;

    /**
     * @var ErrorDetailsItem|null
     */
    private $errorDetails;

    /**
     * @var PaymentItem
     */
    private $parentPayment;

    /**
     * @var PaymentItem[]
     */
    private $payments;

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
     * @return string
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
     * @return \DateTime
     */
    public function getCreateDate()
    {
        return $this->createDate;
    }

    /**
     * @param \DateTime $createDate
     *
     * @return $this
     */
    public function setCreateDate($createDate): self
    {
        $this->createDate = $createDate;

        return $this;
    }

    /**
     * @return PaymentItem
     */
    public function getParentPayment()
    {
        return $this->parentPayment;
    }

    /**
     * @param PaymentItem $parentPayment
     *
     * @return $this
     */
    public function setParentPayment($parentPayment): self
    {
        $this->parentPayment = $parentPayment;

        return $this;
    }

    /**
     * @return PaymentItem[]
     */
    public function getPayments()
    {
        return $this->payments;
    }

    /**
     * @param PaymentItem[] $payments
     *
     * @return $this
     */
    public function setPayments($payments): self
    {
        $this->payments = $payments;

        return $this;
    }

    /**
     * @return ErrorDetailsItem|null
     */
    public function getErrorDetails()
    {
        return $this->errorDetails;
    }

    /**
     * @param ErrorDetailsItem|null $errorDetails
     *
     * @return $this
     */
    public function setErrorDetails($errorDetails): self
    {
        $this->errorDetails = $errorDetails;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getRequiredFields(): array
    {
        return [
            'token' => self::TYPE_STRING,
            'status' => self::TYPE_STRING,
            'create_date' => self::TYPE_DATE,
            'parent_payment' => PaymentItem::class,
            'payments' => [PaymentItem::class],
        ];
    }

    /**
     * @inheritDoc
     */
    public function getOptionalFields(): array
    {
        return [
            'error_details' => ErrorDetailsItem::class,
        ];
    }
}
