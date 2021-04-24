<?php
namespace Middlewares;

use Pecee\Http\Middleware\IMiddleware;
use Pecee\Http\Request;
use Controllers\AuthController;

class Auth implements IMiddleware{

    public function handle(Request $request): void 
    {
    	$auth = new AuthController;
        $user = $auth->authenticate();
        
        if($user['status'] == 0) {
             $auth->unauthorised();
        }

    }
}