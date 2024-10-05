<?php declare (strict_types = 1);

namespace App\Classes;

class CSRFToken {

	/**
	 * create session token
	 * @return $randomToken
	 */
	public static function token() {
		if (!Session::has('token')) {
			$randomToken = base64_encode(openssl_random_pseudo_bytes(32));
			Session::add('token', $randomToken);
		}
		return Session::get('token');
	}

	/**
	 * validate token
	 * @return boolean
	 */
	public static function validateToken($requestToken, $cond = true) {
		try {
			if (Session::has('token') && Session::get('token') === $requestToken) {
				if ($cond) {
					Session::unset('token');
				}
				return true;
			}
		} catch (\Exception $ex) {
			throw new \Exception("Token mismatch" . $ex->getMessage());
		}
	}
}