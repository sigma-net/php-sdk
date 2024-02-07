<?php

namespace SigmaNet\SDK\Model\Request\Item;

use SigmaNet\SDK\Model\Interfaces\RestorableInterface;

abstract class AbstractRequestItem implements RestorableInterface
{
    /**
     * @inheritDoc
     */
    public function getThoughOneField(): array
    {
        return [];
    }
}
