<?php

namespace SigmaNet\SDK\Model\Response\Item;

use SigmaNet\SDK\Model\Interfaces\RestorableInterface;
use SigmaNet\SDK\Model\Response\AbstractResponse;
use SigmaNet\SDK\Model\Traits\OrderItemTrait;
use SigmaNet\SDK\Model\Traits\RecursiveRestoreTrait;

class OrderResponseItem extends AbstractResponse
{
    use OrderItemTrait;
    use RecursiveRestoreTrait;

    /**
     * @inheritDoc
     */
    public function getOptionalFields(): array
    {
        return [
            'description' => RestorableInterface::TYPE_STRING,
        ];
    }

    public function getRequiredFields(): array
    {
        return [
            'currency' => RestorableInterface::TYPE_STRING,
            'amount' => RestorableInterface::TYPE_FLOAT,
        ];
    }
}
