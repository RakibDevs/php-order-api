<?php
use Steampixel\Route;
use Controllers\AuthController;


Route::add('/', function() {
	return AuthController::index();
});

Route::run('/test/');
