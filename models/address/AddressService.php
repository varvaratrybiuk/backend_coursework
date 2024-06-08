<?php

namespace models\address;

class AddressService
{
    private AddressRepository $repository;
    public function __construct()
    {
        $this->repository = new AddressRepository();
    }
    public function addAddress(AddressDTO $dto, int $userId): int
    {
        $address = new Address($dto->country,$dto->city,$dto->street, $dto->zipCode);
        return $this->repository->save(new AddressInformation($address, $userId));
    }
    public function findByUserId(int $userId): array
    {
        $addressArray = $this->repository->findByUserId($userId);
        $addressString = [];
        foreach ($addressArray as $address){
            $addressString["addresses"][] = (string)$address->getAddress();
            $addressString["id"][] = $address->getId();
        }
        return  $addressString;
    }
}