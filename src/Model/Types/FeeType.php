<?php

namespace SigmaNet\SDK\Model\Types;

use SigmaNet\SDK\Exception\Validation\InvalidPropertyException;
use SigmaNet\SDK\Model\Interfaces\RestorableInterface;
use SigmaNet\SDK\Model\Request\Item\FeeItem;

class FeeType extends AbstractCustomType
{
    /**
     * @inheritDoc
     */
    public function validate($field): bool
    {
        $value = $this->getValue($field);

        if (!in_array($value, [FeeItem::TYPE_PAYOUT, FeeItem::TYPE_WALLET], true)) {
            throw new InvalidPropertyException('Unsupportable payment type', 0, $field);
        }

        return true;
    }

    /**
     * @inheritDoc
     */
    public function isAccept(): bool
    {
        return true;
    }

    /**
     * @inheritDoc
     */
    public function getBaseType(): string
    {
        return RestorableInterface::TYPE_STRING;
    }
}
