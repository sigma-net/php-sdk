<?php

namespace SigmaNet\SDK\Model\Response\Item;

use SigmaNet\SDK\Model\Response\AbstractResponse;
use SigmaNet\SDK\Model\Traits\RecursiveRestoreTrait;
use SigmaNet\SDK\Model\Types\HttpMethodType;

class AuthorizationItem extends AbstractResponse
{
    use RecursiveRestoreTrait;

    /**
     * @var string
     */
    private $action;
    /**
     * @var string
     */
    private $method;
    /**
     * @var array|null
     */
    private $params;

    /**
     * @return string
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @param string $action
     *
     * @return $this
     */
    public function setAction($action): self
    {
        $this->action = $action;

        return $this;
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @param string $method
     *
     * @return $this
     */
    public function setMethod($method): self
    {
        $this->method = $method;

        return $this;
    }

    /**
     * @return array|null
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * @param array|null $params
     *
     * @return $this
     */
    public function setParams($params): self
    {
        $this->params = $params;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getRequiredFields(): array
    {
        return [
            'action' => self::TYPE_STRING,
            'method' => new HttpMethodType($this),
        ];
    }

    /**
     * @inheritDoc
     */
    public function getOptionalFields(): array
    {
        return [
            'params' => self::TYPE_ARRAY,
        ];
    }
}
