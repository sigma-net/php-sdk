<?php

namespace SigmaNet\SDK\Model\Types;

use SigmaNet\SDK\Exception\Validation\InvalidPropertyException;
use SigmaNet\SDK\Model\NotificationTypes;
use SigmaNet\SDK\Model\Request\AbstractRequest;

class NotificationType extends AbstractCustomType
{
    public function validate($field): bool
    {
        $notificationType = $this->getValue($field);

        if (!in_array($notificationType, NotificationTypes::getAvailableTypes(), true)) {
            throw new InvalidPropertyException('Unsupportable payment status', 0, $field);
        }

        return true;
    }

    public function isAccept(): bool
    {
        return true;
    }

    public function getBaseType(): string
    {
        return AbstractRequest::TYPE_STRING;
    }
}
