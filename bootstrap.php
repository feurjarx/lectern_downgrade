<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 26.04.2016
 * Time: 22:46
 */
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

require_once "vendor/autoload.php";

// Create a simple "default" Doctrine ORM configuration for Annotations
$isDevMode = true;
$config = Setup::createAnnotationMetadataConfiguration(array(__DIR__."/src"), $isDevMode);

$config->setProxyDir('./models/Proxies');
$config->setProxyNamespace('Proxies');


// database configuration parameters
$options = array(
    'driver'   => 'pdo_mysql',
    'host'     => 'mysql.db.astu',
    'dbname'   => '14190182',
    'user'     => '14190182',
    'password' => 'sim64'
);

$em = EntityManager::create($options, $config);