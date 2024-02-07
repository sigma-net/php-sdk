<?php

namespace SigmaNet\SDK\Transport\Authorization;

interface AuthorizationInterface
{
    /**
     * @return string
     */
    public function getAuthorizationHeader();
}
