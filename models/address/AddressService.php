<?php

namespace models\address;

class AddressService
{
    private AddressMapper $addressMapper;
    public function __construct()
    {
        $this->addressMapper = new AddressMapper();
    }
    public function addAddress(AddressDTO $dto, int $userId): void
    {
        $address = new Address($dto->country,$dto->city,$dto->street, $dto->zipCode);
        $this->addressMapper->save(new AddressInformation($address, $userId));
    }
    public function findByUserId(int $userId): array
    {
        $addressArray = $this->addressMapper->findByUserId($userId);
        $addressString = [];
        foreach ($addressArray as $address){
            $addressString["addresses"][] = (string)$address->getAddress();
        }
        return  $addressString;
    }
}