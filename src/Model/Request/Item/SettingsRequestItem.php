<?php

namespace SigmaNet\SDK\Model\Request\Item;

use SigmaNet\SDK\Model\PaymentMethods;
use SigmaNet\SDK\Model\Traits\RecursiveRestoreTrait;
use SigmaNet\SDK\Model\Types\LocaleType;
use SigmaNet\SDK\Model\Types\PaymentType;

class SettingsRequestItem extends AbstractRequestItem
{
    use RecursiveRestoreTrait;
    public const LOCALE_RU = 'ru';
    public const LOCALE_EN = 'en';

    public const PAYER_PERCENT_TYPE_HIGH = 'high';
    public const PAYER_PERCENT_TYPE_LOW = 'low';

    /**
     * @var integer
     */
    private $projectId;

    /**
     * @var string
     */
    private $paymentMethod;

    /**
     * @var string
     */
    private $successUrl;

    /**
     * @var string
     */
    private $failUrl;

    /**
     * @var string
     */
    private $backUrl;

    private $locale = 'ru';

    /**
     * @var \DateTime
     */
    private $expireDate;

    /**
     * @var int
     */
    private $walletId;

    private $isTest = false;

    private $hideFormHeader = false;

    private $hideFormMethods = false;

    private $hideFormTokenizedMethods = false;

    private $hideFormRememberCard = false;

    private $createSubscription = false;

    /**
     * @var string|null
     */
    private $subscriptionToken;

    /**
     * @var boolean|null
     */
    private $capture;

    /**
     * @var array
     */
    private $optionalFields;

    /**
     * @var array
     */
    private $requiredFields;

    /**
     * @var float|null
     */
    private $payerPercent;

    /**
     * @var string|null
     */
    private $payerPercentType;

    /**
     * SettingsRequestItem constructor.
     */
    public function __construct()
    {
        $this->requiredFields = [
            'project_id' => self::TYPE_INTEGER,
        ];

        $this->optionalFields = [
            'payment_method' => new PaymentType($this),
            'success_url' => self::TYPE_STRING,
            'fail_url' => self::TYPE_STRING,
            'back_url' => self::TYPE_STRING,
            'expire_date' => self::TYPE_DATE,
            'wallet_id' => self::TYPE_INTEGER,
            'is_test' => self::TYPE_BOOLEAN,
            'hide_form_header' => self::TYPE_BOOLEAN,
            'hide_form_methods' => self::TYPE_BOOLEAN,
            'hide_form_tokenized_methods' => self::TYPE_BOOLEAN,
            'hide_form_remember_card' => self::TYPE_BOOLEAN,
            'create_subscription' => self::TYPE_BOOLEAN,
            'subscription_token' => self::TYPE_STRING,
            'capture' => self::TYPE_BOOLEAN,
            'locale' => new LocaleType($this),
            'payer_percent' => self::TYPE_FLOAT,
            'payer_percent_type' => self::TYPE_STRING,
        ];
    }

    /**
     * @return int
     */
    public function getProjectId()
    {
        return $this->projectId;
    }

    /**
     * @param int $projectId
     *
     * @return SettingsRequestItem
     */
    public function setProjectId($projectId): self
    {
        $this->projectId = $projectId;

        return $this;
    }

    /**
     * @return string
     * @see PaymentMethods
     */
    public function getPaymentMethod()
    {
        return $this->paymentMethod;
    }

    /**
     * @param string $paymentMethod
     *
     * @return SettingsRequestItem
     * @see PaymentMethods
     */
    public function setPaymentMethod($paymentMethod): self
    {
        $this->paymentMethod = $paymentMethod;

        return $this;
    }

    /**
     * @return string
     */
    public function getSuccessUrl()
    {
        return $this->successUrl;
    }

    /**
     * @param string $successUrl
     *
     * @return SettingsRequestItem
     */
    public function setSuccessUrl($successUrl): self
    {
        $this->successUrl = $successUrl;

        return $this;
    }

    /**
     * @return string
     */
    public function getFailUrl()
    {
        return $this->failUrl;
    }

    /**
     * @param string $failUrl
     *
     * @return SettingsRequestItem
     */
    public function setFailUrl($failUrl): self
    {
        $this->failUrl = $failUrl;

        return $this;
    }

    /**
     * @return string
     */
    public function getBackUrl()
    {
        return $this->backUrl;
    }

    /**
     * @param string $backUrl
     *
     * @return SettingsRequestItem
     */
    public function setBackUrl($backUrl): self
    {
        $this->backUrl = $backUrl;

        return $this;
    }

