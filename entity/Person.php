<?php
/**
 * Created by PhpStorm.
 * Date: 26.04.2016
 * Time: 23:04
 */

namespace Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;

use Entity\Contact;
use Entity\Cv;

/**
 * @Entity @Table(name="person")
 **/
class Person
{
    /** @Id @Column(name="id", type="integer") @GeneratedValue **/
    private $id;

    /** @Column(name="gender", type="string") **/
    private $gender;

    /** @Column(name="organisation", type="string") **/
    private $organisation;

    /**
     * @OneToOne(targetEntity="User")
     * @JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @OneToOne(targetEntity="Contact")
     * @JoinColumn(name="contact_id", referencedColumnName="id")
     */
    private $contact;

    /** @Column(name="last_name", type="string") **/
    private $lastName;

    /** @Column(name="first_name", type="string") **/
    private $firstName;

    /** @Column(name="father_name", type="string") **/
    private $fatherName;

    /** @Column(name="date_birth", type="datetime") **/
    private $dateBirth;

    /**
     * @OneToMany(targetEntity="Ad", mappedBy="person")
     */
    private $ads;

    /**
     * @OneToMany(targetEntity="Cv", mappedBy="person")
     */
    private $cvs;

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
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * @param mixed $gender
     * @return $this
     */
    public function setGender($gender)
    {
        $this->gender = $gender;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getOrganisation()
    {
        return $this->organisation;
    }

    /**
     * @param mixed $organisation
     * @return $this
     */
    public function setOrganisation($organisation)
    {
        $this->organisation = $organisation;
        return $this;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     * @return $this
     */
    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return Contact
     */
    public function getContact()
    {
        return $this->contact;
    }

    /**
     * @param Contact $contact
     * @return $this
     */
    public function setContact($contact)
    {
        $this->contact = $contact;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param mixed $lastName
     * @return $this
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param mixed $firstName
     * @return $this
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFatherName()
    {
        return $this->fatherName;
    }

    /**
     * @param mixed $fatherName
     * @return $this
     */
    public function setFatherName($fatherName)
    {
        $this->fatherName = $fatherName;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDateBirth()
    {
        return $this->dateBirth;
    }

    /**
     * @param \DateTime $dateBirth
     * @return $this
     */
    public function setDateBirth($dateBirth)
    {
        $this->dateBirth = $dateBirth;
        return $this;
    }

    /**
     * @return PersistentCollection
     */
    public function getAds()
    {
        return $this->ads;
    }

    /**
     * @param array|mixed $ads
     * @return $this
     */
    public function setAds($ads)
    {
        $this->ads = $ads;
        return $this;
    }

    /**
     * @return PersistentCollection
     */
    public function getCvs()
    {
        return $this->cvs;
    }

    /**
     * @param array|mixed $cvs
     * @return $this
     */
    public function setCvs($cvs)
    {
        $this->cvs = $cvs;
        return $this;
    }

    /**
     * @return string
     */
    public function getFullName()
    {
        return ($this->lastName ? ($this->lastName . ' ') : '') . $this->firstName;
    }
}