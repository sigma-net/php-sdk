<?php

namespace SigmaNet\SDK\Model;

final class PaymentMethods
{
    /** @var string Payment method - qiwi */
    public const PAYMENT_METHOD_QIWI = 'qiwi';

    /** @var string Payment method - card */
    public const PAYMENT_METHOD_CARD = 'card';

    /** @var string Payment method - mobile */
    public const PAYMENT_METHOD_MOBILE = 'mobile';

    /** @var string Payment method - webmoney */
    public const PAYMENT_METHOD_WEBMONEY = 'webmoney';

    /** @var string Payment method - yandex */
    public const PAYMENT_METHOD_YANDEX = 'yandex';

    /** @var string Payment method - using card fingerprint signature */
    public const PAYMENT_METHOD_CARD_FINGERPRINT = 'card_fingerprint';

    /** @var string Payment method - tokenized: Apple Pay, Google Pay etc */
    public const PAYMENT_METHOD_CARD_TOKENIZED = 'tokenized';

    /** @var string Payment method - sbp */
    public const PAYMENT_METHOD_SBP = 'sbp';

    /** @var string Payment method - sberbank */
    public const PAYMENT_METHOD_SBERBANK = 'sberbank';

    /** @var string Payment method - tinkoff_pay */
    public const PAYMENT_METHOD_TINKOFF_PAY = 'tinkoff_pay';

    /**
     * @return array
     */
    public static function getAvailablePaymentMethods(): array
    {
        return [
            self::PAYMENT_METHOD_QIWI,
            self::PAYMENT_METHOD_CARD,
            self::PAYMENT_METHOD_MOBILE,
            self::PAYMENT_METHOD_WEBMONEY,
            self::PAYMENT_METHOD_YANDEX,
            self::PAYMENT_METHOD_CARD_FINGERPRINT,
            self::PAYMENT_METHOD_CARD_TOKENIZED,
            self::PAYMENT_METHOD_SBP,
            self::PAYMENT_METHOD_SBERBANK,
            self::PAYMENT_METHOD_TINKOFF_PAY,
        ];
    }
}
