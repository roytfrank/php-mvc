<?php declare (strict_types = 1);

namespace App\Classes;
use App\Classes\Session;

class Cart {
	protected static $isIncart = false;

	public static function addItem($request) {
		try {
			$index = 0;
			if (!Session::has('user_cart') || count(Session::get('user_cart')) < 1) {
				Session::add('user_cart', [
					0 => ['product_id' => $request->product_id, 'quantity' => $request->quantity],
				]);
			} else {
				foreach ($_SESSION['user_cart'] as $cart_items) {
					$index++;
					foreach ($cart_items as $key => $value) {
						if ($key == 'product_id' && $value == $request->product_id) {
							array_splice($_SESSION['user_cart'], $index - 1, 1, [
								['product_id' => $request->product_id, 'quantity' => $cart_items['quantity'] + $request->quantity],
							]);
							self::$isIncart = true;
						}
					}
				}
				if (!self::$isIncart) {
					array_push($_SESSION['user_cart'], ['product_id' => $request->product_id, 'quantity' => $request->quantity]);
				}
			}
		} catch (\Exception $ex) {
			echo $ex->getMessage();
			exit;
		}
	}
}