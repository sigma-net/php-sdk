<?php

namespace SigmaNet\SDK\Exception\ServerResponse;

class NotFoundException extends AbstractResponseException
{
    public const HTTP_CODE = 404;

    /**
     * @inheritDoc
     */
    public function getHttpCode(): int
    {
        return self::HTTP_CODE;
    }
}
