<?php

namespace SigmaNet\SDK\Model\Response\Item;

use SigmaNet\SDK\Model\Response\AbstractResponse;
use SigmaNet\SDK\Model\Traits\RecursiveRestoreTrait;

class BalanceItem extends AbstractResponse
{
    use RecursiveRestoreTrait;

    /**
     * @var float|null
     */
    private $amount;
    /**
     * @var string
     */
    private $currency;

    /**
     * @return float|null
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param float|null $amount
     */
    public function setAmount($amount): void
    {
        $this->amount = $amount;
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
     */
    public function setCurrency($currency): void
    {
        $this->currency = $currency;
    }

    /**
     * @inheritDoc
     */
    public function getRequiredFields(): array
    {
        return [
            'currency' => self::TYPE_STRING,
        ];
    }

    /**
     * @inheritDoc
     */
    public function getOptionalFields(): array
    {
        return [
            'amount' => self::TYPE_FLOAT,
        ];
    }
}
