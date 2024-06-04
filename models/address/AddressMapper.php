<?php

namespace models\address;

use core\DataMapper;

class AddressMapper extends DataMapper
{
    public function __construct()
    {
        parent::__construct();
    }
    public function save(AddressInformation $addressInformation): void
    {
        $address = $addressInformation->getAddress();
        $this->db->insert("address_information", [
            "user_id" => $addressInformation->getUserId(),
            "country" => $address->getCountry(),
            "city" => $address->getCity(),
            "street" => $address->getStreet(),
            "zip_code" => $address->getZipCode()
        ])->execute();
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
            $data['id'],
            $data['user_id'],
            $address
        );
    }
    public function findByUserId(int $userId): AddressInformation
    {
        return $this->convertToAddressInformation($this->db->select("address_information")
            ->where(["user_id"=> $userId])->execute()->returnAssocArray());
    }
}