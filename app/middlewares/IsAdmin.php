<?php
namespace App\Middlewares;

use Pecee\Http\Middleware\IMiddleware;
use Pecee\Http\Request;
use App\Models\User;

class IsAdmin implements IMiddleware 
{

    public function handle(Request $request): void 
    {
    	$auth = new User;
        $user = $auth->authenticate();

        if($auth->IsAdmin($user) {
             // return routes
        }else{
        	// unauthorised
        	
        }

    }
}