<?php
namespace Controllers;

use Controllers\Controller;
use Traits\AuthenticateUser;
use Models\User;

class AuthController extends Controller
{

	public $secret   = "*$%43MVKJTKMN$#";

	use AuthenticateUser;

	public function login()
	{
		$user = (new User)->first($_POST['email'], $_POST['password']);
		$user['access_token'] = $this->generateToken($user['id']);

		return json_encode($user);
	}
	
}