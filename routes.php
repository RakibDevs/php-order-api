<?php
use Pecee\SimpleRouter\SimpleRouter;
use Pecee\Http\Request;
use Pecee\SimpleRouter\Exceptions\NotFoundHttpException;
use App\MiddleWares\Auth;
use App\MiddleWares\IsAdmin;
use App\MiddleWares\IsCustomer;

SimpleRouter::group(['prefix' => 'test'], function(){

	SimpleRouter::post('/register', [AuthController::class, 'register']);
	SimpleRouter::post('/login', [AuthController::class, 'login']);
	SimpleRouter::get('/products', [ProductsController::class, 'index']);
	SimpleRouter::get('/products/{id}', [ProductsController::class, 'show']);

	SimpleRouter::group(['middleware' => Auth::class], function() {

		SimpleRouter::group(['middleware' => IsAdmin::class], function() {
			SimpleRouter::post('/products/store', [ProductsController::class, 'store']);
			SimpleRouter::post('/products/{id}/update', [ProductsController::class, 'update']);
			SimpleRouter::get('/products/{id}/delete', [ProductsController::class, 'delete']);

		});
		SimpleRouter::group(['middleware' => IsCustomer::class], function() {
			SimpleRouter::post('/orders/store', [OrderController::class, 'store']);
			
		});

		SimpleRouter::get('/orders/', [OrderController::class, 'delete']);
		SimpleRouter::post('/orders/{id}/update', [OrderController::class, 'update']);
		SimpleRouter::get('/orders/{id}/delete', [OrderController::class, 'delete']);

		SimpleRouter::get('/logout', [AuthController::class, 'logout']);
	});
});


SimpleRouter::error(function(Request $request, \Exception $exception) {

    if($exception instanceof NotFoundHttpException) {
        toApi(404,'error','404! Not found!');
    }
    
});

SimpleRouter::enableMultiRouteRendering(false);
SimpleRouter::setDefaultNamespace('\App\Controllers');
SimpleRouter::start();


