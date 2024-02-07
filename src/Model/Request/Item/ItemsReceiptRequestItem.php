<?php

namespace SigmaNet\SDK\Model\Request\Item;

use SigmaNet\SDK\Model\Traits\RecursiveRestoreTrait;
use SigmaNet\SDK\Model\Types\TaxType;

class ItemsReceiptRequestItem extends AbstractRequestItem implements \JsonSerializable
{
    use RecursiveRestoreTrait;

    /** Налог без НДС */
    public const TAX_NONE = 'none';

    /** Налог НДС по ставке 0% */
    public const TAX_VAT0 = 'vat0';

    /** Налог НДС по ставке 10% */
    public const TAX_VAT10 = 'vat10';

    /** Налог НДС по ставке 20% */
    public const TAX_VAT20 = 'vat20';

    /** Налог НДС по расчетной ставке 10/110 */
    public const TAX_VAT110 = 'vat110';

    /** Налог НДС по расчетной ставке 20/120 */
    public const TAX_VAT120 = 'vat120';

    /**
     * @return array
     */
    public static function getAvailableTaxes(): array
    {
        return [
            self::TAX_NONE,
            self::TAX_VAT0,
            self::TAX_VAT10,
            self::TAX_VAT20,
            self::TAX_VAT110,
            self::TAX_VAT120,
        ];
    }

    /**
     * @var string
     */
    private $name;

    /**
     * @var float
     */
    private $price;

    /**
     * @var string
     */
    private $tax;

    /**
     * @var float
     */
    private $sum;

    /**
     * @var float
     */
    private $quantity;

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

    /**
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param float $price
     *
     * @return $this
     */
    public function setPrice($price): self
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return string
     */
    public function getTax()
    {
        return $this->tax;
    }

    /**
     * @param string $tax
     *
     * @return $this
     */
    public function setTax($tax): self
    {
        $this->tax = $tax;

        return $this;
    }

    /**
     * @return float
     */
    public function getSum()
    {
        return $this->sum;
    }

    /**
     * @param float $sum
     *
     * @return $this
     */
    public function setSum($sum): self
    {
        $this->sum = $sum;

        return $this;
    }

    /**
     * @return float
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param float $quantity
     *
     * @return $this
     */
    public function setQuantity($quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getRequiredFields(): array
    {
        return [
            'name' => self::TYPE_STRING,
            'price' => self::TYPE_FLOAT,
            'quantity' => self::TYPE_FLOAT,
            'tax' => new TaxType($this),
        ];
    }

    /**
     * @inheritDoc
     */
    public function getOptionalFields(): array
    {
        return [
            'sum' => self::TYPE_FLOAT,
        ];
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize()
    {
        $itemData = [
            'name' => $this->getName(),
            'price' => $this->getPrice(),
            'quantity' => $this->getQuantity(),
            'tax' => $this->getTax(),
            'sum' => $this->getSum(),
        ];

        $itemData = array_filter($itemData, function ($param) {
            return !empty($param);
        });

        return $itemData;
    }
}
