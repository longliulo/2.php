<?php

error_reporting(E_ALL);

define('APP_PATH', realpath('..'));
//date_default_timezone_set('Asia/Bangkok');
date_default_timezone_set('Asia/Singapore');


require_once 'define_function.php';
require_once 'define_value.php';
include_once 'class.dosdetector.php';
$myDosDetector = new DosDetector();
//Default Running
$myDosDetector->run();

define('DIR_POST', "files/posts/");
define('DOMAIN_NAME', "l3.com");



try {

    /**
     * Read the configuration
     */
    $config = include APP_PATH . "/app/config/config.php";

    /**
     * Read auto-loader
     */
    include APP_PATH . "/app/config/loader.php";

    /**
     * Read services
     */
    include APP_PATH . "/app/config/services.php";

    /**
     * Handle the request
     */
    $application = new \Phalcon\Mvc\Application($di);

    echo $application->handle()->getContent();

} catch (\Exception $e) {
    echo $e->getMessage();
}
