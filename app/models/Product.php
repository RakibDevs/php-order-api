<?php
namespace App\Models;

use App\Models\Model;

class Product extends Model
{
	protected $table = 'products';

	protected $categories_table = 'categories';


	public function getProducts($input)
	{
		$query = "SELECT p.* from ".$this->table." where email= ? and password= ? LIMIT 1";
		$stmt = $this->db->prepare($query);
		$stmt->execute([$email,$password]);

		return $stmt->fetch(\PDO::FETCH_ASSOC);

	}



}