<?php
// App/Routes/Web.php
use App\Core\Router;

$router = new Router();

// Authen
$router->get('/auth/login', 'AuthenController@Login');
$router->post('/auth/login', 'AuthenController@Login');
$router->get('/auth/register', 'AuthenController@Register');
$router->get('/auth/logout', 'AuthenController@Logout');


// User
$router->get('/', 'DashboardController@Index');
$router->get('/dashboard', 'DashboardController@Index');
$router->get('/user', 'UserController@Index');
$router->get('/user/page/{page}', 'UserController@Index');

$router->get('/user/create', 'UserController@Create');
$router->post('/user/create', 'UserController@Create');

$router->get('/user/edit/{id}', 'UserController@Edit');
$router->post('/user/edit/{id}', 'UserController@Edit');

$router->delete('/user/delete/{id}', 'UserController@Delete');


// Role
$router->get('/role', 'RoleController@Index');
$router->get('/role/page/{page}', 'RoleController@Index');

$router->get('/role/create', 'RoleController@Create');
$router->post('/role/create', 'RoleController@Create');

$router->get('/role/edit/{id}', 'RoleController@Edit');
$router->post('/role/edit/{id}', 'RoleController@Edit');

$router->delete('/role/delete/{id}', 'RoleController@Delete');



$router->run();