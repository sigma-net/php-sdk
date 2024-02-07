<?php

namespace SigmaNet\SDK\Model\Response\Item;

use SigmaNet\SDK\Model\Response\AbstractResponse;
use SigmaNet\SDK\Model\Traits\RecursiveRestoreTrait;

class ReceiptItem extends AbstractResponse
{
    use RecursiveRestoreTrait;

    /** @var string|null */
    private $qr;

    /** @var string|null */
    private $email;

    /** @var string|null */
    private $phone;

    /** @var string|null */
    private $qrUrl;

    /** @var string|null */
    private $qrImage;

    /** @var string */
    private $status;

    /**
     * @return string|null
     */
    public function getQr()
    {
        return $this->qr;
    }

    /**
     * @param string|null $qr
     *
     * @return self
     */
    public function setQr($qr): self
    {
        $this->qr = $qr;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string|null $email
     *
     * @return self
     */
    public function setEmail($email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param string|null $phone
     *
     * @return self
     */
    public function setPhone($phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getQrUrl()
    {
        return $this->qrUrl;
    }

    /**
     * @param string|null $qrUrl
     *
     * @return self
     */
    public function setQrUrl($qrUrl): self
    {
        $this->qrUrl = $qrUrl;

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
     * @return self
     */
    public function setQrImage($qrImage): self
    {
        $this->qrImage = $qrImage;

        return $this;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $status
     *
     * @return self
     */
    public function setStatus($status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getRequiredFields(): array
    {
        return [
            'status' => self::TYPE_STRING,
        ];
    }

    public function getOptionalFields(): array
    {
        return [
            'qr' => self::TYPE_STRING,
            'email' => self::TYPE_STRING,
            'phone' => self::TYPE_STRING,
            'qr_url' => self::TYPE_STRING,
            'qr_image' => self::TYPE_STRING,
        ];
    }
}
