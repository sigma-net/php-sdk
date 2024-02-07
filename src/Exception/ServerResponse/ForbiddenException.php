<?php

namespace SigmaNet\SDK\Exception\ServerResponse;

class ForbiddenException extends AbstractResponseException
{
    public const HTTP_CODE = 403;

    /**
     * @inheritDoc
     */
    public function getHttpCode(): int
    {
        return self::HTTP_CODE;
    }
}
