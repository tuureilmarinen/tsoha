<?php
$routes->get('/', function(){
	TaskController::index();
});
$routes->get('/task/', function(){
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
$routes->get('/logout', function(){
	SessionController::destroy();
});
$routes->get('/signup', function(){
	UserController::create();
});
$routes->post('/signup', function(){
	UserController::store();
});
$routes->get('/user', function(){
	UserController::index();
});
$routes->get('/user/:id', function($id){
	UserController::show($id);
});
$routes->get('/user/:id/destroy', function($id){
	UserController::destroy($id);
});
$routes->get('/group', function(){
	GroupController::index();
});
$routes->post('/group', function(){
	GroupController::store();
});
$routes->get('/group/new', function(){
	GroupController::create();
});
$routes->get('/group/:id', function($id){
	GroupController::show($id);
});
$routes->post('/group/:id/destroy', function($id){
	GroupController::destroy($id);
});
$routes->get('/group/:id/destroy', function($id){
	GroupController::destroy($id);
});