<?php

namespace SigmaNet\SDK\Exception\ServerResponse;

class BadRequestException extends AbstractResponseException
{
    public const HTTP_CODE = 400;

    /** @var string|null */
    private $validationPath;

    /** @var string|null */
    private $validationMessage;

    /** @var string|null */
    private $originalToken;

    /**
     * @inheritDoc
     */
    public function getHttpCode(): int
    {
        return self::HTTP_CODE;
    }

    protected function parseBody($body): ?array
    {
        $errors = parent::parseBody($body);

        if (!is_array($errors)) {
            return null;
        }

        if (!empty($errors['validation_error'])) {
            $this->validationPath = !empty($errors['validation_error']['path']) ? $errors['validation_error']['path'] : null;
            $this->validationMessage = !empty($errors['validation_error']['message']) ? $errors['validation_error']['message'] : null;
        }

        if (!empty($errors['original_token'])) {
            $this->originalToken = !empty($errors['original_token']) ? $errors['original_token'] : null;
        }

        return null;
    }

    /**
     * @return string|null
     */
    public function getValidationPath()
    {
        return $this->validationPath;
    }

    /**
     * @return string|null
     */
    public function getValidationMessage()
    {
        return $this->validationMessage;
    }

    /**
     * @return string|null
     */
    public function getOriginalToken()
    {
        return $this->originalToken;
    }
}
