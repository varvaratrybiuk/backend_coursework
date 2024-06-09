<?php

namespace models\products;

use Exception;

class Price
{
    private float $amount;

    /**
     * @throws Exception
     */
    public function __construct(float $amount)
    {
        if ($amount < 0) {
            throw new \Exception("Ціна не може бути від'ємною");
        }
        $this->amount = $amount;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

}