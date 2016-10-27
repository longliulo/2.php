<?php

$router = new Phalcon\Mvc\Router();

/*removeExtraSlashes dùng để bỏ dấu '/' sau cùng của link*/
$router->removeExtraSlashes(true);

$router->add('/:controller/:action/:params', array(
    'namespace' => 'MyApp\Controllers',
    'controller' => 1,
    'action' => 2,
    'params' => 3,
));
// set home page
$router->add('/', array(
    'namespace' => 'MyApp\Controllers',
    'controller' => 'home'
));

$router->add('/:controller', array(
    'namespace' => 'MyApp\Controllers',
    'controller' => 1,
    'action' => 'index'
));

$router->add('/admin/:controller/:action/:params', array(
    'namespace' => 'MyApp\Controllers\Admin',
    'controller' => 1,
    'action' => 2,
    'params' => 3,
));

$router->add('/admin/:controller', array(
    'namespace' => 'MyApp\Controllers\Admin',
    'controller' => 1,
    'action' => 'index'
));

$router->add('/admin', array(
    'namespace' => 'MyApp\Controllers\Admin',
    'controller' => 'managelogin',
    'action' => 'index'
));
$router->add('/admin/login', array(
    'namespace' => 'MyApp\Controllers\Admin',
    'controller' => 'managelogin',
    'action' => 'index'
));
$router->add('/admin/logout', array(
    'namespace' => 'MyApp\Controllers\Admin',
    'controller' => 'managelogin',
    'action' => 'logout'
));


// USER/...
$router->add('/user/:controller/:action/:params', array(
    'namespace' => 'MyApp\Controllers\User',
    'controller' => 1,
    'action' => 2,
    'params' => 3,
));

$router->add('/user/:controller', array(
    'namespace' => 'MyApp\Controllers\User',
    'controller' => 1,
    'action' => 'index'
));

$router->add('/logout', array(
    'namespace' => 'MyApp\Controllers',
    'controller' => 'login',
    'action' => 'logout'
));
// end USER/...