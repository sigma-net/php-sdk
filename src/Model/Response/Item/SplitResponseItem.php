<?php

namespace SigmaNet\SDK\Model\Response\Item;

use SigmaNet\SDK\Model\Response\AbstractResponse;
use SigmaNet\SDK\Model\Traits\RecursiveRestoreTrait;

class SplitResponseItem extends AbstractResponse
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
     * @var MoneyItem|null
     */
    private $commission;

    /**
     * @var MoneyItem|null
     */
    private $availableForRefund;

    /**
     * @var WalletResponseItem
     */
    private $wallet;

    /**
     * @var string[]|null
     */
    private $customParameters;

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
    public function setId($id): self
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
    public function setOrder($order): self
    {
        $this->order = $order;

        return $this;
    }

    /**
     * @return MoneyItem|null
     */
    public function getCommission()
    {
        return $this->commission;
    }

    /**
     * @param MoneyItem|null $commission
     *
     * @return $this
     */
    public function setCommission($commission): self
    {
        $this->commission = $commission;

        return $this;
    }

    /**
     * @return MoneyItem|null
     */
    public function getAvailableForRefund()
    {
        return $this->availableForRefund;
    }

    /**
     * @param MoneyItem|null $availableForRefund
     *
     * @return $this
     */
    public function setAvailableForRefund($availableForRefund): self
    {
        $this->availableForRefund = $availableForRefund;

        return $this;
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
     *
     * @return $this
     */
    public function setWallet($wallet): self
    {
        $this->wallet = $wallet;

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
    public function setCustomParameters($customParameters): self
    {
        $this->customParameters = $customParameters;

        return $this;
    }

    public function getRequiredFields(): array
    {
        return [
            'id' => self::TYPE_INTEGER,
            'wallet' => WalletResponseItem::class,
            'order' => OrderResponseItem::class,
        ];
    }

    public function getOptionalFields(): array
    {
        return [
            'commission' => MoneyItem::class,
            'available_for_refund' => MoneyItem::class,
            'custom_parameters' => self::TYPE_ARRAY,
        ];
    }
}
