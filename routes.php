<?php
use Pecee\SimpleRouter\SimpleRouter;
use Pecee\Http\Request;
use Pecee\SimpleRouter\Exceptions\NotFoundHttpException;
use App\MiddleWares\Auth;
use App\MiddleWares\IsAdmin;
use App\MiddleWares\IsCustomer;

// if runing in localhost add prefix, otherwise ignore 
SimpleRouter::group(['prefix' => 'test'], function(){

	SimpleRouter::post('/register', [AuthController::class, 'register']);
	SimpleRouter::post('/login', [AuthController::class, 'login']);
	SimpleRouter::get('/products', [ProductsController::class, 'index']);
	SimpleRouter::get('/categories', [ProductsController::class, 'categories']);
	SimpleRouter::get('/products/{id}', [ProductsController::class, 'show']);

	// Auth
	SimpleRouter::group(['middleware' => Auth::class], function() {
		// Admin Routes
		SimpleRouter::group(['middleware' => IsAdmin::class], function() {
			SimpleRouter::post('/products/store', [ProductsController::class, 'store']);
			SimpleRouter::post('/products/{id}/update', [ProductsController::class, 'update']);
			SimpleRouter::delete('/products/{id}', [ProductsController::class, 'delete']);

			SimpleRouter::get('/orders/', [OrderController::class, 'orders']);
			SimpleRouter::post('/orders/{id}/update', [OrderController::class, 'update']);

		});
		// Customer Routs
		SimpleRouter::group(['middleware' => IsCustomer::class], function() {
			SimpleRouter::post('/orders/store', [OrderController::class, 'store']);
			SimpleRouter::post('/myorders', [OrderController::class, 'myOrders']);
			
		});

		SimpleRouter::get('/orders/{id}', [OrderController::class, 'show']);
		//SimpleRouter::delete('/orders/{id}', [OrderController::class, 'delete']);

		SimpleRouter::get('/logout', [AuthController::class, 'logout']);
	});
});

// Exception handle, If route not found
SimpleRouter::error(function(Request $request, \Exception $exception) {

    if($exception instanceof NotFoundHttpException) {
        toApi(404,'error','404! Not found!');
    }
    
});

SimpleRouter::enableMultiRouteRendering(false);
//set default namespace for cntrollers
SimpleRouter::setDefaultNamespace('\App\Controllers');
// initiate simple router
SimpleRouter::start();


