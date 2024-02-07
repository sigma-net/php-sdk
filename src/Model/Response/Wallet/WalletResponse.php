<?php

namespace SigmaNet\SDK\Model\Response\Wallet;

use SigmaNet\SDK\Model\Response\AbstractResponse;
use SigmaNet\SDK\Model\Response\Item\BalanceItem;
use SigmaNet\SDK\Model\Traits\RecursiveRestoreTrait;

class WalletResponse extends AbstractResponse
{
    use RecursiveRestoreTrait;
    public const WALLET_TYPE_INDIVIDUAL = 'individual';

    public const WALLET_TYPE_LEGAL = 'legal';

    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var BalanceItem
     */
    private $balance;

    /**
     * @var string
     */
    private $type;

    /**
     * @var boolean
     */
    private $isIdentified;

    /**
     * @var boolean
     */
    private $isDefault;

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
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return BalanceItem
     */
    public function getBalance()
    {
        return $this->balance;
    }

    /**
     * @param BalanceItem $balance
     */
    public function setBalance($balance): void
    {
        $this->balance = $balance;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type): void
    {
        $this->type = $type;
    }

    /**
     * @return bool
     */
    public function getIsIdentified()
    {
        return $this->isIdentified;
    }

    /**
     * @param bool $isIdentified
     */
    public function setIsIdentified($isIdentified): void
    {
        $this->isIdentified = $isIdentified;
    }

    /**
     * @return bool
     */
    public function getIsDefault()
    {
        return $this->isDefault;
    }

    /**
     * @param bool $isDefault
     */
    public function setIsDefault($isDefault): void
    {
        $this->isDefault = $isDefault;
    }

    /**
     * @return bool
     */
    public function isLegal(): bool
    {
        return $this->getType() == self::WALLET_TYPE_LEGAL;
    }

    /**
     * @return bool
     */
    public function isIndividual(): bool
    {
        return $this->getType() == self::WALLET_TYPE_INDIVIDUAL;
    }

    /**
     * @inheritDoc
     */
    public function getRequiredFields(): array
    {
        return [
            'id' => self::TYPE_STRING,
            'name' => self::TYPE_STRING,
            'balance' => BalanceItem::class,
            'type' => self::TYPE_STRING,
            'is_identified' => self::TYPE_BOOLEAN,
            'is_default' => self::TYPE_BOOLEAN,
        ];
    }

    /**
     * @inheritDoc
     */
    public function getOptionalFields(): array
    {
        return [];
    }
}
