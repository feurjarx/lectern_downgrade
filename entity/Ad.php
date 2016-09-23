<?php
/**
 * Created by PhpStorm.
 * Date: 26.04.2016
 * Time: 23:04
 */

namespace Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @Entity @Table(name="ad")
 **/
class Ad
{
    /**
     * Ad constructor.
     */
    public function __construct()
    {
        $this->publishedAt = time();
    }
    /** @Id @Column(name="id", type="integer") @GeneratedValue **/
    private $id;

    /** @Column(name="name", type="string") **/
    private $name;

    /** @Column(name="published_at", type="integer") **/
    private $publishedAt;

    /** @Column(name="salary", type="integer") **/
    private $salary;

    /** @Column(name="details", type="string") **/
    private $details;
    
    /**
     * @ManyToOne(targetEntity="Person", inversedBy="ads")
     * @JoinColumn(name="person_id", referencedColumnName="id")
     */
    private $person;

    /** @Column(name="sphere", type="string") **/
    private $sphere;

    /** @Column(name="is_confirmed", type="integer") **/
    private $isConfirmed = 0;

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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPublishedAt()
    {
        return $this->publishedAt;
    }

    /**
     * @param mixed $publishedAt
     * @return $this
     */
    public function setPublishedAt($publishedAt)
    {
        $this->publishedAt = $publishedAt;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSalary()
    {
        return $this->salary;
    }

    /**
     * @param mixed $salary
     * @return $this
     */
    public function setSalary($salary)
    {
        $this->salary = $salary;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDetails()
    {
        return $this->details;
    }

    /**
     * @param mixed $details
     * @return $this
     */
    public function setDetails($details)
    {
        $this->details = $details;
        return $this;
    }

    /**
     * @return Person
     */
    public function getPerson()
    {
        return $this->person;
    }

    /**
     * @param $person
     * @return $this
     */
    public function setPerson($person)
    {
        $this->person = $person;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSphere()
    {
        return $this->sphere;
    }

    /**
     * @param mixed $sphere
     * @return $this
     */
    public function setSphere($sphere)
    {
        $this->sphere = $sphere;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getIsConfirmed()
    {
        return $this->isConfirmed;
    }

    /**
     * @param mixed $isConfirmed
     * @return $this
     */
    public function setIsConfirmed($isConfirmed)
    {
        $this->isConfirmed = $isConfirmed;
        return $this;
    }
}