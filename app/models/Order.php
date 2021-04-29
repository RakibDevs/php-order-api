<?php
namespace App\Models;

use App\Models\Model;

class Order extends Model
{
	protected $table = 'orders';

	protected $order_products = 'order_products';

	public function getLastOrder()
	{
		$query = "SELECT * FROM ".$this->table." ORDER BY id DESC  LIMIT 1";

		$stmt = $this->db->prepare($query);
		$stmt->execute();
		return $stmt->fetch(\PDO::FETCH_ASSOC);
	}

	public function getMyOrders($customer)
	{
		$query = "SELECT * FROM ".$this->table." WHERE customer_id = ? ORDER BY id DESC  LIMIT 10";
		$stmt = $this->db->prepare($query);
		$stmt->execute([$customer]);
		return $stmt->fetchAll(\PDO::FETCH_ASSOC);
	}

	public function setStatus($id, $status)
	{
		try {
			$query = "UPDATE ".$this->table." SET status = ? WHERE id = ?";
			$stmt = $this->db->prepare($query);
			$stmt->execute([$status, $id]);

			toApi(200,'success','Order status has been updated!');
		}catch(\Exception $e){
			$this->exception();
		}
	}

	public function products($order)
	{
		$query = "SELECT op.*,p.title,p.image FROM ".$this->order_products." AS op LEFT JOIN products as p ON op.product_id = p.id WHERE op.order_id = ? ";
		$stmt = $this->db->prepare($query);
		$stmt->execute([$order]);
		return $stmt->fetchAll(\PDO::FETCH_ASSOC);
	}

	public function insertOrder($customer, $orderCode, $data)
	{
		$this->db->beginTransaction();
		try {
			$amount   	= $data['amount'];

			$query = "INSERT INTO ".$this->table." (customer_id,order_code,amount) VALUES (?, ?, ?)";
			$stmt = $this->db->prepare($query);
			$stmt->execute([$customer, $orderCode,$amount]);

			// get last product id
			$orderId = $this->db->lastInsertId();
			// store order products
			$this->insertOrderProducts($orderId, $data['products']);
			// commit database changes

			$this->db->commit();
			toApi(200,'success','Order placed! Your order ID is '.$orderCode);
		}catch(\Exception $e){
			$this->db->rollBack();
			$this->exception();
		}
	}

	public function insertOrderProducts($orderId, $products)
	{
		// insert multiple products
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