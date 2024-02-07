<?php

namespace SigmaNet\SDK\Model\Request\Item;

use SigmaNet\SDK\Model\Traits\OrderItemTrait;
use SigmaNet\SDK\Model\Traits\RecursiveRestoreTrait;

class OrderRequestItem extends AbstractRequestItem
{
    use OrderItemTrait;
    use RecursiveRestoreTrait;

    /**
     * @inheritDoc
     */
    public function getRequiredFields(): array
    {
        return [
            'currency' => self::TYPE_STRING,
            'amount' => self::TYPE_FLOAT,
        ];
    }

    /**
     * @inheritDoc
     */
    public function getOptionalFields(): array
    {
        return [
            'description' => self::TYPE_STRING,
        ];
    }
}
