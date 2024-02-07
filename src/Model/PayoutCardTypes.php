<?php

namespace SigmaNet\SDK\Model;

final class PayoutCardTypes
{
    public const CARD_TYPE_CARD_RU = 'card_ru';

    public const CARD_TYPE_CARD_WORLD = 'card_world';

    /**
     * @return array
     */
    public static function getAvailableCardTypes(): array
    {
        return [
            self::CARD_TYPE_CARD_RU,
            self::CARD_TYPE_CARD_WORLD,
        ];
    }
}
