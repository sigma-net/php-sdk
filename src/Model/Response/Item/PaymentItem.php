<?php

namespace SigmaNet\SDK\Model\Response\Item;

use SigmaNet\SDK\Model\Response\AbstractResponse;
use SigmaNet\SDK\Model\Response\Payment\GetPaymentResponseTrait;
use SigmaNet\SDK\Model\Traits\RecursiveRestoreTrait;

class PaymentItem extends AbstractResponse
{
    use RecursiveRestoreTrait;
    use GetPaymentResponseTrait;
}
