<?php

namespace SigmaNet\SDK\Model\Response\Refund;

use SigmaNet\SDK\Model\Response\Item\OrderResponseItem;
use SigmaNet\SDK\Model\Response\Item\PaymentMethodItem;
use SigmaNet\SDK\Model\Response\Item\RefundResponseItem;
use SigmaNet\SDK\Model\Response\Item\SplitResponseItem;
use SigmaNet\SDK\Model\Response\Item\WalletPayoutResponseItem;
use SigmaNet\SDK\Model\Response\Item\ErrorDetailsItem;
use SigmaNet\SDK\Model\Traits\RecursiveRestoreTrait;

trait RefundResponseTrait
{
    use RecursiveRestoreTrait;

    /**
     * @var int
     */
    private $id;

    /**
     * @var OrderResponseItem
     */
    private $order;

    /**
     * @var RefundResponseItem
     */
    private $refund;

    /**
     * @var WalletPayoutResponseItem
     */
    private $wallet;

    /**
     * @var string
     */
    private $token;

    /**
     * @var int|null
     */
    private $partnerPaymentId;

    /**
     * @var \DateTime
     */
    private $createDate;

    /**
     * @var \DateTime
     */
    private $updateDate;

    /**
     * @var string
     */
    private $status;

    /**
     * @var string|null
     */
    private $statusDescription;

    /**
     * @var ErrorDetailsItem|null
     */
    private $errorDetails;

    /**
     * @var PaymentMethodItem|null
     */
    private $paymentMethod;

    /**
     * @var string[]|null
     */
    private $customParameters;

    /**
     * @var boolean|null
     */
    private $isTest;

    /**
     * @var SplitResponseItem[]|null
     */
    private $split;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return OrderResponseItem
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @param OrderResponseItem $order
     *
     * @return $this
     */
    public function setOrder($order)
    {
        $this->order = $order;

        return $this;
    }

    /**
     * @return RefundResponseItem
     */
    public function getRefund()
    {
        return $this->refund;
    }

    /**
     * @param RefundResponseItem $refund
     *
     * @return $this
     */
    public function setRefund($refund)
    {
        $this->refund = $refund;

        return $this;
    }

    /**
     * @return WalletPayoutResponseItem
     */
    public function getWallet()
    {
        return $this->wallet;
    }

    /**
     * @param WalletPayoutResponseItem $wallet
     *
     * @return $this
     */
    public function setWallet($wallet)
    {
        $this->wallet = $wallet;

        return $this;
    }

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
    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getPartnerPaymentId()
    {
        return $this->partnerPaymentId;
    }

    /**
     * @param int|null $partnerPaymentId
     *
     * @return $this
     */
    public function setPartnerPaymentId($partnerPaymentId)
    {
        $this->partnerPaymentId = $partnerPaymentId;

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
    public function setCreateDate($createDate)
    {
        $this->createDate = $createDate;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getUpdateDate()
    {
        return $this->updateDate;
    }

    /**
     * @param \DateTime $updateDate
     *
     * @return $this
     */
    public function setUpdateDate($updateDate)
    {
        $this->updateDate = $updateDate;

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
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getStatusDescription()
    {
        return $this->statusDescription;
    }

    /**
     * @param string|null $statusDescription
     *
     * @return $this
     */
    public function setStatusDescription($statusDescription)
    {
        $this->statusDescription = $statusDescription;

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
    public function setErrorDetails($errorDetails)
    {
        $this->errorDetails = $errorDetails;

        return $this;
    }

    /**
     * @return PaymentMethodItem|null
     */
    public function getPaymentMethod()
    {
        return $this->paymentMethod;
    }

    /**
     * @param PaymentMethodItem|null $paymentMethod
     *
     * @return $this
     */
    public function setPaymentMethod($paymentMethod)
    {
        $this->paymentMethod = $paymentMethod;

        return $this;
    }

    /**
     * @return string[]|null
     */
    public function getCustomParameters()
    {
        return $this->customParameters;
    }

    /**
     * @param string[]|null $customParameters
     *
     * @return $this
     */
    public function setCustomParameters($customParameters)
    {
        $this->customParameters = $customParameters;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function getIsTest()
    {
        return $this->isTest;
    }

    /**
     * @param bool|null $isTest
     *
     * @return $this
     */
    public function setIsTest($isTest)
    {
        $this->isTest = $isTest;

        return $this;
    }

    /**
     * @return SplitResponseItem[]|null
     */
    public function getSplit()
    {
        return $this->split;
    }

    /**
     * @param SplitResponseItem[]|null $split
     *
     * @return $this
     */
    public function setSplit($split)
    {
        $this->split = $split;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getRequiredFields(): array
    {
        return [
            'id' => self::TYPE_INTEGER,
            'order' => OrderResponseItem::class,
            'refund' => RefundResponseItem::class,
            'wallet' => WalletPayoutResponseItem::class,
            'token' => self::TYPE_STRING,
            'create_date' => self::TYPE_DATE,
            'update_date' => self::TYPE_DATE,
            'status' => self::TYPE_STRING,
        ];
    }

    /**
     * @inheritDoc
     */
    public function getOptionalFields(): array
    {
        return [
            'partner_payment_id' => self::TYPE_STRING,
            'status_description' => self::TYPE_STRING,
            'payment_method' => PaymentMethodItem::class,
            'custom_parameters' => self::TYPE_ARRAY,
            'is_test' => self::TYPE_BOOLEAN,
            'error_details' => ErrorDetailsItem::class,
            'split' => [SplitResponseItem::class],
        ];
    }
}
