<?php
use Steampixel\Route;
use Controllers\AuthController;

$auth = new AuthController;


Route::add('/login', function() use ($auth) {
	return $auth->login();
}, 'post');

Route::run('/test/');
