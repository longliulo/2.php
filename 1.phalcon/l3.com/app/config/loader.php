<?php
defined('APP_PATH') || define('APP_PATH', realpath('.'));
$loader = new \Phalcon\Loader();

/**
 * We're a registering a set of directories taken from the configuration file
 */
$loader->registerDirs(
    array(
        $config->application->controllersDir,
        $config->application->modelsDir
    )
);
$loader->registerClasses(
    array(
        "Link"         => APP_PATH . "/app/library/Link.php",
        "UploadFile"   => APP_PATH . "/app/library/UploadFile.php",
    )
);
$loader->registerNamespaces(array(
	'MyApp\Controllers' => __DIR__ . '/../controllers/',
	'MyApp\Model' => __DIR__ . '/../models/',
	'MyApp\Forms' => __DIR__ . '/../forms/',
	'MyApp' => __DIR__ . '/../library/',
	
));
$loader->register();