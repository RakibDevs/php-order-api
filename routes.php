<?php
use Pecee\SimpleRouter\SimpleRouter;
use App\MiddleWares\Auth;

SimpleRouter::group(['prefix' => 'test'], function(){

	SimpleRouter::post('/login', [AuthController::class, 'login']);
	SimpleRouter::get('/products', [ProductsController::class, 'index']);

	SimpleRouter::group(['middleware' => Auth::class], function() {

		SimpleRouter::post('/products/store', [ProductsController::class, 'store']);
		SimpleRouter::get('/products/{id}', [ProductsController::class, 'show']);
		SimpleRouter::post('/products/{id}/update', [ProductsController::class, 'update']);
		SimpleRouter::get('/products/{id}/delete', [ProductsController::class, 'delete']);
	});
});


SimpleRouter::setDefaultNamespace('\App\Controllers');
SimpleRouter::start();


