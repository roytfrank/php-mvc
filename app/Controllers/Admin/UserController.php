<?php declare (strict_types = 1);

namespace App\Controllers\Admin;
use App\Classes\Redirect;
use App\Classes\Role;
use App\Controllers\BaseController;
use App\Models\User;

class UserController extends BaseController {
	public $users;
	public function __construct() {
		if (!Role::middleware('56') && !Role::middleware('66')) {
			Redirect::to('/');
		}
		$this->users = User::all();
	}

	public function show() {
		return view('admin/users', ['users' => $this->users]);
	}
}