<?php
/**
 * Created by PhpStorm.
 * Date: 26.04.2016
 * Time: 23:04
 */

namespace Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @Entity @Table(name="address")
 **/
class Address
{
    /** @Id @Column(name="id", type="integer") @GeneratedValue **/
    private $id;

    /** @Column(name="city", type="string") **/
    private $city;

    /** @Column(name="street", type="string") **/
    private $street;
    
    /** @Column(name="house_number", type="string") **/
    private $houseNumber;

    /** @Column(name="apartment_number", type="string") **/
    private $apartmentNumber;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param $city
     * @return $this
     */
    public function setCity($city)
    {
        $this->city = $city;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * @param mixed $street
     * @return $this
     */
    public function setStreet($street)
    {
        $this->street = $street;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getHouseNumber()
    {
        return $this->houseNumber;
    }

    /**
     * @param mixed $houseNumber
     * @return $this
     */
    public function setHouseNumber($houseNumber)
    {
        $this->houseNumber = $houseNumber;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getApartmentNumber()
    {
        return $this->apartmentNumber;
    }

    /**
     * @param mixed $apartmentNumber
     * @return $this
     */
    public function setApartmentNumber($apartmentNumber)
    {
        $this->apartmentNumber = $apartmentNumber;
        return $this;
    }
}