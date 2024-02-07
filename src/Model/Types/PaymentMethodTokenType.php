<?php

namespace SigmaNet\SDK\Model\Types;

use SigmaNet\SDK\Exception\Validation\InvalidPropertyException;
use SigmaNet\SDK\Model\Request\AbstractRequest;
use SigmaNet\SDK\Model\Request\Item\PaymentMethodDataItem;

class PaymentMethodTokenType extends AbstractCustomType
{
    /**
     * @inheritDoc
     */
    public function validate($field): bool
    {
        $tokenMode = $this->getValue($field);

        if (empty($tokenMode)) {
            return true;
        }

        $availablePaymentMethods = [
            PaymentMethodDataItem::TOKEN_TYPE_APPLE_PAY,
            PaymentMethodDataItem::TOKEN_TYPE_GOOGLE_PAY,
        ];

        if (!in_array($tokenMode, $availablePaymentMethods, true)) {
            throw new InvalidPropertyException('Unsupportable token type', 0, $field);
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
        return AbstractRequest::TYPE_STRING;
    }
}
