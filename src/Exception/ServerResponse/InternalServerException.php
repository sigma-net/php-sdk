<?php

namespace SigmaNet\SDK\Exception\ServerResponse;

class InternalServerException extends AbstractResponseException
{
    public const HTTP_CODE = 500;

    /**
     * @inheritDoc
     */
    public function getHttpCode(): int
    {
        return self::HTTP_CODE;
    }
}
