<?php

namespace models\address;

class AddressService
{
    private AddressRepository $repository;
    public function __construct()
    {
        $this->repository = new AddressRepository();
    }
    public function addAddress(AddressDTO $dto, int $userId): void
    {
        $address = new Address($dto->country,$dto->city,$dto->street, $dto->zipCode);
        $this->repository->save(new AddressInformation($address, $userId));
    }
    public function findByUserId(int $userId): array
    {
        $addressArray = $this->repository->findByUserId($userId);
        $addressString = [];
        foreach ($addressArray as $address){
            $addressString["addresses"][] = (string)$address->getAddress();
        }
        return  $addressString;
    }
}