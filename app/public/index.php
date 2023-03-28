<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: *");

error_reporting(E_ALL);
ini_set("display_errors", 1);

require __DIR__ . '/../vendor/autoload.php';

// Create Router instance
$router = new \Bramus\Router\Router();

$router->setNamespace('Controllers');

//routes for the lawyers endpoint
$router->get('/lawyers', 'LawyerController@getAll');
$router->get('/lawyers/(\d+)', 'LawyerController@getOne');
$router->post('/lawyers', 'LawyerController@create');

//lawareas endpoint
$router->get('/lawareas', 'LawyerController@getLawAreas');

//routes for the appointments endpoint
$router->get('/appointments', 'AppointmentController@getAll');
$router->get('/appointments/(\d+)', 'AppointmentController@getOne');
$router->post('/appointments', 'AppointmentController@create');
$router->put('/appointments/(\d+)', 'AppointmentController@update');
$router->delete('/appointments/(\d+)', 'AppointmentController@delete');

// routes for the users endpoint
$router->post('/users/login', 'UserController@login');
$router->post('/users', 'UserController@create');

// Run it!
$router->run();