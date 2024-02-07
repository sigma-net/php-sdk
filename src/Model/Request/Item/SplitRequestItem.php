<?php

namespace SigmaNet\SDK\Model\Request\Item;

use SigmaNet\SDK\Model\Traits\RecursiveRestoreTrait;

class SplitRequestItem extends AbstractRequestItem
{
    use RecursiveRestoreTrait;

    /**
     * @var integer
     */
    private $walletId;

    /**
     * @var OrderRequestItem
     */
    private $order;

    /**
     * @var MoneyItem|null
     */
    private $commission;

    /**
     * @var string[]|null
     */
    private $customParameters;

    /**
     * @param int              $walletId
     * @param OrderRequestItem $order
     */
    public function __construct($walletId, $order)
    {
        $this->walletId = $walletId;
        $this->order = $order;
    }

    /**
     * @return int
     */
    public function getWalletId()
    {
        return $this->walletId;
    }

    /**
     * @param int $walletId
     *
     * @return $this
     */
    public function setWalletId($walletId): self
    {
        $this->walletId = $walletId;

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
            'wallet_id' => self::TYPE_INTEGER,
            'order' => OrderRequestItem::class,
        ];
    }

    public function getOptionalFields(): array
    {
        return [
            'commission' => MoneyItem::class,
            'custom_parameters' => self::TYPE_ARRAY,
        ];
    }
}
