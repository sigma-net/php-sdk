<?php

namespace SigmaNet\SDK\Model\Interfaces;

use SigmaNet\SDK\Model\Request\AbstractRequestSerializer;
use SigmaNet\SDK\Model\Request\AbstractRequestTransport;

interface TransportInterface
{
    /**
     * @param AbstractRequestSerializer $serializer
     *
     * @return AbstractRequestTransport
     */
    public function getTransport(AbstractRequestSerializer $serializer);
}
