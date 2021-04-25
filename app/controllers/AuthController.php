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
		if($user){
			$user['access_token'] = $this->user->generateToken($user);
			
			toApi(200,'success','Logged in succesfuly', $user);
		}else{
			toApi(200,'error','Invalid email or password');
		}
	}

	public function register()
	{
		$data = input()->all();
		$this->passwordMatch($data);
		$user = $this->user->insert($data);
		if($user){
			$user['access_token'] = $this->user->generateToken($user);
			
			toApi(200,'success','Logged in succesfuly', $user);
		}else{
			toApi(200,'error','Invalid email or password');
		}
	}

	public function logout()
	{

		return json_encode(['msg' => 'Logged out successfullt']);
	}

	protected function passwordMatch($data)
	{
		if($data['password'] !== $data['password_confirmation']){
			toApi('200','error',"The password confirmation doesn't match");
		}
	}
	
}