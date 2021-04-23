<?php
namespace Models;

use Config\DB;

class User 
{
	protected $db;

	public function __construct()
	{
		$this->db = (new DB)->connect();
	}
	
	public function first($email, $password)
	{
		$password = self::hash($password);

		$query = "SELECT * from users where email= ? and password= ? LIMIT 1";
		$stmt = $this->db->prepare($query);
		$stmt->execute([$email,$password]);

		return $stmt->fetch();
		

	}

	public function hash($password)
	{
		return md5($password);
	}
}