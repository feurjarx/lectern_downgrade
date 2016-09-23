<?php
/**
 * Created by PhpStorm.
 * Date: 26.04.2016
 * Time: 23:04
 */

namespace Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @Entity @Table(name="request")
 **/
class Request
{
    /**
     * Request constructor.
     */
    function __construct()
    {
        $this->createdAt = time();
        $this->status = 'waiting';
    }

    /** @Id @Column(name="id", type="integer") @GeneratedValue **/
    private $id;

    /** @Column(name="status", type="string") **/
    private $status;

    /** @Column(name="created_at", type="integer") **/
    private $createdAt;

    /**
     * @var Cv
     * @ManyToOne(targetEntity="Cv")
     * @JoinColumn(name="cv_id", referencedColumnName="id")
     */
    private $cv;

    /**
     * @var Ad
     * @ManyToOne(targetEntity="Ad")
     * @JoinColumn(name="ad_id", referencedColumnName="id")
     */
    private $ad;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     * @return $this
     */
    public function setStatus($status)
    {
        $this->status = $status;
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
     * @return Cv
     */
    public function getCv()
    {
        return $this->cv;
    }

    /**
     * @param Cv|mixed $cv
     * @return $this
     */
    public function setCv($cv)
    {
        $this->cv = $cv;
        return $this;
    }

    /**
     * @return Ad
     */
    public function getAd()
    {
        return $this->ad;
    }

    /**
     * @param Ad|mixed $ad
     * @return $this
     */
    public function setAd($ad)
    {
        $this->ad = $ad;
        return $this;
    }
}