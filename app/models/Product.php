<?php
namespace App\Models;

use App\Models\Model;

class Product extends Model
{
	protected $table = 'products';

	protected $categories_table = 'categories';


	public function getProducts($input)
	{
		$where = '';
		$limit = '';

		$query = "SELECT p.* from ".$this->table." where email= ? and password= ? LIMIT 1";
		$stmt = $this->db->prepare($query);
		$stmt->execute([$email,$password]);

		return $stmt->fetch(\PDO::FETCH_ASSOC);

	}

	public function storeProduct($input)
	{	
		$image = '';
		if($input['image']){
			$image = $this->storeFile($input['image']);
		}	

		$title     = $input['title'];
		$category  = $this->generateSku();
		$sku       = 'CAT00TEST';
		$description= $input['description'];
		$price 	   = $input['price'];

		$query = "INSERT INTO products (title, category_id, sku, description, image, price) VALUES (?, ?, ?, ?, ?, ?)";
		$stmt = $this->db->prepare($query);
		$stmt->execute([$title, $category,$sku, $description, $image, $price]);
		$stmt = null;

		toApi(200,'success','Product uploaded succesfuly');

	}

	public function generateSku()
	{
		return 'CAT00001';
	}



}