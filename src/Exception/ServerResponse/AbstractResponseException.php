<?php

namespace SigmaNet\SDK\Exception\ServerResponse;

abstract class AbstractResponseException extends ResponseException
{
    public const RESPONSE_CODE_UNKNOWN = 'unknown';

    /** @var string */
    protected $responseErrorCode;

    /** @var string */
    protected $responseErrorMessage;

    /**
     * @return int
     */
    abstract public function getHttpCode();

    public function __construct($headers = [], $body = null)
    {
        $this->parseBody($body);
        parent::__construct($this->getResponseMessage(), $this->getHttpCode(), $headers, $body);
    }

    /**
     * @return string
     */
    public function getResponseMessage(): string
    {
        $message = [];

        if ($this->responseErrorCode && $this->responseErrorCode !== self::RESPONSE_CODE_UNKNOWN) {
            $message[] = sprintf('Error: %s.', $this->responseErrorCode);
        }

        if ($this->responseErrorMessage) {
            $message[] = sprintf('Details: %s.', $this->responseErrorMessage);
        }

        return join(' ', $message);
    }

    /**
     * @param string $body
     *
     * @return array|null
     */
    protected function parseBody($body): ?array
    {
        $errors = (array)json_decode($body, true);

        $this->responseErrorCode = !empty($errors['error']) ? $errors['error'] : self::RESPONSE_CODE_UNKNOWN;
        $this->responseErrorMessage = !empty($errors['message']) ? $errors['message'] : 'An unknown API error occurred';

        return $errors;
    }

    /**
     * @return string
     */
    public function getResponseErrorCode()
    {
        return $this->responseErrorCode;
    }

    /**
     * @return string
     */
    public function getResponseErrorMessage()
    {
        return $this->responseErrorMessage;
    }
}
