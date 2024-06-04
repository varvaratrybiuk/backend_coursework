<?php

namespace models\address;

class AddressInformation
{
    private int $id;
    private int $userId;
    private Address $address;

    public function __construct(int $id, int $userId, Address $address)
    {
        $this->id = $id;
        $this->userId = $userId;
        $this->address = $address;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getAddress(): Address
    {
        return $this->address;
    }
}