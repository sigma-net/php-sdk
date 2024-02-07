<?php

namespace SigmaNet\SDK\Model\Types;

use SigmaNet\SDK\Exception\Validation\InvalidPropertyException;
use SigmaNet\SDK\Model\Interfaces\RestorableInterface;
use SigmaNet\SDK\Transport\AbstractApiTransport;

class HttpMethodType extends AbstractCustomType
{
    /**
     * @inheritDoc
     */
    public function validate($field): bool
    {
        $httpMethod = $this->getValue($field);

        if (!in_array($httpMethod, [AbstractApiTransport::METHOD_POST, AbstractApiTransport::METHOD_GET], true)) {
            throw new InvalidPropertyException('Unsupportable http method. There are available only POST and GET methods', 0, $field);
        }

        return true;
    }

    /**
     * @inheritDoc
     */
    public function isAccept(): bool
    {
        return true;
    }

    /**
     * @inheritDoc
     */
    public function getBaseType(): string
    {
        return RestorableInterface::TYPE_STRING;
    }
}
