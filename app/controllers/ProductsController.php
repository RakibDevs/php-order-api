<?php
namespace App\Controllers;

use App\Controllers\Controller;
use Pecee\Http\Request;
use App\Models\Product;
use App\Models\User;

class ProductsController extends Controller
{
	protected $user; 

	protected $product;

	public function __construct()
	{
		$this->user    = new User;
		$this->product = new Product;
	}

	public function index()
	{

	}

	public function store()
	{
		return json_encode(['hi' => 1]);
	}

	public function show($id)
	{
		$product = $this->product->find($id);
		response()->json($product);
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