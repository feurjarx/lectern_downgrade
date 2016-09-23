<?php
/**
 * Created by PhpStorm.
 * Date: 28.05.2016
 * Time: 22:20
 */

session_start();

require_once 'bootstrap.php';
require_once 'model/Constants.php';
require_once 'model/Utils.php';
require_once 'controllers/BaseController.php';

foreach (scandir(__DIR__ . '/controllers') as $f) {
    if  (!($f === '.' || $f === '..' || $f === 'BaseController.php')) {
        require_once __DIR__ . '/controllers/' . $f;
    }
}

foreach (scandir(__DIR__ . '/entity') as $f) {
    if  (!($f === '.' || $f === '..')) {
        require_once __DIR__ . '/entity/' . $f;
    }
}

foreach (scandir(__DIR__ . '/model') as $f) {
    if  (!($f === '.' || $f === '..')) {
        require_once __DIR__ . '/model/' . $f;
    }
}