    /**
     * @return string
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * @param string $locale
     *
     * @return SettingsRequestItem
     */
    public function setLocale($locale): self
    {
        $this->locale = $locale;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getExpireDate()
    {
        return $this->expireDate;
    }

    /**
     * @param \DateTime $expireDate
     *
     * @return $this
     */
    public function setExpireDate($expireDate): self
    {
        $this->expireDate = $expireDate;

        return $this;
    }

    /**
     * @return int
     */
    public function getWalletId()
    {
        return $this->walletId;
    }

    /**
     * @param int $walletId
     *
     * @return $this
     */
    public function setWalletId($walletId): self
    {
        $this->walletId = $walletId;

        return $this;
    }

    /**
     * @return bool
     */
    public function getIsTest()
    {
        return $this->isTest;
    }

    /**
     * @param bool $isTest
     *
     * @return $this
     */
    public function setIsTest($isTest): self
    {
        $this->isTest = $isTest;

        return $this;
    }

    /**
     * @return bool
     */
    public function isHideFormHeader()
    {
        return $this->hideFormHeader;
    }

    /**
     * @param bool $hideFormHeader
     *
     * @return $this
     */
    public function setHideFormHeader($hideFormHeader): self
    {
        $this->hideFormHeader = $hideFormHeader;

        return $this;
    }

    /**
     * @return bool
     */
    public function isHideFormMethods()
    {
        return $this->hideFormMethods;
    }

    /**
     * @param bool $hideFormMethods
     *
     * @return $this
     */
    public function setHideFormMethods($hideFormMethods): self
    {
        $this->hideFormMethods = $hideFormMethods;

        return $this;
    }

    /**
     * @return bool
     */
    public function isHideFormTokenizedMethods()
    {
        return $this->hideFormTokenizedMethods;
    }

    /**
     * @param bool $hideFormTokenizedMethods
     *
     * @return $this
     */
    public function setHideFormTokenizedMethods($hideFormTokenizedMethods): self
    {
        $this->hideFormTokenizedMethods = $hideFormTokenizedMethods;

        return $this;
    }

    /**
     * @return bool
     */
    public function isHideFormRememberCard()
    {
        return $this->hideFormRememberCard;
    }

    /**
     * @param bool $hideFormRememberCard
     *
     * @return $this
     */
    public function setHideFormRememberCard($hideFormRememberCard): self
    {
        $this->hideFormRememberCard = $hideFormRememberCard;

        return $this;
    }

    /**
     * @return bool
     */
    public function isCreateSubscription()
    {
        return $this->createSubscription;
    }

    /**
     * @param bool $createSubscription
     *
     * @return $this
     */
    public function setCreateSubscription($createSubscription): self
    {
        $this->createSubscription = $createSubscription;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getSubscriptionToken()
    {
        return $this->subscriptionToken;
    }

    /**
     * @param string|null $subscriptionToken
     *
     * @return $this
     */
    public function setSubscriptionToken($subscriptionToken): self
    {
        $this->subscriptionToken = $subscriptionToken;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function getCapture()
    {
        return $this->capture;
    }

    /**
     * @param bool|null $capture
     *
     * @return SettingsRequestItem
     */
    public function setCapture($capture): self
    {
        $this->capture = $capture;

        return $this;
    }

    /**
     * @param array $optionalFields
     *
     * @return $this
     */
    public function setOptionalFields($optionalFields): self
    {
        $this->optionalFields = $optionalFields;

        return $this;
    }

    /**
     * @param array $requiredFields
     *
     * @return $this
     */
    public function setRequiredFields($requiredFields): self
    {
        $this->requiredFields = $requiredFields;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getRequiredFields()
    {
        return $this->requiredFields;
    }

    /**
     * @inheritDoc
     */
    public function getOptionalFields()
    {
        return $this->optionalFields;
    }

    /**
     * @return float|null
     */
    public function getPayerPercent()
    {
        return $this->payerPercent;
    }

    /**
     * @param float|null $payerPercent
     *
     * @return $this
     */
    public function setPayerPercent($payerPercent): self
    {
        $this->payerPercent = $payerPercent;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPayerPercentType()
    {
        return $this->payerPercentType;
    }

    /**
     * @param string|null $payerPercentType
     *
     * @return $this
     */
    public function setPayerPercentType($payerPercentType): self
    {
        $this->payerPercentType = $payerPercentType;

        return $this;
    }
}
