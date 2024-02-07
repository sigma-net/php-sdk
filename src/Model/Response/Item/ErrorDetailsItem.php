<?php

namespace SigmaNet\SDK\Model\Response\Item;

use SigmaNet\SDK\Model\Response\AbstractResponse;
use SigmaNet\SDK\Model\Traits\RecursiveRestoreTrait;

class ErrorDetailsItem extends AbstractResponse
{
    use RecursiveRestoreTrait;

    public const GENERAL_DECLINE = 'general_decline';
    public const SECURITY_DECLINE = 'security_decline';
    public const EXTERNAL_DECLINE = 'external_decline';
    public const INVALID_ACCOUNT = 'invalid_account';
    public const UNSUPPORTED_ACCOUNT = 'unsupported_account';
    public const EXPIRED_CARD = 'expired_card';
    public const TRANSACTION_LIMIT_EXCEEDED = 'transaction_limit_exceeded';
    public const ACCOUNT_LIMIT_EXCEEDED = 'account_limit_exceeded';
    public const INSUFFICIENT_FUNDS = 'insufficient_funds';
    public const EXPIRED_TRANSACTION = 'expired_transaction';
    public const COUNTRY_UNSUPPORTED = 'country_unsupported';
    public const GATEWAY_UNAVAILABLE = 'gateway_unavailable';

    /**
     * @var string
     */
    private $error;
    /**
     * @var string
     */
    private $description;

    /**
     * @return string
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * @param string $error
     *
     * @return $this
     */
    public function setError($error): self
    {
        $this->error = $error;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     *
     * @return $this
     */
    public function setDescription($description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getRequiredFields(): array
    {
        return [
            'error' => self::TYPE_STRING,
            'description' => self::TYPE_STRING,
        ];
    }

    public function getOptionalFields(): array
    {
        return [];
    }
}
