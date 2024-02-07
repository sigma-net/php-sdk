<?php

namespace SigmaNet\SDK\Model\Request;

use SigmaNet\SDK\Model\Response\Item\ErrorDetailsItem;
use SigmaNet\SDK\Model\Response\Item\OrderResponseItem;
use SigmaNet\SDK\Model\Response\Item\PaymentMethodItem;
use SigmaNet\SDK\Model\Response\Item\RefundResponseItem;
use SigmaNet\SDK\Model\Response\Item\WalletResponseItem;
use SigmaNet\SDK\Model\Traits\RecursiveRestoreTrait;
use SigmaNet\SDK\Model\Types\NotificationType;

class NotificationRequest extends AbstractRequest
{
    use RecursiveRestoreTrait;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var string|null
     */
    private $partnerPaymentId;

    /**
     * @var OrderResponseItem
     */
    private $order;

    /**
     * @var WalletResponseItem
     */
    private $wallet;

    /**
     * @var RefundResponseItem|null
     */
    private $refund;

    /**
     * @var string
     */
    private $token;

    /**
     * @var \DateTime
     */
    private $createDate;

    /**
     * @var \DateTime|null
     */
    private $expireDate;

    /**
     * @var string|null
     */
    private $ip;

    /**
     * @var string
     */
    private $status;

    /**
     * @deprecated
     * @see $errorDetails
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
     * @var array|null
     */
    private $customParameters;

    /**
     * @var boolean|null
     */
    private $isTest;

    /**
     * @var object
     */
    private $notificationType;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id): void
    {
        $this->id = $id;
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
     */
    public function setPartnerPaymentId($partnerPaymentId): void
    {
        $this->partnerPaymentId = $partnerPaymentId;
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
     */
    public function setOrder($order): void
    {
        $this->order = $order;
    }

    /**
     * @return WalletResponseItem
     */
    public function getWallet()
    {
        return $this->wallet;
    }

    /**
     * @param WalletResponseItem $wallet
     */
    public function setWallet($wallet): void
    {
        $this->wallet = $wallet;
    }

    /**
     * @return RefundResponseItem|null
     */
    public function getRefund()
    {
        return $this->refund;
    }

    /**
     * @param RefundResponseItem|null $refund
     * @return NotificationRequest
     */
    public function setRefund($refund): self
    {
        $this->refund = $refund;

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
     */
    public function setToken($token): void
    {
        $this->token = $token;
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
     */
    public function setCreateDate($createDate): void
    {
        $this->createDate = $createDate;
    }

    /**
     * @return \DateTime|null
     */
    public function getExpireDate()
    {
        return $this->expireDate;
    }

    /**
     * @param \DateTime|null $expireDate
     */
    public function setExpireDate($expireDate): void
    {
        $this->expireDate = $expireDate;
    }

    /**
     * @return null|string
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * @param null|string $ip
     */
    public function setIp($ip): void
    {
        $this->ip = $ip;
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
     */
    public function setStatus($status): void
    {
        $this->status = $status;
    }

    /**
     * @deprecated
     * @see getErrorDetails
     * @return null|string
     */
    public function getStatusDescription()
    {
        return $this->statusDescription;
    }

    /**
     * @deprecated
     * @see setErrorDetails
     * @param null|string $statusDescription
     */
    public function setStatusDescription($statusDescription): void
    {
        $this->statusDescription = $statusDescription;
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
     */
    public function setErrorDetails($errorDetails): void
    {
        $this->errorDetails = $errorDetails;
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
     */
    public function setPaymentMethod($paymentMethod): void
    {
        $this->paymentMethod = $paymentMethod;
    }

    /**
     * @return array|null
     */
    public function getCustomParameters()
    {
        return $this->customParameters;
    }

    /**
     * @param array|null $customParameters
     */
    public function setCustomParameters($customParameters): void
    {
        $this->customParameters = $customParameters;
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
     */
    public function setIsTest($isTest): void
    {
        $this->isTest = $isTest;
    }

    /**
     * @return object
     */
    public function getNotificationType()
    {
        return $this->notificationType;
    }

    /**
     * @param object $notificationType
     */
    public function setNotificationType($notificationType): void
    {
        $this->notificationType = $notificationType;
    }

    public function getRequiredFields(): array
    {
        return [
            'id' => AbstractRequest::TYPE_INTEGER,
            'order' => OrderResponseItem::class,
            'wallet' => WalletResponseItem::class,
            'token' => AbstractRequest::TYPE_STRING,
            'create_date' => AbstractRequest::TYPE_DATE,
            'status' => AbstractRequest::TYPE_STRING,
            'notification_type' => new NotificationType($this),
        ];
    }

    public function getOptionalFields(): array
    {
        return [
            'partner_payment_id' => AbstractRequest::TYPE_STRING,
            'expire_date' => AbstractRequest::TYPE_DATE,
            'status_description' => AbstractRequest::TYPE_STRING,
            'payment_method' => PaymentMethodItem::class,
            'custom_parameters' => AbstractRequest::TYPE_ARRAY,
            'is_test' => AbstractRequest::TYPE_BOOLEAN,
            'error_details' => ErrorDetailsItem::class,
            'refund' => RefundResponseItem::class,
        ];
    }
}
