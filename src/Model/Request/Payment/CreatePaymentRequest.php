<?php

namespace SigmaNet\SDK\Model\Request\Payment;

use SigmaNet\SDK\Model\Request\AbstractRequest;
use SigmaNet\SDK\Model\Request\Item\OrderRequestItem;
use SigmaNet\SDK\Model\Request\Item\ReceiptRequestItem;
use SigmaNet\SDK\Model\Request\Item\SettingsRequestItem;
use SigmaNet\SDK\Model\Request\Item\SplitRequestItem;
use SigmaNet\SDK\Model\Traits\RecursiveRestoreTrait;

class CreatePaymentRequest extends AbstractRequest
{
    use RecursiveRestoreTrait;

    /**
     * @var string|null
     */
    private $partnerPaymentId;

    /**
     * @var OrderRequestItem
     */
    private $order;

    /**
     * @var SettingsRequestItem
     */
    private $settings;

    /**
     * @var string[]
     */
    private $customParameters;

    /**
     * @var ReceiptRequestItem
     */
    private $receipt;

    /**
     * @var SplitRequestItem[]|null
     */
    private $split;

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
     * @return OrderRequestItem
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @param OrderRequestItem $order
     *
     * @return self
     */
    public function setOrder($order): self
    {
        $this->order = $order;

        return $this;
    }

    /**
     * @return SettingsRequestItem
     */
    public function getSettings()
    {
        return $this->settings;
    }

    /**
     * @param SettingsRequestItem $settings
     *
     * @return self
     */
    public function setSettings($settings): self
    {
        $this->settings = $settings;

        return $this;
    }

    /**
     * @return string[]
     */
    public function getCustomParameters()
    {
        return $this->customParameters;
    }

    /**
     * @param string[] $customParameters
     *
     * @return self
     */
    public function setCustomParameters($customParameters): self
    {
        $this->customParameters = $customParameters;

        return $this;
    }

    /**
     * @return ReceiptRequestItem
     */
    public function getReceipt()
    {
        return $this->receipt;
    }

    /**
     * @param ReceiptRequestItem $receipt
     *
     * @return $this
     */
    public function setReceipt($receipt): self
    {
        $this->receipt = $receipt;

        return $this;
    }

    /**
     * @return SplitRequestItem[]|null
     */
    public function getSplit()
    {
        return $this->split;
    }

    /**
     * @param SplitRequestItem[]|null $split
     *
     * @return $this
     */
    public function setSplit($splits): self
    {
        $this->split = $splits;

        return $this;
    }

    /**
     * @param SplitRequestItem $split
     *
     * @return $this
     */
    public function addSingleSplit($split): self
    {
        if (!is_array($this->split)) {
            $this->split = [];
        }

        $this->split[] = $split;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getRequiredFields(): array
    {
        return [
            'order' => OrderRequestItem::class,
            'settings' => SettingsRequestItem::class,
        ];
    }

    /**
     * @inheritDoc
     */
    public function getOptionalFields(): array
    {
        return [
            'partner_payment_id' => self::TYPE_STRING,
            'custom_parameters' => self::TYPE_ARRAY,
            'receipt' => ReceiptRequestItem::class,
            'split' => [SplitRequestItem::class],
        ];
    }
}
