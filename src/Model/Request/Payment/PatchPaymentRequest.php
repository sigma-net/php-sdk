<?php

namespace SigmaNet\SDK\Model\Request\Payment;

use SigmaNet\SDK\Model\Interfaces\RestorableInterface;
use SigmaNet\SDK\Model\Request\AbstractRequest;
use SigmaNet\SDK\Model\Request\Item\OrderRequestItem;
use SigmaNet\SDK\Model\Request\Item\ReceiptRequestItem;
use SigmaNet\SDK\Model\Request\Item\SettingsRequestItem;
use SigmaNet\SDK\Model\Traits\RecursiveRestoreTrait;

/**
 * Class PatchPaymentRequest
 *
 * @package SigmaNet\SDK\Model\Request\Payment
 * @internal
 */
class PatchPaymentRequest extends AbstractRequest
{
    use RecursiveRestoreTrait;

    /**
     * @var string
     */
    private $token;

    /**
     * @var SettingsRequestItem
     */
    private $settings;

    /**
     * @var string[]
     */
    private $customParameters;

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param string $token
     *
     * @return $this
     */
    public function setToken($token): self
    {
        $this->token = $token;

        return $this;
    }

    /**
     * @return SettingsRequestItem
     */
    public function getSettings()
    {
        return $this->settings;
    }

    /**
     * @param SettingsRequestItem $settings
     *
     * @return $this
     */
    public function setSettings($settings): self
    {
        $this->settings = $settings;

        return $this;
    }

    /**
     * @return string[]
     */
    public function getCustomParameters()
    {
        return $this->customParameters;
    }

    /**
     * @param string[] $customParameters
     *
     * @return $this
     */
    public function setCustomParameters($customParameters): self
    {
        $this->customParameters = $customParameters;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getRequiredFields(): array
    {
        if ($this->settings) {
            $fields = array_merge($this->settings->getRequiredFields(), $this->settings->getOptionalFields());
            $this->settings->setOptionalFields($fields);
            $this->settings->setRequiredFields([]);
        }

        return [
            'token' => self::TYPE_STRING,
        ];
    }

    /**
     * @inheritDoc
     */
    public function getOptionalFields(): array
    {
        return [
            'settings' => SettingsRequestItem::class,
            'custom_parameters' => RestorableInterface::TYPE_ARRAY,
        ];
    }
}
