<?php
namespace Traits;

use Firebase\JWT\JWT;
use Models\User;

trait AuthenticateUser
{
	public function authenticate($bearer)
 	{ 
 		try {

 			$decoded = JWT::decode($bearer, $this->secret, array('HS256'));
 			$payload = json_decode(json_encode($decoded),true);

 			$user    = (new User)->find($payload['user_id']);
 
 			if($payload['user_id'] == $user_id) {
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

 	public function generateToken($uid)
	{
		try{
			return JWT::encode($this->getPayload($uid), $this->secret,'HS256'); 

		}catch (UnexpectedValueException $e) {
			$res=array("status"=>false,"Error"=>$e->getMessage());
		}
		return $res;
	}

	public function getPayload($uid)
	{
		return [
			'iss' 	  => $_SERVER['HTTP_HOST'],
			'exp'     => time()+600, 
			'user_id' => $uid
		];
	}

 	function getAuthorizationHeader()
 	{
        $headers = null;
        if (isset($_SERVER['Authorization'])) {
            $headers = trim($_SERVER["Authorization"]);
        }
        else if (isset($_SERVER['HTTP_AUTHORIZATION'])) { 
        	//Nginx or fast CGI
            $headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
        } elseif (function_exists('apache_request_headers')) {
            $requestHeaders = apache_request_headers();
            // Server-side fix for bug in old Android versions
            $requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
            if (isset($requestHeaders['Authorization'])) {
                $headers = trim($requestHeaders['Authorization']);
            }
        }
        return $headers;
    }

 	public function getBearerToken()
 	{
 		$headers = getAuthorizationHeader();
	    // HEADER: Get the access token from the header
	    if (!empty($headers)) {
	        if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {
	            return $matches[1];
	        }
	    }
	    return null;
 	}
}