<?php

namespace SigmaNet\SDK\Model;

final class PayoutStatuses
{
    /** @var string Выплата иницилизирована и находится в очереди на выполнение. */
    public const STATUS_INIT = 'init';

    /** @var string Выплата в процессе на стороне платежной системы. */
    public const STATUS_PROCESS = 'process';

    /** @var string Выплата успешно завершена. Это финальный и неизменяемый статус. */
    public const STATUS_SUCCESSFUL = 'successful';

    /** @var string Выплата была отклонена платежной системой. Это финальный и неизменяемый статус. */
    public const STATUS_ERROR = 'error';

    public static function getStatuses(): array
    {
        return [
            self::STATUS_INIT,
            self::STATUS_PROCESS,
            self::STATUS_SUCCESSFUL,
            self::STATUS_ERROR,
        ];
    }
}
