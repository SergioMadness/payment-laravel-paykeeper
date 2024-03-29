<?php namespace professionalweb\payment\drivers\paykeeper;

use professionalweb\payment\drivers\receipt\Receipt as IReceipt;

/**
 * Receipt
 * @package professionalweb\payment\drivers\tinkoff
 */
class Receipt extends IReceipt
{

    /**
     * Phone number
     *
     * @var string
     */
    private $email;

    /**
     * Receipt constructor.
     *
     * @param string     $phone
     * @param string     $email
     * @param array|null $items
     * @param int        $taxSystem
     */
    public function __construct(?string $phone = null, ?string $email = null, array $items = [], ?string $taxSystem = null)
    {
        parent::__construct($phone ?? $email, $items, $taxSystem);
        $this->setEmail($email);
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param $email
     *
     * @return $this
     */
    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Receipt to array
     *
     * @return array
     */
    public function toArray()
    {
        $prods = [];

        foreach ($this->getItems() as $item) {
            $prods[] = [
                'name'      => $item->getName(),
                'price'     => $item->getPrice(),
                'quantity'  => $item->getQty(),
                'sum'       => $item->getPrice() * $item->getQty(),
                'tax'       => 'none',
                'item_type' => 'goods',
            ];
        }

        return $prods;
    }

    /**
     * Receipt to json
     *
     * @return string
     */
    public function __toString()
    {
        return json_encode($this->toArray());
    }
}