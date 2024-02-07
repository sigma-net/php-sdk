<?php

namespace SigmaNet\SDK\Model\Response\Item;

use SigmaNet\SDK\Model\Response\AbstractResponse;
use SigmaNet\SDK\Model\Traits\MethodItemTrait;
use SigmaNet\SDK\Model\Traits\RecursiveRestoreTrait;
use SigmaNet\SDK\Model\Types\PaymentType;
use SigmaNet\SDK\Model\Types\PayoutCardType;

class PayoutMethodItem extends AbstractResponse
{
    use RecursiveRestoreTrait;
    use MethodItemTrait;

    /**
     * @var string
     */
    private $method;

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @param string $method
     *
     * @return $this
     */
    public function setMethod($method): self
    {
        $this->method = $method;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getRequiredFields(): array
    {
        return [
            'method' => new PaymentType($this),
            'account' => AbstractResponse::TYPE_STRING,
        ];
    }

    /**
     * @inheritDoc
     */
    public function getOptionalFields(): array
    {
        return [
            'type' => new PayoutCardType($this),
            'rrn' => self::TYPE_STRING,
            'card' => CardItem::class,
        ];
    }
}
