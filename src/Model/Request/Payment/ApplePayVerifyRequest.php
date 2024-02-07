<?php

namespace SigmaNet\SDK\Model\Request\Payment;

use SigmaNet\SDK\Model\Request\AbstractRequest;
use SigmaNet\SDK\Model\Traits\RecursiveRestoreTrait;

class ApplePayVerifyRequest extends AbstractRequest
{
    use RecursiveRestoreTrait;

    /**
     * @var string
     */
    private $token;

    /**
     * @var string
     */
    private $host;

    /**
     * string
     */
    private $validationUrl;

    /**
     * ApplePayVerifyRequest constructor.
     *
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        $this->token = $data['token'] ?? null;
        $this->host = $data['host'] ?? null;
        $this->validationUrl = $data['validationUrl'] ?? null;
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
     * @return string
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * @param string $host
     *
     * @return $this
     */
    public function setHost($host): self
    {
        $this->host = $host;

        return $this;
    }

    /**
     * @return mixed|null
     */
    public function getValidationUrl()
    {
        return $this->validationUrl;
    }

    /**
     * @param mixed|null $validationUrl
     *
     * @return $this
     */
    public function setValidationUrl($validationUrl): self
    {
        $this->validationUrl = $validationUrl;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getRequiredFields(): array
    {
        return [
            'token' => AbstractRequest::TYPE_STRING,
            'host' => AbstractRequest::TYPE_STRING,
            'validation_url' => AbstractRequest::TYPE_STRING,
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
