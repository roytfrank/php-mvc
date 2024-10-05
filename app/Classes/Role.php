<?php declare (strict_types = 1);
namespace App\Classes;

class Role {

	public function middleware($role) {
		switch ($role) {
		case '56':
			$message = "Page not found or you are not authorized to view this page";
			break;
		case '66':
			$message = "Page not found or you are not authorized to view this page";
			break;
		case '86':
			$message = "Page not found or you are not authorized to view this page";
			break;
		}
		if (isAuthenticated()) {
			if (user()->role_id != $role) {
				Session::add('error', $message);
				return false;
			}
		} else {
			Session::add('error', $message);
			return false;
		}
		return true;
	}
}
