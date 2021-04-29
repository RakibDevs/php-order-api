<?php
namespace App\Contracts;

use Firebase\JWT\JWT;

trait AuthenticateUser
{

	protected $user;

	public function hash($password)
	{
		return md5($password);
	}

	public function isLoggedIn()
 	{
 		$this->authenticate();
 		return $this->user['status'] == 1;
 	}

 	public function isNotLoggedIn()
 	{
 		$this->authenticate();
 		return $this->user['status'] == 0;
 	}

 	public function isAdmin()
 	{
 		$this->authenticate();
 		return $this->user['role'] == 'admin';
 	}


 	public function isCustomer()
 	{
 		$this->authenticate();
 		return $this->user['role'] == 'customer';
 	}

 	public function getUserId()
 	{
 		$this->authenticate();
 		return $this->user['user_id'];
 	}

 	public function unAuthorised()
 	{
		http_response_code(200);
		response()->json($this->user);
 	}


	public function authenticate()
 	{ 
 		try {
 			$bearer = $this->getBearerToken();
 			if($bearer){
	 			$decoded = JWT::decode($bearer, $this->secret, array('HS256'));
	 			$payload = $this->formatPayload($decoded);
	 			$this->user = [
	 				'status'  => 1,
	 				'user_id' => $payload['user_id'],
	 				'role'    => $payload['role']
	 			];
 			}else{
	 			$this->user = [
	 				"status"     => 0, 
	 				"message"    => 'Invalid Token'
	 			];
 			}
 			return  $this->user;

 		}catch (\Exception $e) {
 			$this->user = [
 				"status"     => 0, 
 				"message"	 => $e->getMessage()
 			];
 			return  $this->user;
 		} 
 
 	}

 	public function generateToken($user)
	{
		try{

			$payload = $this->getPayload($user);
			return JWT::encode($payload, $this->secret,'HS256'); 

		}catch (UnexpectedValueException $e) {
			$res=array("status"=>false,"Error"=>$e->getMessage());
		}
		return $res;
	}

	public function getPayload($user)
	{
		return [
			'iss' 	  => $_SERVER['HTTP_HOST'],
			'exp'     => time()+600, 
			'user_id' => $user['id'],
			'role'    => $user['role']
		];
	}


	public function formatPayload($payload)
	{
		return json_decode(json_encode($payload),true);
	}

	public function getBearerToken()
 	{
 		$headers = $this->getAuthorizationHeader();
	    // HEADER: Get the access token from the header
	    if (!empty($headers)) {
	        if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {
	            return $matches[1];
	        }
	    }
	    return null;
 	}

 	public function getAuthorizationHeader()
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

 	
}