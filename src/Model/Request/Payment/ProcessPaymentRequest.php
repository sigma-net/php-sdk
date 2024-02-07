<?php

namespace SigmaNet\SDK\Model\Request\Payment;

use SigmaNet\SDK\Model\Request\AbstractRequest;
use SigmaNet\SDK\Model\Request\Item\PaymentMethodDataItem;
use SigmaNet\SDK\Model\Traits\RecursiveRestoreTrait;

class ProcessPaymentRequest extends AbstractRequest
{
    use RecursiveRestoreTrait;

    /**
     * @var string
     */
    private $token;

    /**
     * @var string
     */
    private $ip;

    /**
     * @var PaymentMethodDataItem
     */
    private $paymentMethodData;

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
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * @param string $ip
     *
     * @return $this
     */
    public function setIp($ip): self
    {
        $this->ip = $ip;

        return $this;
    }

    /**
     * @return PaymentMethodDataItem
     */
    public function getPaymentMethodData()
    {
        return $this->paymentMethodData;
    }

    /**
     * @param PaymentMethodDataItem $paymentMethodData
     *
     * @return $this
     */
    public function setPaymentMethodData($paymentMethodData): self
    {
        $this->paymentMethodData = $paymentMethodData;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getRequiredFields(): array
    {
        return [
            'token' => self::TYPE_STRING,
            'ip' => self::TYPE_STRING,
            'payment_method_data' => PaymentMethodDataItem::class,
        ];
    }

    /**
     * @inheritDoc
     */
    public function getOptionalFields(): array
    {
        return [];
    }
}
