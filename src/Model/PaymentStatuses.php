<?php

namespace SigmaNet\SDK\Model;

final class PaymentStatuses
{
    /** @var string Платеж иницилизирован, ожидаются данные для проведения платежа. */
    public const STATUS_INIT = 'init';

    /** @var string Платеж находится в процессе оплаты на стороне платежной системы. */
    public const STATUS_PROCESS = 'process';

    /** @var string Платеж успешно завершен и по нему были зачислены деньги. Это финальный и неизменяемый статус. */
    public const STATUS_SUCCESSFUL = 'successful';

    /** @var string Платеж является двухэтапным и ожидает подтверждения или отмены. */
    public const STATUS_WAIT_CAPTURE = 'wait_capture';

    /** @var string Отмена платежа после статуса wait_capture. */
    public const STATUS_CANCELED = 'canceled';

    /** @var string Платеж был отвергнут банком-эмитентом или платежным сервисом, отменен или истекло время подтверждения платежа. */
    public const STATUS_ERROR = 'error';

    /** @var string Успешный возврат. Каждый возврат проходит в системе отдельной операцией. */
    public const STATUS_REFUND = 'refund';

    /** @var string Возврат находится в процессе обработки на стороне платежной системы. */
    public const STATUS_REFUND_PROCESS = 'refund_process';

    /** @var string При возврате произошла ошибка. */
    public const STATUS_REFUND_ERROR = 'refund_error';

    public static function getStatuses(): array
    {
        return [
            self::STATUS_INIT,
            self::STATUS_PROCESS,
            self::STATUS_SUCCESSFUL,
            self::STATUS_WAIT_CAPTURE,
            self::STATUS_CANCELED,
            self::STATUS_ERROR,
            self::STATUS_REFUND,
            self::STATUS_REFUND_PROCESS,
            self::STATUS_REFUND_ERROR,
        ];
    }
}
