<?php

/**
 * Created by PhpStorm.
 * Date: 02.05.2016
 * Time: 22:17
 */

use Entity\User;

class AuthController extends BaseController
{
    /**
     * AuthController constructor.
     * @param $options
     */
    function __construct($options)
    {
        parent::__construct($options);
    }

    /**
     * @param $request
     */
    public function signInAction($request)
    {
        $login = $request['login'];
        $password = $request['password'];

        if ($login && $password) {

            /** @var User $user */
            $user = $this->em->getRepository('Entity\User')->findOneBy(array(
                'email' => $login
            ));

            if ($user && $user->getPassword() === md5($password)) {

                $crypto = new Cryptograph();
                setcookie('uid', $crypto->encrypt($user->getId(), $_SERVER['HTTP_HOST']), time() + 24*3600);
                setcookie('vid', $crypto->getIvToBase64(), time() + 24*3600);

                $_SESSION['current_user_id'] = $user->getId();

                header('Location: ' . Utils::getHttpHost());
                exit();
            }
        }

        require_once __DIR__ . '/../templates/error.php';
    }

    /**
     * @param $request
     */
    public function logoutAction($request)
    {
        $flash = $request['flash'];

        if (isset($_SESSION['previos_flash'])) {

            if ($flash === $_SESSION['previos_flash']) {

                unset($_COOKIE['uid']);
                unset($_COOKIE['vid']);
                setcookie('uid', null, -1, '/');
                setcookie('vid', null, -1, '/');

                session_unset();

                header('Location: ' . Utils::getHttpHost());
                exit();
            }
        }

        require_once __DIR__ . '/../templates/error.php';
    }
}