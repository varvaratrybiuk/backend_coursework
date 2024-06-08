<?php

namespace models\address;

use core\Repository;

class AddressRepository extends Repository
{
    public function __construct()
    {
        parent::__construct();
    }
    public function save(AddressInformation $addressInformation): string|false
    {
        $address = $addressInformation->getAddress();
        $this->db->insert("address_information", [
            "user_id" => $addressInformation->getUserId(),
            "country" => $address->getCountry(),
            "city" => $address->getCity(),
            "street" => $address->getStreet(),
            "zip_code" => $address->getZipCode()
        ])->execute();
        return $this->db->lastInsertId();
    }
    private function convertToAddressInformation(array $data): AddressInformation
    {
        $address = new Address(
            $data['country'],
            $data['city'],
            $data['street'],
            $data['zip_code']
        );

        return new AddressInformation(
            $address,
            $data['user_id'],
            $data["id"]
        );
    }
    private function convertToAddressInformationArray(array $data): array
    {
        $addressInformationArray = [];
        foreach ($data as $addressData) {
            $addressInformationArray[] = $this->convertToAddressInformation($addressData);
        }
        return $addressInformationArray;
    }
    public function findByUserId(int $userId): array
    {
        return $this->convertToAddressInformationArray($this->db->select("address_information")
            ->where(["user_id"=> $userId])->execute()->returnAssocArray());
    }
}