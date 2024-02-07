<?php

namespace SigmaNet\SDK\Model\Response\Item;

use SigmaNet\SDK\Model\Response\AbstractResponse;
use SigmaNet\SDK\Model\Traits\RecursiveRestoreTrait;

class SbpMemberItem extends AbstractResponse
{
    use RecursiveRestoreTrait;

    /** @var string */
    private $memberId;

    /** @var string */
    private $nameRus;

    /** @var string */
    private $name;

    /**
     * @return string
     */
    public function getMemberId()
    {
        return $this->memberId;
    }

    /**
     * @param string $memberId
     *
     * @return $this
     */
    public function setMemberId($memberId): self
    {
        $this->memberId = $memberId;

        return $this;
    }

    /**
     * @return string
     */
    public function getNameRus()
    {
        return $this->nameRus;
    }

    /**
     * @param string $nameRus
     *
     * @return $this
     */
    public function setNameRus($nameRus): self
    {
        $this->nameRus = $nameRus;

        return $this;
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
     *
     * @return $this
     */
    public function setName($name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getRequiredFields(): array
    {
        return [
            'member_id' => self::TYPE_STRING,
            'name_rus' => self::TYPE_STRING,
            'name' => self::TYPE_STRING,
        ];
    }

    public function getOptionalFields(): array
    {
        return [];
    }
}
