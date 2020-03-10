<?php

namespace App\Models;

use App\Core\Database;
use App\Repository\AddressRepository;

class Address
{

    private $repo;

    private $id;
    private $streetName;
    private $streetNameAlt;
    private $postalCode;
    private $city;
    private $cityAlt;
    private $minApartmentNo;
    private $maxApartmentNo;

    public function __construct(AddressRepository $repo)
    {
        $this->repo = $repo;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getStreetName()
    {
        return $this->streetName;
    }

    /**
     * @param mixed $streetName
     */
    public function setStreetName($streetName)
    {
        $this->streetName = $streetName;
    }

    /**
     * @return mixed
     */
    public function getStreetNameAlt()
    {
        return $this->streetNameAlt;
    }

    /**
     * @param mixed $streetNameAlt
     */
    public function setStreetNameAlt($streetNameAlt)
    {
        $this->streetNameAlt = $streetNameAlt;
    }

    /**
     * @return mixed
     */
    public function getPostalCode()
    {
        return $this->postalCode;
    }

    /**
     * @param mixed $postalCode
     */
    public function setPostalCode($postalCode)
    {
        $this->postalCode = $postalCode;
    }

    /**
     * @return mixed
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param mixed $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * @return mixed
     */
    public function getCityAlt()
    {
        return $this->cityAlt;
    }

    /**
     * @param mixed $cityAlt
     */
    public function setCityAlt($cityAlt)
    {
        $this->cityAlt = $cityAlt;
    }

    /**
     * @return mixed
     */
    public function getMinApartmentNo()
    {
        return $this->minApartmentNo;
    }

    /**
     * @param mixed $minApartmentNo
     */
    public function setMinApartmentNo($minApartmentNo)
    {
        $this->minApartmentNo = $minApartmentNo;
    }

    /**
     * @return mixed
     */
    public function getMaxApartmentNo()
    {
        return $this->maxApartmentNo;
    }

    /**
     * @param mixed $maxApartmentNo
     */
    public function setMaxApartmentNo($maxApartmentNo)
    {
        $this->maxApartmentNo = $maxApartmentNo;
    }


    /**
     * @param null $streetName
     * @param null $streetNameAlt
     * @return array
     */
    public function getAddressByName($streetName = '')
    {
        //query
        $data = $this->repo->getAddressByName($streetName);
        $numberOfRecords = $data['rowCount'];
        $addresses = array();
        $index = 0;
        if (!empty($numberOfRecords)) {
            foreach ($data['rows'] as $row) {
                $address = $this->createAddressInstance($row);
                $addresses[$index] = $address->format();
                $index++;
            }
        }
        return $addresses;
    }

    /**
     * @param array $data
     * @return Address
     * create instance of a class with values from database
     * but does not save it
     */
    protected function createAddressInstance(array $data)
    {
        $this->setId($data['id']);
        $this->setStreetName($data['street_name']);
        $this->setStreetNameAlt($data['street_name_alt']);
        $this->setPostalCode($data['postal_code']);
        $this->setCity($data['city']);
        $this->setCityAlt($data['city_alt']);
        $this->setMinApartmentNo($data['min_apartment_no']);
        $this->setMaxApartmentNo($data['max_apartment_no']);
        return $this;
    }

    public function format()
    {
        return [
            'type' => 'street',
            'id' => $this->id,
            'attributes' => [
                'streetName' => $this->streetName,
                'streetNameAlt' => $this->streetNameAlt,
                'postalCode' => $this->postalCode,
                'city' => $this->city,
                'cityAlt' => $this->cityAlt,
                'minApartmentNo' => $this->minApartmentNo,
                'maxApartmentNo' => $this->maxApartmentNo
            ]
        ];
    }
}
