<?php
namespace App\Models;

use App\Models\Model;

class Product extends Model
{
	protected $table = 'products';

	protected $categories_table = 'categories';

	protected $skuSuffix = 'WE';

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
		$category  = $input['category_id'];
		$sku       = $this->generateSku($category);
		$description= $input['description'];
		$price 	   = $input['price'];

		$query = "INSERT INTO products (title, category_id, sku, description, image, price) VALUES (?, ?, ?, ?, ?, ?)";
		$stmt = $this->db->prepare($query);
		$stmt->execute([$title, $category,$sku, $description, $image, $price]);
		$stmt = null;

		toApi(200,'success','Product uploaded succesfuly');

	}

	public function updateProduct($id, $input)
	{
		/*$image = $input['prev_image_src'];
		if($input['image']){
			$image = $this->storeFile($input['image']);
		}*/	

		$title     = $input['title'];
		$category  = $input['category_id'];
		$description= $input['description'];
		$price 	   = $input['price'];

		$query = "UPDATE products SET title = ? , category_id = ? , description = ?, price = ? WHERE id = ?";
		$stmt = $this->db->prepare($query);
		$stmt->execute([$title, $category, $description, $price, $id]);
		$stmt = null;

		toApi(200,'success','Product updated succesfuly');
		
	}


	public function generateSku($category)
	{
		$last = $this->getLastProduct($category);
		$id   = $last['id']??1;

		$suffix = sprintf('%02d', $category).$this->skuSuffix;

		return $suffix .sprintf('%03d', $id+1);
	}

	public function getLastProduct($category)
	{
		$query = "SELECT * FROM ".$this->table." WHERE category_id = ? ORDER BY id DESC  LIMIT 1";
		$stmt = $this->db->prepare($query);
		$stmt->execute([$category]);
		return $stmt->fetch(\PDO::FETCH_ASSOC);
	}



}