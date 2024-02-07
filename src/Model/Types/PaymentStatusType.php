<?php

namespace SigmaNet\SDK\Model\Types;

use SigmaNet\SDK\Exception\Validation\InvalidPropertyException;
use SigmaNet\SDK\Model\PaymentStatuses;
use SigmaNet\SDK\Model\Request\AbstractRequest;

class PaymentStatusType extends AbstractCustomType
{
    /**
     * @inheritDoc
     */
    public function validate($field): bool
    {
        $paymentStatus = $this->getValue($field);

        if (!in_array($paymentStatus, PaymentStatuses::getStatuses(), true)) {
            throw new InvalidPropertyException('Unsupportable payment status', 0, $field);
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
