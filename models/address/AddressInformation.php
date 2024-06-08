<?php

namespace models\address;

class AddressInformation
{
    private ?int $id;
    private int $userId;
    private Address $address;

    public function __construct(Address $address, int $userId, ?int $id = null)
    {
        $this->userId = $userId;
        $this->address = $address;
        $this->id = $id;
    }
    public function getId()
    {
        return $this->id;
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