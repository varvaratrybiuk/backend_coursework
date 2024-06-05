<?php

namespace models\address;

class AddressDTO
{
    public string $country;
    public string $city;
    public string $street;
    public string $zipCode;

    public function __construct(string $country, string $city, string $street, string $zipCode)
    {
        $this->country = $country;
        $this->city = $city;
        $this->street = $street;
        $this->zipCode = $zipCode;
    }
}