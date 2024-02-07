<?php

namespace SigmaNet\SDK\Transport\Authorization;

abstract class AbstractAuthorization implements AuthorizationInterface
{
    /**
     * @return string
     */
    abstract protected function getType();

    /**
     * @return string
     */
    abstract protected function getAuth();

    /**
     * @inheritDoc
     */
    public function getAuthorizationHeader(): string
    {
        return sprintf('%s %s', $this->getType(), $this->getAuth());
    }
}
