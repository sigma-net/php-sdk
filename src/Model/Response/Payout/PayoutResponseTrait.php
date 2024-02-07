<?php

namespace SigmaNet\SDK\Model\Response\Payout;

use SigmaNet\SDK\Model\Interfaces\RestorableInterface;
use SigmaNet\SDK\Model\Request\Item\FeeItem;
use SigmaNet\SDK\Model\Response\AbstractResponse;
use SigmaNet\SDK\Model\Response\Item\ErrorDetailsItem;
use SigmaNet\SDK\Model\Response\Item\MoneyItem;
use SigmaNet\SDK\Model\Response\Item\PayoutMethodItem;
use SigmaNet\SDK\Model\Response\Item\WalletPayoutResponseItem;
use SigmaNet\SDK\Model\Traits\RecursiveRestoreTrait;

trait PayoutResponseTrait
{
    use RecursiveRestoreTrait;

    /**
     * @var int
     */
    private $id;
    /**
     * @var string
     */
    private $transactionId;
    /**
     * @var string
     */
    private $status;
    /**
     * @var \DateTime
     */
    private $createDate;
    /**
     * @var \DateTime
     */
    private $updateDate;
    /**
     * @var PayoutMethodItem
     */
    private $payoutMethod;
    /**
     * @var WalletPayoutResponseItem
     */
    private $wallet;
    /**
     * @var FeeItem
     */
    private $fee;
    /**
     * @var MoneyItem
     */
    private $transfer;
    /**
     * @var MoneyItem
     */
    private $request;
    /**
     * @var ErrorDetailsItem|null
     */
    private $errorDetails;

    /**
     * @var string|null
     */
    private $description;

    /**
     * @var array|null
     */
    private $customParameters;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getTransactionId()
    {
        return $this->transactionId;
    }

    /**
     * @param string $transactionId
     *
     * @return $this
     */
    public function setTransactionId($transactionId)
    {
        $this->transactionId = $transactionId;

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
     * @return $this
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreateDate()
    {
        return $this->createDate;
    }

    /**
     * @param \DateTime $createDate
     *
     * @return $this
     */
    public function setCreateDate($createDate)
    {
        $this->createDate = $createDate;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getUpdateDate()
    {
        return $this->updateDate;
    }

    /**
     * @param \DateTime $updateDate
     *
     * @return $this
     */
    public function setUpdateDate($updateDate)
    {
        $this->updateDate = $updateDate;

        return $this;
    }

    /**
     * @return PayoutMethodItem
     */
    public function getPayoutMethod()
    {
        return $this->payoutMethod;
    }

    /**
     * @param PayoutMethodItem $payoutMethod
     *
     * @return $this
     */
    public function setPayoutMethod($payoutMethod)
    {
        $this->payoutMethod = $payoutMethod;

        return $this;
    }

    /**
     * @return WalletPayoutResponseItem
     */
    public function getWallet()
    {
        return $this->wallet;
    }

    /**
     * @param WalletPayoutResponseItem $wallet
     *
     * @return $this
     */
    public function setWallet($wallet)
    {
        $this->wallet = $wallet;

        return $this;
    }

    /**
     * @return FeeItem
     */
    public function getFee()
    {
        return $this->fee;
    }

    /**
     * @param FeeItem $fee
     *
     * @return $this
     */
    public function setFee($fee)
    {
        $this->fee = $fee;

        return $this;
    }

    /**
     * @return MoneyItem
     */
    public function getTransfer()
    {
        return $this->transfer;
    }

    /**
     * @param MoneyItem $transfer
     *
     * @return $this
     */
    public function setTransfer($transfer)
    {
        $this->transfer = $transfer;

        return $this;
    }

    /**
     * @return MoneyItem
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @param MoneyItem $request
     */
    public function setRequest($request): void
    {
        $this->request = $request;
    }

    /**
     * @return ErrorDetailsItem|null
     */
    public function getErrorDetails()
    {
        return $this->errorDetails;
    }

    /**
     * @param ErrorDetailsItem|null $errorDetails
     *
     * @return $this
     */
    public function setErrorDetails($errorDetails)
    {
        $this->errorDetails = $errorDetails;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     *
     * @return $this
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return array|null
     */
    public function getCustomParameters()
    {
        return $this->customParameters;
    }

    /**
     * @param array|null $customParameters
     *
     * @return $this
     */
    public function setCustomParameters($customParameters)
    {
        $this->customParameters = $customParameters;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getRequiredFields(): array
    {
        return [
            'id' => RestorableInterface::TYPE_INTEGER,
            'transaction_id' => RestorableInterface::TYPE_STRING,
            'status' => RestorableInterface::TYPE_STRING,
            'create_date' => RestorableInterface::TYPE_DATE,
            'update_date' => RestorableInterface::TYPE_DATE,
            'payout_method' => PayoutMethodItem::class,
            'wallet' => WalletPayoutResponseItem::class,
            'fee' => FeeItem::class,
            'transfer' => MoneyItem::class,
            'request' => MoneyItem::class,
        ];
    }

    /**
     * @inheritDoc
     */
    public function getOptionalFields(): array
    {
        return [
            'error_details' => ErrorDetailsItem::class,
            'custom_parameters' => AbstractResponse::TYPE_ARRAY,
            'description' => RestorableInterface::TYPE_STRING,
        ];
    }
}
