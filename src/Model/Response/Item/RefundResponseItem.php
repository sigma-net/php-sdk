<?php

namespace SigmaNet\SDK\Model\Response\Item;

use SigmaNet\SDK\Model\Response\AbstractResponse;
use SigmaNet\SDK\Model\Traits\RecursiveRestoreTrait;

class RefundResponseItem extends AbstractResponse
{
    use RecursiveRestoreTrait;

    /**
     * @var float
     */
    private $amount;

    /**
     * @var string
     */
    private $currency;

    /**
     * @var string|null
     */
    private $reason;

    /**
     * @return float
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param float $amount
     *
     * @return $this
     */
    public function setAmount($amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * @return string
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @param string $currency
     *
     * @return $this
     */
    public function setCurrency($currency): self
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getReason()
    {
        return $this->reason;
    }

    /**
     * @param string|null $reason
     *
     * @return $this
     */
    public function setReason($reason): self
    {
        $this->reason = $reason;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getRequiredFields(): array
    {
        return [
            'amount' => self::TYPE_FLOAT,
            'currency' => self::TYPE_STRING,
        ];
    }

    /**
     * @inheritDoc
     */
    public function getOptionalFields(): array
    {
        return [
            'reason' => self::TYPE_STRING,
        ];
    }
}
