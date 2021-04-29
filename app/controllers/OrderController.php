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

	protected function genrateOrderCode()
	{
		$last = $this->order->getLastOrder();
		$id   = $last['id']??1;

		return $this->orderSuffix.sprintf('%08d', $id);
	}

}