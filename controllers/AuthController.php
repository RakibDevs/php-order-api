<?php
namespace Controllers;

use Controllers\Controller;
use Firebase\JWT\JWT;
use Models\User;

class AuthController extends Controller
{
	private $secret   = "*$%43MVKJTKMN$#";




	public function login()
	{
		$user = $this->getUser($_POST);
		$user['access_token'] = $this->generateToken($user['id']);

		var_dump($user);
	}

	public function getUser($data)
	{
		$email    = $data['email'];
		$password = $data['password'];

		return (new User)->first($email, $password);
	}

	

	public function generateToken($uid)
	{
		try{
			$jwt = JWT::encode($this->getPayload($uid), $this->secret,'HS256'); 
			$res = array("status"=>true,"Token"=>$jwt);
		}catch (UnexpectedValueException $e) {
			$res=array("status"=>false,"Error"=>$e->getMessage());
		}
		return $res;
	}

	public function getPayload($uid)
	{
		return [
			'iss' => $_SERVER['HTTP_HOST'],
			'exp' => time()+600, 
			'uId' => $uid
		];
	}

	public function authenticate($jwt,$user_id)
 	{ 
 		try {
 			$decoded = JWT::decode($jwt,$this->secret, array('HS256'));
 			$payload = json_decode(json_encode($decoded),true);
 
 			if($payload['uId'] == $user_id) {
 				$res=array("status"=>true);
 			}else{
 				$res=array(
 					"status"=>false,
 					"Error"=>"Invalid Token or Token Exipred, So Please login Again!");
 			}
 		}catch (UnexpectedValueException $e) {
 			$res=array("status"=>false,"Error"=>$e->getMessage());
 		} 
 		return $res;
 
 	}
}