<?php

namespace SigmaNet\SDK\Transport\Authorization;

class TokenAuthorization extends AbstractAuthorization
{
    public const AUTH_TYPE = 'Bearer';

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $token;

    /**
     * TokenAuthorization constructor.
     *
     * @param string $username
     * @param string $token
     */
    public function __construct($username, $token)
    {
        $this->username = $username;
        $this->token = $token;
    }

    /**
     * @inheritDoc
     */
    protected function getType(): string
    {
        return self::AUTH_TYPE;
    }

    /**
     * @inheritDoc
     */
    protected function getAuth(): string
    {
        return $this->username . ':' . $this->token;
    }
}
