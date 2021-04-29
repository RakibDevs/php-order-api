<?php
namespace App\Controllers;

use App\Controllers\Controller;
use App\Models\Order;
use App\Models\User;

class OrderController extends Controller
{
	protected $user;

	protected $order;

	protected $orderSuffix = 'WE';

	public function __construct()
	{
		$this->user    = new User;
		$this->order   = new Order;
	}

	public function store()
	{
		$orderCode = $this->genrateOrderCode();
		$customer  = $this->user->getUserId();

		$this->order->insertOrder($customer, $orderCode, input()->all());
	}


	public function show($id)
	{
		$data['order'] 	  = $this->order->find($id);
		if($data['order']){
			$data['products'] = $this->order->products($id);
			toApi(200,'success','Order Products', $data);
		}
		toApi(200,'error','No order found!');
	}


	public function myOrders()
	{
		$customer  = $this->user->getUserId();
		$order     = $this->order->getMyOrders($customer);

		toApi(200,'success','Your Orders', $order);
	}

	public function orders()
	{
		$orders = $this->order->get();
		toApi(200,'success','ALl Orders', $orders);
	}


	protected function genrateOrderCode()
	{
		$last = $this->order->getLastOrder();
		$id   = $last['id']??1;

		return $this->orderSuffix.sprintf('%08d', $id);
	}

}