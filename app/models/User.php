<?php
namespace App\Models;

use App\Contracts\AuthenticateUser;
use Config\DB;

class User
{
	protected $secret   = "*$%43MVKJTKMN$#";

	protected $db;

	use AuthenticateUser;

	public function __construct()
	{
		$this->db = (new DB)->connect();
	}
	
	public function first($email, $password)
	{
		$password = $this->hash($password);

		$query = "SELECT id,name,email,role,created_at,updated_at from users where email= ? and password= ? LIMIT 1";
		$stmt = $this->db->prepare($query);
		$stmt->execute([$email,$password]);

		return $stmt->fetch(\PDO::FETCH_ASSOC);
		

	}

	public function find($id)
	{

		$query = "SELECT id,name,email,role,created_at,updated_at from users where id= ? LIMIT 1";
		$stmt = $this->db->prepare($query);
		$stmt->execute([$id]);

		return $stmt->fetch(\PDO::FETCH_ASSOC);	

	}
	
}