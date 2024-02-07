<?php

namespace SigmaNet\SDK\Model\Response\Payment;

use SigmaNet\SDK\Model\Response\AbstractResponse;
use SigmaNet\SDK\Model\Traits\RecursiveRestoreTrait;

class GetPaymentResponse extends AbstractResponse
{
    use RecursiveRestoreTrait;
    use GetPaymentResponseTrait;
}
