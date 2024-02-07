<?php

namespace SigmaNet\SDK\Exception;

class JsonParseException extends \UnexpectedValueException
{
    /** @var array */
    private $headers;

    /** @var string|null */
    private $body;

    /**
     * @inheritDoc
     */
    public function __construct($message = '', $code = 0, $headers = [], $body = null)
    {
        $jsonErrors = [
            JSON_ERROR_NONE => 'No error has occurred',
            JSON_ERROR_DEPTH => 'The maximum stack depth has been exceeded',
            JSON_ERROR_STATE_MISMATCH => 'Occurs with underflow or with the modes mismatch (invalid or malformed JSON)',
            JSON_ERROR_CTRL_CHAR => 'Control character error, possibly incorrectly encoded',
            JSON_ERROR_SYNTAX => 'Syntax error',
            JSON_ERROR_UTF8 => 'Malformed UTF-8 characters, possibly incorrectly encoded',
        ];

        $jsonErrorMessage = 'Unknown error';

        if (isset($jsonErrors[$code])) {
            $jsonErrorMessage = $jsonErrors[$code];
        }

        $message = sprintf('%s: %s', $message, $jsonErrorMessage);
        $this->headers = $headers;
        $this->body = $body;

        parent::__construct($message, $code);
    }

    /**
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * @return string|null
     */
    public function getBody()
    {
        return $this->body;
    }
}
