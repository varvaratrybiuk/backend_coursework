<?php

namespace models\address;

class Address
{
    private string $country;
    private string $city;
    private string $street;
    private string $zipCode;

    public function __construct(string $country, string $city, string $street, string $zipCode) {
        $this->ensureIsValidCountry($country);
        $this->ensureIsValidZipCode($zipCode);

        $this->country = $country;
        $this->city = $city;
        $this->street = $street;
        $this->zipCode = $zipCode;
    }
    public function getCountry(): string
    {
        return $this->country;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function getStreet(): string
    {
        return $this->street;
    }

    public function getZipCode(): string
    {
        return $this->zipCode;
    }
    public function __ToString(): string
    {
        return "{$this->country}  {$this->city}, {$this->street}: {$this->zipCode} ";
    }
    /**
     * @throws \Exception
     */
    private function ensureIsValidCountry(string $country): void
    {
        if ($country !== 'Україна') {
            throw new \Exception("Доставка тільки по Україні.");
        }
    }
    /**
     * @throws \Exception
     */
    private function ensureIsValidZipCode(string $zipCode): void
    {
        if (!preg_match('/^\d{5}$/', $zipCode)) {
            throw new \Exception("Недійсний формат поштового індексу. Індекс повинен містити 5 цифр.");
        }
    }

}