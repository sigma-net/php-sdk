<?php

namespace SigmaNet\SDK\Model\Request;

use SigmaNet\SDK\Exception\TransportException;
use SigmaNet\SDK\Transport\AbstractApiTransport;

abstract class AbstractRequestTransport
{
    /** @var AbstractRequestSerializer|null */
    protected $serializer;

    /**
     * AbstractRequestTransport constructor.
     *
     * @param AbstractRequestSerializer $serializer
     */
    public function __construct(AbstractRequestSerializer $serializer = null)
    {
        $this->serializer = $serializer;
    }

    /**
     * @return string
     */
    abstract public function getPath();

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return AbstractApiTransport::METHOD_POST;
    }

    /**
     * @return array
     * @throws TransportException
     */
    public function getQueryParams()
    {
        if (!$this->serializer) {
            throw new TransportException('Serializer not found');
        }

        return $this->getMethod() == AbstractApiTransport::METHOD_GET ? $this->serializer->getSerializedData() : [];
    }

    /**
     * @return array
     * @throws TransportException
     */
    public function getBody()
    {
        if (!$this->serializer) {
            throw new TransportException('Serializer not found');
        }

        return $this->getMethod() == AbstractApiTransport::METHOD_POST ? $this->serializer->getSerializedData() : [];
    }

    /**
     * @return false|string
     * @throws TransportException
     */
    public function getBodyForRequest()
    {
        return json_encode($this->getBody());
    }

    /**
     * @return array
     */
    public function getHeaders(): array
    {
        return [];
    }
}
