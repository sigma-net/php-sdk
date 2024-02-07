<?php

namespace SigmaNet\SDK\Exception\ServerResponse;

class RequestTimeoutException extends AbstractResponseException
{
    public const HTTP_CODE = 408;

    /**
     * @inheritDoc
     */
    public function getHttpCode(): int
    {
        return self::HTTP_CODE;
    }
}
