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

	public function get()
	{
		$query = "SELECT * from ".$this->table." order by id desc";

		$stmt = $this->db->prepare($query);
		$stmt->execute();

		return $stmt->fetchAll(\PDO::FETCH_ASSOC);	
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