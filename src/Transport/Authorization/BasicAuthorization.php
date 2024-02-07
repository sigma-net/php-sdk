<?php

namespace SigmaNet\SDK\Transport\Authorization;

class BasicAuthorization extends AbstractAuthorization
{
    public const AUTH_TYPE = 'Basic';

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $password;

    /**
     * BasicAuthorization constructor.
     *
     * @param string $username
     * @param string $password
     */
    public function __construct($username, $password)
    {
        $this->username = $username;
        $this->password = $password;
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
        return base64_encode($this->username . ':' . $this->password);
    }
}
