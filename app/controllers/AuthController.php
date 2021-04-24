<?php
namespace App\Controllers;

use App\Controllers\Controller;
use Pecee\Http\Request;
use App\Models\User;

class AuthController extends Controller
{

	protected $user;

	public function __construct()
	{
		$this->user = new User;
	}

	public function login()
	{
		$user = $this->user->first($_POST['email'], $_POST['password']);
		$user['access_token'] = $this->user->generateToken($user);

		return json_encode($user);
	}
	
}