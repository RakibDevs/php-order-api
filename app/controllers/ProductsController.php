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
		$products = $this->product->get();
		toApi(200,'success', 'Products', $products);
	}

	public function store()
	{
		$products = $this->product->storeProduct(input()->all());
		toApi(200,'success', 'Product saved successfully');
	}

	public function show($id)
	{
		$product = $this->product->find($id);
		toApi(200,'success', 'Product', $product);
	}

	public function update($id)
	{
		return json_encode(['hi' => 1]);
	}

	public function delete($id)
	{
		return json_encode(['hi' => 1]);
	}

	public function categories()
	{
		$catrgories = $this->product->catrgories();
		toApi(200,'success', 'Categories', $catrgories);
	}
}