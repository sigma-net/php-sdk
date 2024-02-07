<?php

namespace SigmaNet\SDK\Model\Types;

use SigmaNet\SDK\Exception\Validation\InvalidPropertyException;
use SigmaNet\SDK\Model\PayoutStatuses;
use SigmaNet\SDK\Model\Request\AbstractRequest;

class PayoutsStatusType extends AbstractCustomType
{
    /**
     * @inheritDoc
     */
    public function validate($field): bool
    {
        $paymentStatus = $this->getValue($field);

        if (!in_array($paymentStatus, PayoutStatuses::getStatuses(), true)) {
            throw new InvalidPropertyException('Unsupportable payout status', 0, $field);
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
