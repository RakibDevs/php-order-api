<?php
namespace App\Models;

use App\Models\Model;

class Order extends Model
{
	protected $table = 'orders';

	protected $order_products = 'order_products';

	public function getLastOrder()
	{
		$query = "SELECT * from ".$this->table." ORDER BY ID DESC  LIMIT 1";

		$stmt = $this->db->prepare($query);
		$stmt->execute();
		return $stmt->fetch(\PDO::FETCH_ASSOC);
	}

	public function insertOrder($customer, $orderCode, $data)
	{
		$this->db->beginTransaction();
		try {
			$amount   	= $data['amount'];

			$query = "INSERT INTO ".$this->table." (customer_id,order_code,amount) VALUES (?, ?, ?)";
			$stmt = $this->db->prepare($query);
			$stmt->execute([$customer, $orderCode,$amount]);

			$orderId = $this->db->lastInsertId();
			// store order products
			$this->insertOrderProducts($orderId, $data['products']);
			$this->db->commit();
			toApi(200,'sucess','Order placed! Your order ID is '.$orderCode);
		}catch(\Exception $e){
			var_dump($e->getMessage());
			$this->db->rollBack();
			$this->exception();
		}
	}

	public function insertOrderProducts($orderId, $products)
	{
		$stmt = $this->db->prepare('INSERT INTO '.$this->order_products.' (order_id,product_id,unit_price,qty) VALUES(:order_id, :product_id, :unit_price, :qty)');
		foreach($products as $item)
		{
		    $stmt->bindValue(':order_id', $orderId);
		    $stmt->bindValue(':product_id', $item['id']);
		    $stmt->bindValue(':unit_price', $item['price']);
		    $stmt->bindValue(':qty', $item['qty']);
			$stmt->execute();
		}
	}
}