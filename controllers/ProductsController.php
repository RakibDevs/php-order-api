<?php
namespace Controllers;

use Controllers\Controller;

use Models\Product;

class ProductsController extends Controller
{
	public function index()
	{
		return json_encode(['hi' => 1]);
	}

	public function store()
	{
		return json_encode(['hi' => 1]);
	}

	public function show($id)
	{
		return json_encode(['hi' => $id]);
	}

	public function update($id)
	{
		return json_encode(['hi' => 1]);
	}

	public function delete($id)
	{
		return json_encode(['hi' => 1]);
	}
}