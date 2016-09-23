<?php
/**
 * Created by PhpStorm.
 * Date: 26.04.2016
 * Time: 23:04
 */

namespace Entity;

use Constants;
use Utils;

/**
 * @Entity @Table(name="user")
 **/
class User
{
    public function __construct()
    {
        $this->createdAt = time();
    }

    /** @Id @Column(name="id", type="integer") @GeneratedValue **/
    private $id;
    
    /** @Column(name="email", type="string") **/
    private $email;

    /** @Column(name="password", type="string") **/
    private $password = '';

    /** @Column(name="role", type="string") **/
    private $role;

    /** @Column(name="created_at", type="integer") **/
    private $createdAt;

    /** @Column(name="img_url", type="string") **/
    private $imgUrl;

    /** @Column(name="is_confirmed", type="boolean") **/
    private $isConfirmed;

    /**
     * @OneToOne(targetEntity="Person", mappedBy="user")
     */
    private $person;

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
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     * @return $this
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     * @return $this
     */
    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @param $role
     * @return $this
     */
    public function setRole($role)
    {
        $this->role = $role;
        return $this;
    }

    /**
     * @return int
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param int $createdAt
     * @return $this
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getImgUrl()
    {
        return Utils::getHttpHost() . ( $this->imgUrl ? (Constants::UPLOAD_PHOTOS_URL . $this->imgUrl) : Constants::DEFAULT_PHOTO_URL);
    }

    /**
     * @param mixed $imgUrl
     * @return $this
     */
    public function setimgUrl($imgUrl)
    {
        $this->imgUrl = $imgUrl;
        return $this;
    }

    /**
     * @return bool
     */
    public function getIsConfirmed()
    {
        return $this->isConfirmed;
    }

    /**
     * @param bool $isConfirmed
     * @return $this
     */
    public function setIsConfirmed($isConfirmed)
    {
        $this->isConfirmed = $isConfirmed;
        return $this;
    }

    /**
     * @return Person
     */
    public function getPerson()
    {
        return $this->person;
    }
}