<?php declare (strict_types = 1);
namespace App\Classes;

class Request {

	/**
	 * return array or object
	 * @param  boolean $is_array
	 * @return mix
	 */
	public static function all($is_array = false) {
		$result = [];
		if (count($_POST) > 0) {$result['post'] = $_POST;}
		if (count($_GET) > 0) {$result['get'] = $_GET;}
		$result['file'] = $_FILES;

		return json_decode(json_encode($result), $is_array);
	}

	/**
	 * check request type
	 * @param  $key
	 * @return boolean
	 */
	public static function has($key) {
		if (self::get($key)) {
			return true;
		}
		return false;
	}

	/**
	 * get request type
	 * @param  $key
	 * @return object
	 */
	public static function get($key) {
		$data = self::all();
		return $data->$key;
	}

	/**
	 * sticky data
	 * @param  $key request type
	 * @param  $value input
	 * @return mix
	 */
	public function old($key, $value) {
		$data = self::all();
		return isset($data->$key->$value) ? $data->$key->$value : NULL;
	}
/**
 * unset all post types
 * @return void
 */
	public static function refresh() {
		$_POST = [];
		$_GET = [];
		$_FILES = [];
	}

}

?>