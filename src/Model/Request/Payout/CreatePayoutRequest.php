<?php

namespace SigmaNet\SDK\Model\Request\Payout;

use SigmaNet\SDK\Model\Request\AbstractRequest;
use SigmaNet\SDK\Model\Request\Item\OrderRequestItem;
use SigmaNet\SDK\Model\Request\Item\PayoutMethodDataItem;
use SigmaNet\SDK\Model\Traits\RecursiveRestoreTrait;
use SigmaNet\SDK\Model\Types\FeeType;

class CreatePayoutRequest extends AbstractRequest
{
    use RecursiveRestoreTrait;

    /**
     * @var string
     */
    private $transactionId;
    /**
     * @var integer|null
     */
    private $walletId;
    /**
     * @var PayoutMethodDataItem
     */
    private $payoutMethodData;
    /**
     * @var string|null
     */
    private $feeType;
    /**
     * @var OrderRequestItem
     */
    private $order;

    /**
     * @var string[]
     */
    private $customParameters;

    /**
     * @return string
     */
    public function getTransactionId()
    {
        return $this->transactionId;
    }

    /**
     * @param string $transactionId
     *
     * @return $this
     */
    public function setTransactionId($transactionId): self
    {
        $this->transactionId = $transactionId;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getWalletId()
    {
        return $this->walletId;
    }

    /**
     * @param int|null $walletId
     *
     * @return $this
     */
    public function setWalletId($walletId): self
    {
        $this->walletId = $walletId;

        return $this;
    }

    /**
     * @return PayoutMethodDataItem
     */
    public function getPayoutMethodData()
    {
        return $this->payoutMethodData;
    }

    /**
     * @param PayoutMethodDataItem $payoutMethodData
     *
     * @return $this
     */
    public function setPayoutMethodData($payoutMethodData): self
    {
        $this->payoutMethodData = $payoutMethodData;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getFeeType()
    {
        return $this->feeType;
    }

    /**
     * @param null|string $feeType
     *
     * @return $this
     * @see \SigmaNet\SDK\Model\Request\Item\FeeItem
     */
    public function setFeeType($feeType): self
    {
        $this->feeType = $feeType;

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
     * @return $this
     */
    public function setOrder($order): self
    {
        $this->order = $order;

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
     * @return $this
     */
    public function setCustomParameters($customParameters): self
    {
        $this->customParameters = $customParameters;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getRequiredFields(): array
    {
        return [
            'transaction_id' => self::TYPE_STRING,
            'payout_method_data' => PayoutMethodDataItem::class,
            'order' => OrderRequestItem::class,
        ];
    }

    /**
     * @inheritDoc
     */
    public function getOptionalFields(): array
    {
        return [
            'fee_type' => new FeeType($this),
            'wallet_id' => self::TYPE_INTEGER,
            'custom_parameters' => self::TYPE_ARRAY,
        ];
    }
}
