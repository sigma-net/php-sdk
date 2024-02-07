<?php

namespace SigmaNet\SDK\Model\Response;

use SigmaNet\SDK\Model\Interfaces\RestorableInterface;

abstract class AbstractResponse implements RestorableInterface
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
