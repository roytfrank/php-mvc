<?php declare (strict_types = 1);

namespace App\Classes;
use Illuminate\Database\Capsule\Manager as Capsule;

class validateRequest {
	protected static $errors = [];
	protected static $error_messages = [
		'unique' => 'The :attribute has an account',
		'emai' => ' The :attribute field is not a valid email',
		'required' => ' The :attribute field is required',
		'string' => ' The :attribute field must be string',
		'number' => ' The :attribute field must be number',
		'mixed' => ' The :attribute field containes invalid characters or is null',
		'maxLength' => ' The :attribute field can not be greater than :policy characters',
		'minLength' => ' The :attribute field can not be less than :policy characters',
	];

	//$validationRule = [$column =>[$validation=>$policy, $validation2=>$policy2]]
	public static function abide($requestData, $validationRule) {
		foreach ($requestData as $column => $value) {
			if (in_array($column, array_keys($validationRule))) {
				self::doValidation([
					'column' => $column,
					'value' => $value,
					'policies' => $validationRule[$column],
				]);
			}
		}
	}
	public static function doValidation(array $data) {
		$column = $data['column'];
		$value = $data['value'];
		foreach ($data['policies'] as $validation => $policy) {
			$valid = call_user_func_array([self::class, $validation], [$column, $value, $policy]);
			if (!$valid) {
				self::setErrors(
					str_replace([':attribute', ':policy'], [$column, $policy], self::$error_messages[$validation]), $column); //we pass column as second param to check for multiple column validation
			}
		}
	}

	//key is present $rule = ['name'=>[your validation]]
	public static function setErrors($errorMessage, $key) {
		//$key = $column

		if ($key) {
			self::$errors[$key][] = $errorMessage;
		}
		// self::$errors[] = $errorMessage;
	}
	public static function hasErrors() {
		return count(self::$errors) > 0 ? true : false;
	}

	public static function getErrors() {
		return self::$errors;
	}

	/**
	 * @param $column is input name
	 * @param $value is input value
	 * @param $policy is validation input
	 */
	public static function unique($column, $value, $policy) {
		if ($value !== " " || !empty(trim($value))) {
			return !Capsule::table($policy)->where($column, '=', $value)->first();
		}
	}
	public static function required($column, $value, $policy) {
		if ($value === " " || empty(trim($value))) {
			return false;
		}

		return true;
	}
	public static function minLength($column, $value, $policy) {
		if ($value !== " " && !empty(trim($value))) {
			return strlen($value) > $policy ? true : false;
		}
	}
	public static function maxLength($column, $value, $policy) {
		if ($value !== " " || !empty(trim($value))) {
			return strlen($value) < $policy ? true : false;
		}
	}
	public static function string($column, $value, $policy) {
		if ($value !== NULL && !empty(trim($value))) {
			if (!preg_match('/^[A-Za-z\s]+$/', $value)) {
				return false;
			}
			return true;
		}
	}
	public static function number($column, $value, $policy) {
		if ($value !== NULL && !empty(trim($value))) {
			if (!preg_match('/^[0-9.-]+$/', $value)) {
				return false;
			}
			return true;
		}
	}
	public static function mixed($column, $value, $policy) {
		if ($value !== NULL && !empty(trim($value))) {
			if (!preg_match('![' . preg_quote(['&', '*', '%', '$', '@', '#', '+']) . '\PN\PL\s]+!u', $value)) {
				return false;
			}
			return true;
		}
	}

}