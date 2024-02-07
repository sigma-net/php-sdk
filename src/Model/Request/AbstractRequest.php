<?php

namespace SigmaNet\SDK\Model\Request;

use SigmaNet\SDK\Model\Interfaces\RestorableInterface;

abstract class AbstractRequest implements RestorableInterface
{
    /**
     * @inheritDoc
     */
    public function getThoughOneField(): array
    {
        return [];
    }

    /**
     * @inheritDoc
     */
    public function __toString()
    {
        return var_export($this, true) ?? '';
    }
}
