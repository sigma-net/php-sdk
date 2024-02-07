<?php

namespace SigmaNet\SDK\Model\Request\Item;

use SigmaNet\SDK\Model\Traits\RecursiveRestoreTrait;

class ReceiptRequestItem extends AbstractRequestItem
{
    use RecursiveRestoreTrait;

    /**
     * @var array|ItemsReceiptRequestItem[]
     */
    private $items;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $phone;

    /**
     * @var string
     */
    private $place;

    /**
     * ReceiptRequestItem constructor.
     */
    public function __construct()
    {
        $this->items = [];
    }

    /**
     * @return array|ItemsReceiptRequestItem[]
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @param array|ItemsReceiptRequestItem[] $items
     *
     * @return $this
     */
    public function setItems($items): self
    {
        $this->items = $items;

        return $this;
    }

    /**
     * @param ItemsReceiptRequestItem $item
     *
     * @return $this
     */
    public function addItem(ItemsReceiptRequestItem $item): self
    {
        if (!in_array($item, $this->items)) {
            $this->items[] = $item;
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     *
     * @return $this
     */
    public function setEmail($email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     *
     * @return $this
     */
    public function setPhone($phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * @return string
     */
    public function getPlace()
    {
        return $this->place;
    }

    /**
     * @param string $place
     *
     * @return $this
     */
    public function setPlace($place): self
    {
        $this->place = $place;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getRequiredFields(): array
    {
        return [
            'items' => [ItemsReceiptRequestItem::class],
            'place' => self::TYPE_STRING,
        ];
    }

    /**
     * @inheritDoc
     */
    public function getOptionalFields(): array
    {
        return [
            'email' => self::TYPE_STRING,
            'phone' => self::TYPE_STRING,
        ];
    }

    /**
     * @inheritDoc
     */
    public function getThoughOneField(): array
    {
        return [
            ['email', 'phone'],
        ];
    }
}
