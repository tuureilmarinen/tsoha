<?php

$routes->get('/hello', function() {
	HelloWorldController::index();
});

$routes->get('/hiekkalaatikko', function() {
	HelloWorldController::sandbox();
});
$routes->get('/', function(){
	TaskController::index();
});
$routes->get('/task', function(){
	TaskController::index();
});
$routes->post('/task', function(){
	TaskController::store();
});
$routes->get('/task/new', function(){
	TaskController::create();
});
$routes->get('/task/:id', function($id){
	TaskController::show($id);
});
$routes->post('/task/:id/destroy', function($id){
	TaskController::destroy($id);
});
