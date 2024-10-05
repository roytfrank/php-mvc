<?php declare (strict_types = 1);

namespace App\Classes;
use App\Exception\InvalidSessionParamsException;

class Session {

/**
 * Create session
 * @param mix $name
 * @param  mix $value
 */
	public static function add($name, $value) {
		try {
			if ($value !== " " && !empty($value) && $name !== " " && !empty($name)) {
				return $_SESSION[$name] = $value;
			}
		} catch (\Exception $ex) {
			throw new InvalidSessionParamsException("value and name is required" . $ex->getMessage());
		}
	}

	/**
	 * have session in return
	 * @param mix $name
	 * @return mix $_SESSION[$name]
	 */
	public static function get($name) {
		if ($name !== " " && !empty($name)) {
			return $_SESSION[$name];
		}
	}

	/**
	 * if session exists
	 * @param  mix $name
	 * @return boolean
	 */
	public static function has($name) {

		try {
			if ($name !== " " && !empty($name)) {
				return isset($_SESSION[$name]) ? true : false;
			}

		} catch (\Exception $ex) {
			throw new \Exception("Session not found" . $ex->getMessage());
		}
	}

	/**
	 * unset session
	 * @param  mix $name
	 * @return boolean
	 */
	public static function unset($name) {
		if (self::has($name)) {
			unset($_SESSION[$name]);
		}
	}
}