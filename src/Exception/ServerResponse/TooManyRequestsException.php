<?php

namespace SigmaNet\SDK\Exception\ServerResponse;

class TooManyRequestsException extends AbstractResponseException
{
    public const HTTP_CODE = 429;

    /**
     * @inheritDoc
     */
    public function getHttpCode(): int
    {
        return self::HTTP_CODE;
    }
}
