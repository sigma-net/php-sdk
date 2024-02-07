<?php

namespace SigmaNet\SDK\Model\Request\Item;

use SigmaNet\SDK\Model\Traits\RecursiveRestoreTrait;

class RefundReceiptRequestItem extends AbstractRequestItem implements \JsonSerializable
{
    use RecursiveRestoreTrait;

    /**
     * @var array|ItemsReceiptRequestItem[]
     */
    private $items;

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
     * @inheritDoc
     */
    public function getRequiredFields(): array
    {
        return [
            'items' => [ItemsReceiptRequestItem::class],
        ];
    }

    /**
     * @inheritDoc
     */
    public function getOptionalFields(): array
    {
        return [];
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize()
    {
        $receiptItems = [];

        foreach ($this->getItems() as $item) {
            $receiptItems[] = $item->jsonSerialize();
        }

        return [
            'items' => $receiptItems,
        ];
    }
}
