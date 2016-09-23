<?php
/**
 * Created by PhpStorm.
 * Date: 26.04.2016
 * Time: 23:04
 */

namespace Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @Entity @Table(name="cv")
 **/
class Cv
{
    /**
     * Cv constructor.
     */
    public function __construct()
    {
        $this->createdAt = time();
    }

    /** @Id @Column(name="id", type="integer") @GeneratedValue **/
    private $id;

    /** @Column(name="sphere", type="string") **/
    private $sphere;

    /** @Column(name="access_type", type="string") **/
    private $accessType;

    /** @Column(name="hobbies", type="string") **/
    private $hobbies;

    /** @Column(name="created_at", type="integer") **/
    private $createdAt;

    /**
     * @ManyToOne(targetEntity="Person", inversedBy="cvs")
     * @JoinColumn(name="person_id", referencedColumnName="id")
     */
    private $person;

    /** @Column(name="skills", type="string") **/
    private $skills;

    /** @Column(name="work_experience", type="string") **/
    private $workExperience;

    /** @Column(name="education", type="string") **/
    private $education;

    /** @Column(name="ext_education", type="string") **/
    private $extEducation;

    /** @Column(name="desire_salary", type="integer") **/
    private $desireSalary;

    /** @Column(name="schedule", type="string") **/
    private $schedule;

    /** @Column(name="foreign_languages", type="string") **/
    private $foreignLanguages;

    /** @Column(name="is_drivers_license", type="boolean") **/
    private $isDriversLicense;

    /** @Column(name="is_smoking", type="boolean") **/
    private $isSmoking;

    /** @Column(name="is_married", type="boolean") **/
    private $isMarried;

    /** @Column(name="about", type="string") **/
    private $about;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getAccessType()
    {
        return $this->accessType;
    }

    /**
     * @param $accessType
     * @return $this
     */
    public function setAccessType($accessType)
    {
        $this->accessType = $accessType;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getHobbies()
    {
        return $this->hobbies;
    }

    /**
     * @param mixed $hobbies
     * @return $this
     */
    public function setHobbies($hobbies)
    {
        $this->hobbies = $hobbies;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param mixed $createdAt
     * @return $this
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
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
    public function getSkills()
    {
        return $this->skills;
    }

    /**
     * @param mixed $skills
     * @return $this
     */
    public function setSkills($skills)
    {
        $this->skills = $skills;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getWorkExperience()
    {
        return $this->workExperience;
    }

    /**
     * @param mixed $workExperience
     * @return $this
     */
    public function setWorkExperience($workExperience)
    {
        $this->workExperience = $workExperience;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEducation()
    {
        return $this->education;
    }

    /**
     * @param mixed $education
     * @return $this
     */
    public function setEducation($education)
    {
        $this->education = $education;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getExtEducation()
    {
        return $this->extEducation;
    }

    /**
     * @param mixed $extEducation
     * @return $this
     */
    public function setExtEducation($extEducation)
    {
        $this->extEducation = $extEducation;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDesireSalary()
    {
        return $this->desireSalary;
    }

    /**
     * @param mixed $desireSalary
     * @return $this
     */
    public function setDesireSalary($desireSalary)
    {
        $this->desireSalary = $desireSalary;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSchedule()
    {
        return $this->schedule;
    }

    /**
     * @param mixed $schedule
     * @return $this
     */
    public function setSchedule($schedule)
    {
        $this->schedule = $schedule;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getForeignLanguages()
    {
        return $this->foreignLanguages;
    }

    /**
     * @param mixed $foreignLanguages
     * @return $this
     */
    public function setForeignLanguages($foreignLanguages)
    {
        $this->foreignLanguages = $foreignLanguages;
        return $this;
    }

    /**
     * @return bool
     */
    public function getIsDriversLicense()
    {
        return $this->isDriversLicense;
    }

    /**
     * @param bool $isDriversLicense
     * @return $this
     */
    public function setIsDriversLicense($isDriversLicense)
    {
        $this->isDriversLicense = $isDriversLicense;
        return $this;
    }

    /**
     * @return bool
     */
    public function getIsSmoking()
    {
        return $this->isSmoking;
    }

    /**
     * @param bool $isSmoking
     * @return $this
     */
    public function setIsSmoking($isSmoking)
    {
        $this->isSmoking = $isSmoking;
        return $this;
    }

    /**
     * @return bool
     */
    public function getIsMarried()
    {
        return $this->isMarried;
    }

    /**
     * @param bool $isMarried
     * @return $this
     */
    public function setIsMarried($isMarried)
    {
        $this->isMarried = $isMarried;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAbout()
    {
        return $this->about;
    }

    /**
     * @param mixed $about
     * @return $this
     */
    public function setAbout($about)
    {
        $this->about = $about;
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
     * @param $sphere
     * @return $this
     */
    public function setSphere($sphere)
    {
        $this->sphere = $sphere;
        return $this;
    }
}