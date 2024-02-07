<?php

namespace SigmaNet\SDK\Model\Response\Payment;

use SigmaNet\SDK\Model\Response\AbstractResponse;
use SigmaNet\SDK\Model\Traits\RecursiveRestoreTrait;

class ApplePayVerifyResponse extends AbstractResponse implements \JsonSerializable
{
    use RecursiveRestoreTrait;

    /** @var array|null */
    private $appleResponse;

    /** @var string|null */
    private $error;

    /**
     * @return array|null
     */
    public function getAppleResponse()
    {
        return $this->appleResponse;
    }

    /**
     * @return string|null
     */
    public function getError()
    {
        return $this->error;
    }

    public function isError(): bool
    {
        return !empty($this->error);
    }

    /**
     * @inheritDoc
     */
    public function getRequiredFields(): array
    {
        return [];
    }

    /**
     * @inheritDoc
     */
    public function getOptionalFields(): array
    {
        return [
            'apple_response' => AbstractResponse::TYPE_ARRAY,
            'error' => AbstractResponse::TYPE_STRING,
        ];
    }

    /**
     * @inheritDoc
     */
    public function getThoughOneField(): array
    {
        return [
            ['apple_response', 'error'],
        ];
    }

    public function jsonSerialize()
    {
        return array_filter([
            'apple_response' => $this->getAppleResponse(),
            'error' => $this->getError(),
        ]);
    }
}
