<?php

namespace SigmaNet\SDK\Model\Types;

use SigmaNet\SDK\Exception\Validation\InvalidPropertyException;
use SigmaNet\SDK\Model\Interfaces\RestorableInterface;
use SigmaNet\SDK\Model\Request\Item\ItemsReceiptRequestItem;

class TaxType extends AbstractCustomType
{
    /**
     * @inheritDoc
     */
    public function validate($field): void
    {
        $tax = $this->getValue($field);


        if (!in_array($tax, ItemsReceiptRequestItem::getAvailableTaxes(), true)) {
            throw new InvalidPropertyException('Unsupportable tax type', 0, $field);
        }

        return;
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
