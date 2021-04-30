<?php
namespace App\Models;

use App\Models\Model;

class Product extends Model
{
	protected $table = 'products';

	protected $categories_table = 'categories';

	public function catrgories()
	{
		$query = "SELECT * FROM ".$this->categories_table." order by id desc";
		$stmt = $this->db->prepare($query);
		$stmt->execute();

		return $stmt->fetchAll(\PDO::FETCH_ASSOC);	
	}

	public function getProducts()
	{
		$where = '';
		$limit = '';

		$query = "SELECT p.*, c.name as category_name from ".$this->table." AS p LEFT JOIN ".$this->categories_table." AS c ON p.category_id = c.id ORDER BY p.id";
		$stmt = $this->db->prepare($query);
		$stmt->execute();

		return $stmt->fetchAll(\PDO::FETCH_ASSOC);

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