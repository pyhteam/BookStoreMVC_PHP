<?php
// App/Routes/Web.php
use App\Core\Router;

$router = new Router();
$router->get('/', 'DashboardController@Index');
$router->get('/user', 'UserController@Index');
$router->get('/user/page/{page}', 'UserController@Index');
$router->get('/user/detail/{id}/{slug}', 'UserController@Detail');

$router->get('/user/create', 'UserController@Create');
$router->post('/user/create', 'UserController@Create');


$router->run();