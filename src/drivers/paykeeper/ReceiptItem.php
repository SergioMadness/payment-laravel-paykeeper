<?php namespace professionalweb\payment\drivers\paykeeper;

use professionalweb\payment\drivers\receipt\ReceiptItem as IReceiptItem;

/**
 * Receipt item
 * @package professionalweb\payment\drivers\tinkoff
 */
class ReceiptItem extends IReceiptItem
{

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'name'      => mb_substr($this->getName(), 0, 128),
            'price'     => $this->getPrice(),
            'quantity'  => $this->getQty(),
            'sum'       => $this->getPrice() * $this->getQty(),
            'tax'       => 'none',
            'item_type' => 'goods',
        ];
    }
}