<?php

namespace SigmaNet\SDK\Model\Request\Wallet;

use SigmaNet\SDK\Model\Interfaces\TransportInterface;
use SigmaNet\SDK\Model\Request\AbstractRequest;
use SigmaNet\SDK\Model\Request\AbstractRequestSerializer;
use SigmaNet\SDK\Model\Traits\RecursiveRestoreTrait;

class WalletRequest extends AbstractRequest implements TransportInterface
{
    use RecursiveRestoreTrait;

    /** @var string */
    private $id;

    /**
     * WalletRequest constructor.
     *
     * @param string $id
     */
    public function __construct($id)
    {
        $this->setId($id);
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId($id): void
    {
        if (is_int($id)) {
            $id = (string)$id;
        }

        $this->id = $id;
    }

    /**
     * @inheritDoc
     */
    public function getRequiredFields(): array
    {
        return [
            'id' => AbstractRequest::TYPE_STRING,
        ];
    }

    /**
     * @inheritDoc
     */
    public function getOptionalFields(): array
    {
        return [];
    }

    /**
     * @inheritDoc
     */
    public function getTransport(AbstractRequestSerializer $serializer)
    {
        return new WalletTransport($serializer);
    }
}
