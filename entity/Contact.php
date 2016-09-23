<?php
/**
 * Created by PhpStorm.
 * Date: 26.04.2016
 * Time: 23:04
 */

namespace Entity;

use Doctrine\ORM\Mapping as ORM;

require_once __DIR__ . '/../entity/Address.php';

/**
 * @Entity @Table(name="contact")
 **/
class Contact
{
    /** @Id @Column(name="id", type="integer") @GeneratedValue **/
    private $id;

    /** @Column(name="websites", type="string") **/
    private $websites;

    /** @Column(name="phone", type="integer") **/
    private $phone;

    /**
     * @OneToOne(targetEntity="Address")
     * @JoinColumn(name="address_id", referencedColumnName="id")
     */
    private $address;

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
    public function getWebsites()
    {
        return $this->websites;
    }

    /**
     * @param mixed $websites
     * @return $this
     */
    public function setWebsites($websites)
    {
        $this->websites = $websites;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param mixed $phone
     * @return $this
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
        return $this;
    }

    /**
     * @return Address
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param Address $address
     * @return $this
     */
    public function setAddress($address)
    {
        $this->address = $address;
        return $this;
    }
}