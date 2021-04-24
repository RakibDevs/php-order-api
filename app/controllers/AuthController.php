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
		$data = input()->all();
		$user = $this->user->first($data['email'], $data['password']);
		$user['access_token'] = $this->user->generateToken($user);

		response()->json($user);
	}

	public function logout()
	{

		return json_encode(['msg' => 'Logged out successfullt']);
	}
	
}