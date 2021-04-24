<?php
namespace App\Controllers;

use App\Controllers\Controller;

use App\Models\Product;

class OrderController extends Controller
{
	public function store()
	{
		return json_encode(['hi' => 1]);
	}
}