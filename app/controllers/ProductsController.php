<?php
namespace App\Controllers;

use App\Controllers\Controller;

use App\Models\Product;

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