<?php

namespace models\products;

use Exception;

class Price
{
    private float $amount;

    private string $currency;
    /**
     * @throws Exception
     */
    public function __construct(float $amount, string $currency)
    {
        if ($amount < 0) {
            throw new \Exception("Price cannot be negative.");
        }
        $this->amount = $amount;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function __toString(): string
    {
        return $this->amount . " " . $this->currency;
    }
}