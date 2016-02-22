<?php

$routes->get('/hello', function() {
	HelloWorldController::hello();
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
$routes->post('/task/:id', function($id){
	TaskController::update($id);
});
$routes->post('/task/:id/destroy', function($id){
	TaskController::destroy($id);
});
$routes->get('/task/:id/edit', function($id){
	TaskController::edit($id);
});
$routes->get('/task/:id/markasdone', function($id){
	TaskController::markasdone($id);
});
$routes->get('/task/:id/markasundone', function($id){
	TaskController::markasundone($id);
});
$routes->post('/login', function(){
	SessionController::store();
});
$routes->get('/login', function(){
	SessionController::create();
});
$routes->post('/logout', function(){
	SessionController::destroy();
});
$routes->get('/signup', function(){
	UserController::create();
});
$routes->post('/signup', function(){
	UserController::store();
});