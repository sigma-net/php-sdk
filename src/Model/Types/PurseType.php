<?php

namespace SigmaNet\SDK\Model\Types;

use SigmaNet\SDK\Exception\Validation\InvalidPropertyException;
use SigmaNet\SDK\Model\Interfaces\RestorableInterface;
use SigmaNet\SDK\Model\Request\Item\PaymentMethodDataItem;

class PurseType extends AbstractCustomType
{
    /**
     * @inheritDoc
     */
    public function validate($field): bool
    {
        $value = $this->getValue($field);

        $availablePurseType = [
            PaymentMethodDataItem::WEBMONEY_WALLET_PURSE_P,
            PaymentMethodDataItem::WEBMONEY_WALLET_PURSE_R,
            PaymentMethodDataItem::WEBMONEY_WALLET_PURSE_Z,
            PaymentMethodDataItem::WEBMONEY_WALLET_PURSE_E,
            PaymentMethodDataItem::WEBMONEY_WALLET_PURSE_U,
            PaymentMethodDataItem::WEBMONEY_WALLET_PURSE_B,
        ];

        if (!in_array($value, $availablePurseType, true)) {
            $message = sprintf('Unsupportable purse type: %s. Expected one of %s', $value, join(', ', $availablePurseType));
            throw new InvalidPropertyException($message, 0, $field);
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
