<?php

namespace SigmaNet\SDK\Exception\ServerResponse;

class UnauthorizedException extends AbstractResponseException
{
    public const HTTP_CODE = 401;

    /**
     * @inheritDoc
     */
    public function getHttpCode(): int
    {
        return self::HTTP_CODE;
    }
}
