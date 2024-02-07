<?php

namespace SigmaNet\SDK\Model\Request\Payout;

use SigmaNet\SDK\Model\Request\AbstractRequest;
use SigmaNet\SDK\Model\Traits\RecursiveRestoreTrait;

class GetPayoutRequest extends AbstractRequest
{
    use RecursiveRestoreTrait;

    /**
     * @var string
     */
    private $transactionId;
    /**
     * @var int
     */
    private $walletId;

    /**
     * @return string
     */
    public function getTransactionId()
    {
        return $this->transactionId;
    }

    /**
     * @param string $transactionId
     *
     * @return $this
     */
    public function setTransactionId($transactionId): self
    {
        $this->transactionId = $transactionId;

        return $this;
    }

    /**
     * @return int
     */
    public function getWalletId()
    {
        return $this->walletId;
    }

    /**
     * @param int $walletId
     *
     * @return $this
     */
    public function setWalletId($walletId): self
    {
        $this->walletId = $walletId;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getRequiredFields(): array
    {
        return [
            'transaction_id' => self::TYPE_STRING,
        ];
    }

    /**
     * @inheritDoc
     */
    public function getOptionalFields(): array
    {
        return [
            'wallet_id' => self::TYPE_INTEGER,
        ];
    }
}
