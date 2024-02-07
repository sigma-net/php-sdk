<?php

namespace SigmaNet\SDK\Model\Response\Item;

use SigmaNet\SDK\Model\Response\AbstractResponse;
use SigmaNet\SDK\Model\Traits\RecursiveRestoreTrait;

class CardItem extends AbstractResponse
{
    use RecursiveRestoreTrait;

    public const AUTH_TYPE_UNKNOWN = 'unknown';
    public const AUTH_TYPE_3DS_NONE = 'none';
    public const AUTH_TYPE_3DS_FULL = '3ds';
    public const AUTH_TYPE_3DS_2_FULL = '3ds2';
    public const AUTH_TYPE_APPLEPAY = 'applepay';
    public const AUTH_TYPE_GOOGLEPAY = 'googlepay';

    public const USAGE_TYPE_PERSONAL = 'personal';
    public const USAGE_TYPE_COMMERCIAL = 'commercial';
    public const USAGE_TYPE_UNKNOWN = 'unknown';

    /**
     * @var string|null
     */
    private $fingerprint;

    /**
     * @var string|null
     */
    private $category;

    /**
     * @var string|null
     */
    private $country;

    /**
     * @var string|null
     */
    private $bank;

    /**
     * @var string|null
     */
    private $brand;

    /**
     * @var string|null
     */
    private $type;

    /**
     * @var string|null
     * @see CardItem::USAGE_TYPE_PERSONAL
     * @see CardItem::USAGE_TYPE_COMMERCIAL
     * @see CardItem::USAGE_TYPE_UNKNOWN
     */
    private $usageType;

    /**
     * @var bool|null
     * @deprecated
     * @see CardItem::$authType
     */
    private $is3ds;

    /**
     * @var string|null
     * @see CardItem::AUTH_TYPE_UNKNOWN
     * @see CardItem::AUTH_TYPE_3DS_NONE
     * @see CardItem::AUTH_TYPE_3DS_FULL
     * @see CardItem::AUTH_TYPE_3DS_2_FULL
     * @see CardItem::AUTH_TYPE_APPLEPAY
     * @see CardItem::AUTH_TYPE_GOOGLEPAY
     */
    private $authType;

    /**
     * @var bool|null
     */
    private $isPayoutAllowed;

    /**
     * @return string|null
     */
    public function getFingerprint()
    {
        return $this->fingerprint;
    }

    /**
     * @param string|null $fingerprint
     *
     * @return CardItem
     */
    public function setFingerprint($fingerprint): self
    {
        $this->fingerprint = $fingerprint;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param string|null $category
     *
     * @return CardItem
     */
    public function setCategory($category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param string|null $country
     *
     * @return CardItem
     */
    public function setCountry($country): self
    {
        $this->country = $country;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getBank()
    {
        return $this->bank;
    }

    /**
     * @param string|null $bank
     *
     * @return CardItem
     */
    public function setBank($bank): self
    {
        $this->bank = $bank;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     * @param string|null $brand
     * @return CardItem
     */
    public function setBrand($brand): self
    {
        $this->brand = $brand;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string|null $type
     *
     * @return CardItem
     */
    public function setType($type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getUsageType()
    {
        return $this->usageType;
    }

    /**
     * @param string|null $usageType
     *
     * @return CardItem
     */
    public function setUsageType($usageType): self
    {
        $this->usageType = $usageType;

        return $this;
    }

    /**
     * @return bool|null
     * @deprecated
     * @see CardItem::getAuthType
     */
    public function getIs3ds()
    {
        return $this->is3ds;
    }

    /**
     * @param bool|null $is3ds
     *
     * @return CardItem
     * @see CardItem::setAuthType
     *
     * @deprecated
     */
    public function setIs3ds($is3ds): self
    {
        $this->is3ds = $is3ds;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getAuthType()
    {
        return $this->authType;
    }

    /**
     * @param string|null $authType
     *
     * @return $this
     */
    public function setAuthType($authType): self
    {
        $this->authType = $authType;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getRequiredFields(): array
    {
        return [];
    }

    /**
     * @return bool|null
     */
    public function getIsPayoutAllowed()
    {
        return $this->isPayoutAllowed;
    }

    /**
     * @param bool|null $isPayoutAllowed
     *
     * @return $this
     */
    public function setIsPayoutAllowed($isPayoutAllowed): self
    {
        $this->isPayoutAllowed = $isPayoutAllowed;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getOptionalFields(): array
    {
        return [
            'fingerprint' => AbstractResponse::TYPE_STRING,
            'category' => AbstractResponse::TYPE_STRING,
            'country' => AbstractResponse::TYPE_STRING,
            'bank' => AbstractResponse::TYPE_STRING,
            'brand' => AbstractResponse::TYPE_STRING,
            'type' => AbstractResponse::TYPE_STRING,
            'usage_type' => AbstractResponse::TYPE_STRING,
            'is3ds' => AbstractResponse::TYPE_BOOLEAN,
            'auth_type' => AbstractResponse::TYPE_STRING,
            'is_payout_allowed' => AbstractResponse::TYPE_BOOLEAN,
        ];
    }
}
