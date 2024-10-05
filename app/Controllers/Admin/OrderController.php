<?php declare (strict_types = 1);
namespace App\Controllers\Admin;
use App\Classes\Redirect;
use App\Classes\Role;
use App\Controllers\BaseController;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;

class OrderController extends BaseController {
	public $orders;
	public function __construct() {
		if (!Role::middleware('56') && !Role::middleware('66')) {
			Redirect::to('/');
		}
		$this->orders = Order::all();
		$this->products = Product::all();
		$this->users = User::all();
	}

	public function show() {
		return view('admin/orders', ['orders' => $this->orders, 'products' => $this->products, 'users' => $this->users]);
	}

}
