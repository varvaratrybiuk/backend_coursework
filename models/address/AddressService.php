<?php

namespace models\address;

class AddressService
{
    private AddressMapper $addressMapper;
    public function __construct()
    {
        $this->addressMapper = new AddressMapper();
    }
    public function addAddress(string $country, string $city, string $street, string $zipCode, int $userId): void
    {
        $address = new Address($country, $city, $street, $zipCode);
        $this->addressMapper->save(new AddressInformation($address, $userId));
    }
    public function findByUserId(int $userId): string
    {
        $address = $this->addressMapper->findByUserId($userId)->getAddress();
        return (string)$address;
    }
}