<?php

$routes->get('/hello', function() {
	HelloWorldController::index();
});

$routes->get('/hiekkalaatikko', function() {
	HelloWorldController::sandbox();
});
  // Etusivu (pelien listaussivu)
$routes->get('/', function(){
	TaskController::index();
});
// Pelien listaussivu
$routes->get('/task', function(){
	TaskController::index();
});
$routes->post('/task', function(){
	TaskController::store();
});
// Pelin lisäyslomakkeen näyttäminen
$routes->get('/task/new', function(){
	TaskController::create();
});
// Pelin esittelysivu
$routes->get('/task/:id', function($id){
	TaskController::show($id);
});
