<?php

/**
 * Created by PhpStorm.
 * Date: 02.05.2016
 * Time: 22:15
 */
class ErrorController extends BaseController
{
    /**
     * ErrorController constructor.
     * @param $options
     */
    function __construct($options)
    {
        parent::__construct($options);
    }

    public function errorRenderAction($type = Constants::ERROR_NOT_FOUND)
    {
        require_once './templates/error.php';
    }
}