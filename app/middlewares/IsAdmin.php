<?php
namespace App\Middlewares;

use Pecee\Http\Middleware\IMiddleware;
use Pecee\Http\Request;
use App\Models\User;

class IsAdmin implements IMiddleware 
{
    protected $user;

    public function __construct()
    {
        $this->user = new User;
    }

    public function handle(Request $request): void 
    {

        if(!($this->user->isAdmin())) {
            toApi(401,'error','Unauthorised Access');
        }

    }
}