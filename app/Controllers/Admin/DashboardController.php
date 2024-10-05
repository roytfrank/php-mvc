<?php declare (strict_types = 1);

namespace App\Controllers\Admin;
use App\Classes\Redirect;
use App\Classes\Role;
use App\Controllers\BaseController;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Capsule\Manager as Capsule;

class DashboardController extends BaseController {

	public $orders;
	public $users;
	public $products;
	public $payments;

	public function __construct() {
		if (!Role::middleware('56')) {
			Redirect::to('/login');
		}
		$this->orders = Order::all()->count();
		$this->users = User::all()->count();
		$this->products = Product::all()->count();
		$this->payments = Payment::all()->sum('amount');
	}

	public function show() {
		return view('admin/dashboard', ['orders' => $this->orders, 'users' => $this->users, 'products' => $this->products, 'payments' => $this->payments]);
	}

	public function chart() {
		$revenue = Capsule::table('payments')->select(Capsule::raw('sum(amount)/100 as amount'),
			Capsule::raw("DATE_FORMAT(created_at, '%m-%Y') new_date"),
			Capsule::raw("Year(created_at) year"),
			Capsule::raw("Month(created_at) month"))->groupby('year', 'month')->get();

		$orders = Capsule::table('orders')->select(Capsule::raw('count(id) as count'),
			Capsule::raw("DATE_FORMAT(created_at, '%m-%Y') new_date"),
			Capsule::raw("Year(created_at) year"),
			Capsule::raw("Month(created_at) month"))->groupby('year', 'month')->get();

		echo json_encode(['orders' => $orders, 'revenue' => $revenue]);
		exit;
	}

}