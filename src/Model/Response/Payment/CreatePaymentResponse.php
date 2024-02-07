<?php

namespace SigmaNet\SDK\Model\Response\Payment;

use SigmaNet\SDK\Model\Response\AbstractResponse;
use SigmaNet\SDK\Model\Response\Item\OrderResponseItem;
use SigmaNet\SDK\Model\Response\Item\ProjectResponseItem;
use SigmaNet\SDK\Model\Response\Item\WalletResponseItem;
use SigmaNet\SDK\Model\Traits\RecursiveRestoreTrait;

class CreatePaymentResponse extends AbstractResponse
{
    use RecursiveRestoreTrait;
    use GetPaymentResponseTrait;

    /**
     * @var string
     */
    private $paymentUrl;

    /**
     * @return string
     */
    public function getPaymentUrl()
    {
        return $this->paymentUrl;
    }

    /**
     * @inheritDoc
     */
    public function getRequiredFields(): array
    {
        return [
            'id' => AbstractResponse::TYPE_INTEGER,
            'order' => OrderResponseItem::class,
            'token' => AbstractResponse::TYPE_STRING,
            'status' => AbstractResponse::TYPE_STRING,
            'payment_url' => AbstractResponse::TYPE_STRING,
            'create_date' => AbstractResponse::TYPE_DATE,
            'wallet' => WalletResponseItem::class,
            'project' => ProjectResponseItem::class,
        ];
    }
}
