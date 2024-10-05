<?php declare (strict_types = 1);
namespace App\Classes;

class Redirect {

	/**
	 * page redirection to
	 * @param  mix $url
	 */
	public static function to($url) {
		header("Location: {$url}");
	}

	/**
	 * redirect back
	 * @return $_SERVER
	 */
	public static function back() {
		$uri = $_SERVER['REQUEST_URI'];
		header("Location: {$uri}");
	}
}