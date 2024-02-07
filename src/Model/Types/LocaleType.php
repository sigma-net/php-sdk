<?php

namespace SigmaNet\SDK\Model\Types;

use SigmaNet\SDK\Exception\Validation\InvalidPropertyException;
use SigmaNet\SDK\Model\Interfaces\RestorableInterface;
use SigmaNet\SDK\Model\Request\Item\SettingsRequestItem;

class LocaleType extends AbstractCustomType
{
    /**
     * @inheritDoc
     */
    public function validate($field): bool
    {
        $locale = $this->getValue($field);

        if (!in_array($locale, [SettingsRequestItem::LOCALE_EN, SettingsRequestItem::LOCALE_RU], true)) {
            throw new InvalidPropertyException('Unsupportable locale', 0, $field);
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
