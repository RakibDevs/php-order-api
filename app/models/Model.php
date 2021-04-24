<?php
namespace App\Models;

use Config\DB;

class Model 
{
	protected $db;

	protected $table;

	public function __construct()
	{
		$this->db = (new DB)->connect();
	}


	public function find($id)
	{
		$query = "SELECT * from ".$this->table." where id= ? LIMIT 1";

		$stmt = $this->db->prepare($query);
		$stmt->execute([$id]);

		return $stmt->fetch(\PDO::FETCH_ASSOC);	

	}
}