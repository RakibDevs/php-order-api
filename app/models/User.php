<?php
namespace App\Models;

use App\Models\Model;
use App\Contracts\AuthenticateUser;



class User extends Model
{
	protected $secret   = "*$%43MVKJTKMN$#";

	use AuthenticateUser;

	protected $table = 'users';
	
	public function first($email, $password)
	{
		$password = $this->hash($password);

		$query = "SELECT id,name,email,role,created_at,updated_at from users where email= ? and password= ? LIMIT 1";
		$stmt = $this->db->prepare($query);
		$stmt->execute([$email,$password]);

		return $stmt->fetch(\PDO::FETCH_ASSOC);
		

	}

	public function insert($data)
	{
		try {
			$name     = $data['name'];
			$email 	  = $data['email'];
			$password = $this->hash($data['password']);

			$query = "INSERT INTO users (name, email, password) VALUES (?, ?, ?)";
			$stmt = $this->db->prepare($query);
			$stmt->execute([$name, $email,$password]);
			$stmt = null;
			toApi(200,'success', 'Registered succesfully');
		}catch(\Exception $e){
			if($e->errorInfo[1] == 1062){
				toApi(200,'error', 'This email has been used already');
			}
			$this->exception();
		}
		
	}

	public function find($id)
	{

		$query = "SELECT id,name,email,role,created_at,updated_at from users where id= ? LIMIT 1";
		$stmt = $this->db->prepare($query);
		$stmt->execute([$id]);

		return $stmt->fetch(\PDO::FETCH_ASSOC);	

	}
	
}