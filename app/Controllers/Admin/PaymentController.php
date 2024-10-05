<?php declare (strict_types = 1);
namespace App\Controllers\Admin;
use App\Classes\Redirect;
use App\Classes\Role;
use App\Models\Payment;
use App\Models\User;

class PaymentController {
	public $payments;
	public $users;
	public function __construct() {
		if (!Role::middleware('56') && !Role::middleware('66')) {
			Redirect::to('/');
		}
		$this->payments = Payment::all();
		$this->users = User::all();
	}
	/**
	 * All payments
	 * @return object
	 */
	public function show() {
		return view('admin/payments', ['users' => $this->users, 'payments' => $this->payments]);
	}

}