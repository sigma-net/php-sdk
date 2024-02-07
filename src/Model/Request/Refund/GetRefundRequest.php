<?php

namespace SigmaNet\SDK\Model\Request\Refund;

use SigmaNet\SDK\Model\Request\AbstractRequest;
use SigmaNet\SDK\Model\Traits\RecursiveRestoreTrait;

class GetRefundRequest extends AbstractRequest
{
    use RecursiveRestoreTrait;

    /**
     * @var string
     */
    private $token;

    /**
     * GetRefundRequest constructor.
     *
     * @param string|null $token
     */
    public function __construct($token = null)
    {
        if (!is_null($token)) {
            $this->token = $token;
        }
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param string $token
     *
     * @return $this
     */
    public function setToken($token): self
    {
        $this->token = $token;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getRequiredFields(): array
    {
        return [
            'token' => self::TYPE_STRING,
        ];
    }

    /**
     * @inheritDoc
     */
    public function getOptionalFields(): array
    {
        return [];
    }
}
