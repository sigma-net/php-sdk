<?php

namespace SigmaNet\SDK\Model\Response\Item;

use SigmaNet\SDK\Model\Response\AbstractResponse;
use SigmaNet\SDK\Model\Traits\MethodItemTrait;
use SigmaNet\SDK\Model\Traits\RecursiveRestoreTrait;
use SigmaNet\SDK\Model\Types\PaymentType;

class PaymentMethodItem extends AbstractResponse
{
    use RecursiveRestoreTrait;
    use MethodItemTrait;

    /** @var string|null */
    protected $qrLink;

    /** @var string|null */
    protected $qrImage;

    /** @var string|null */
    protected $tinkoffPayLink;

    /** @var string|null */
    protected $tinkoffPayQrUrl;

    /**
     * @return string|null
     */
    public function getQrLink()
    {
        return $this->qrLink;
    }

    /**
     * @param string|null $qrLink
     *
     * @return $this
     */
    public function setQrLink($qrLink): self
    {
        $this->qrLink = $qrLink;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getQrImage()
    {
        return $this->qrImage;
    }

    /**
     * @param string|null $qrImage
     *
     * @return $this
     */
    public function setQrImage($qrImage): self
    {
        $this->qrImage = $qrImage;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getTinkoffPayLink()
    {
        return $this->tinkoffPayLink;
    }

    /**
     * @param string|null $tinkoffPayLink
     */
    public function setTinkoffPayLink($tinkoffPayLink): self
    {
        $this->tinkoffPayLink = $tinkoffPayLink;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getTinkoffPayQrUrl()
    {
        return $this->tinkoffPayQrUrl;
    }

    /**
     * @param string|null $tinkoffPayQrUrl
     */
    public function setTinkoffPayQrUrl($tinkoffPayQrUrl): self
    {
        $this->tinkoffPayQrUrl = $tinkoffPayQrUrl;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getRequiredFields(): array
    {
        return [
            'type' => new PaymentType($this),
        ];
    }

    /**
     * @inheritDoc
     */
    public function getOptionalFields(): array
    {
        return [
            'account' => self::TYPE_STRING,
            'rrn' => self::TYPE_STRING,
            'card' => CardItem::class,
            'qr_link' => self::TYPE_STRING,
            'qr_image' => self::TYPE_STRING,
            'tinkoff_pay_link' => self::TYPE_STRING,
            'tinkoff_pay_qr_url' => self::TYPE_STRING,
        ];
    }
}
