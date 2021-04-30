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
		$query = "SELECT * FROM ".$this->table." where id= ? LIMIT 1";

		$stmt = $this->db->prepare($query);
		$stmt->execute([$id]);

		return $stmt->fetch(\PDO::FETCH_ASSOC);	

	}

	public function get()
	{
		$query = "SELECT * FROM ".$this->table." order by id desc";
		$stmt = $this->db->prepare($query);
		$stmt->execute();

		return $stmt->fetchAll(\PDO::FETCH_ASSOC);	
	}

	public function delete($id)
	{
		$query = "DELETE FROM ".$this->table." WHERE id = ?";
		$stmt = $this->db->prepare($query);
		$stmt->execute([$id]);
		return $stmt->execute([$id]);	
	}

	public function count()
	{
		$query = "SELECT COUNT(*) AS total_records FROM ".$this->table;
		$stmt = $this->db->prepare($query);
		$stmt->execute();
		$records =  $stmt->fetch(\PDO::FETCH_ASSOC);
		
		return $records['total_records'];	
	}

	public function storeFile($f)
	{
		$type = explode(".",$f['name']);
	    $extension = end($type);
	    $url = "./assets/images/".uniqid(rand()).".".$extension;

        if(is_uploaded_file($f['tmp_name'])){
            if(move_uploaded_file($f['tmp_name'],$url)){
                return $url;
            }
        }
	}


	protected function limit($page, $perpage)
	{
		return "LIMIT ".$perpage;
	}

	protected function offset($page, $perpage)
	{
		return "OFFSET ".$page*$perpage;
	}

	public function exception()
	{
		toApi(200,'error','Something wrong happened! Please try again');
	}


}