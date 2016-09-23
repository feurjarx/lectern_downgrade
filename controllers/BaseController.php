<?php
/**
 * Created by PhpStorm.
 * Date: 02.05.2016
 * Time: 21:34
 */

use Doctrine\ORM\EntityManager;
use Entity\User;

class BaseController
{
    /** @var string */
    protected $route;

    /** @var  string */
    private $role;

    /** @var bool  */
    protected $isFlash = true;

    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @return mixed
     */
    protected $conf;

    /**
     * @var User
     */
    protected $currentUser = null;

    /**
     * @var string
     */
    protected $flash;

    /**
     * BaseController constructor.
     * @param $options
     */
    function __construct($options) {

        $this->em = $options['em'];
        $this->conf = $options['conf'];
        $this->route = $options['route'];

        isset($options['is_flash']) && $this->isFlash = $options['is_flash'];
        Utils::isAjax() && $this->isFlash = false;

        $this->initCurrentUser($_COOKIE);

        $this->role = $this->currentUser ? $this->currentUser->getRole() : null;

        if (isset($options['is_verify']) && $options['is_verify'] && is_null($this->currentUser)) {
            header('Location: ' . Utils::getHttpHost() . '/' . 'access/denied');
            exit();
        }
    }

    function __destruct() {
        $this->isFlash && $_SESSION['previos_flash'] = isset($_SESSION['flash']) ? $_SESSION['flash'] : null;
    }
    
    /**
     * @return User
     */
    public function getCurrentUser()
    {
        return $this->currentUser;
    }

    /**
     * @param $cookie
     * @return $this
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function initCurrentUser($cookie)
    {
        //session_start();

        if (isset($_SESSION['current_user_id']) && $_SESSION['current_user_id']) {

            $this->currentUser = $this->em->getRepository('Entity\User')->find($_SESSION['current_user_id']);

            if (!$this->currentUser) {

                unset($_COOKIE['uid']);
                unset($_COOKIE['vid']);
                setcookie('uid', null, -1, '/');
                setcookie('vid', null, -1, '/');

                session_unset();
            }

        } else {

            if (isset($cookie['uid']) && $cookie['uid'] && isset($cookie['vid']) && $cookie['vid']) {

                $crypto = new Cryptograph($cookie['vid']);

                $currentUserId = $crypto->decrypt($cookie['uid'], $_SERVER['HTTP_HOST']);

                if ($currentUserId && is_string($currentUserId)) {

                    $currentUserId = (int)$currentUserId;

                    $qb = $this->em->createQueryBuilder();

                    $qb
                        ->select('u')
                        ->from('Entity\User', 'u')
                        ->where($qb->expr()->eq('u', $currentUserId))
                    ;

                    $this->currentUser = $qb->getQuery()->getOneOrNullResult();

                    if ($this->currentUser) {
                        $_SESSION['current_user_id'] = $currentUserId;
                    }

                } else {

                    $this->currentUser = null;
                }

            } else {

                $this->currentUser = null;
            }
        }

        $this->isFlash && $_SESSION['flash'] = $this->flash = $this->currentUser  ? md5(time() . $this->currentUser->getEmail()) : null;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getConf()
    {
        return $this->conf;
    }

    /**
     * @param $conf
     * @return $this
     */
    public function setConf($conf)
    {
        $this->conf = $conf;
        return $this;
    }

    /**
     * @return string
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @return string
     */
    public function getRoute()
    {
        return $this->route;
    }
}