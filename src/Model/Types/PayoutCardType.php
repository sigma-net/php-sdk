<?php

namespace SigmaNet\SDK\Model\Types;

use SigmaNet\SDK\Exception\Validation\InvalidPropertyException;
use SigmaNet\SDK\Model\Interfaces\RestorableInterface;
use SigmaNet\SDK\Model\PaymentMethods;
use SigmaNet\SDK\Model\PayoutCardTypes;
use SigmaNet\SDK\Model\Response\Item\PayoutMethodItem;

class PayoutCardType extends AbstractCustomType
{
    /**
     * @inheritDoc
     */
    public function validate($field): bool
    {
        $value = $this->getValue($field);

        if ($this->object->getMethod() === PaymentMethods::PAYMENT_METHOD_CARD
            && !in_array($value, PayoutCardTypes::getAvailableCardTypes(), true)) {
            throw new InvalidPropertyException('Unsupportable card type', 0, $field);
        }

        return true;
    }

    /**
     * @inheritDoc
     */
    public function isAccept(): bool
    {
        return $this->object instanceof PayoutMethodItem;
    }

    /**
     * @inheritDoc
     */
    public function getBaseType(): string
    {
        return RestorableInterface::TYPE_STRING;
    }
}
