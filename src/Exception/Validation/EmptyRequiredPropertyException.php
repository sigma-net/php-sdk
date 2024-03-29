<?php

namespace SigmaNet\SDK\Exception\Validation;

use SigmaNet\SDK\Exception\Validation\Traits\PropertyExceptionTrait;

class EmptyRequiredPropertyException extends \InvalidArgumentException
{
    use PropertyExceptionTrait;

    /**
     * @inheritDoc
     */
    public function __construct($message = '', $code = 0, $property = '', $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->property = $property;
    }
}
