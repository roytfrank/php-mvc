<?php declare (strict_types = 1);

namespace App\Controllers;
use App\Classes\Cart;
use App\Classes\CSRFToken;
use App\Classes\Mail;
use App\Classes\Request;
use App\Classes\Session;
use App\Controllers\BaseController;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Stripe\Charge;
use Stripe\Customer;

class CartController extends BaseController {

	public function show() {
		return view('/store/cart');
	}

	public function addItemToCart() {
		if (Request::has('post')) {
			$request = Request::get("post");
			if (CSRFToken::validateToken($request->token, false)) {
				if (!$request->product_id) {
					throw new \Exception('Malicious request');
				}
				Cart::addItem($request);
				echo json_encode(array("success" => "Product added to Cart"));
				exit;
			}
		}
	}
/**
 * get items in cart
 * @return objects
 */
	public function getcartitems() {
		$result = array();
		$cartTotal = 0;
		try {
			if (!Session::has("user_cart") || count(Session::get("user_cart")) < 1) {
				echo json_encode(["fail" => "There is no item in cart"]);
				exit;
			} else {
				$index = 0;
				foreach ($_SESSION['user_cart'] as $cart_items) {
					$product_id = $cart_items['product_id'];
					$quantity = $cart_items['quantity'];
					$item = Product::where("id", $product_id)->first();
					if (!$item) {continue;}
					if ($quantity > $item->quantity) {
						$quantity = $item->quantity;
					}
					$totalPrice = $item->saleprice * $quantity;
					$cartTotal += $totalPrice;
					array_push($result, [
						'id' => $item->id,
						'slug' => $item->slug,
						'name' => $item->name,
						'description' => $item->description,
						'price' => $item->price,
						'percentoff' => $item->percentoff,
						'quantity' => $item->quantity,
						'saleprice' => $item->saleprice,
						'image' => $item->image1,
						'buyer_quantity' => $quantity,
						'totalPrice' => $totalPrice,
						'item_index' => $index,
					]);
					$index++;
				}

				$cartTotal = $cartTotal;
				$amountInCents = toCents($cartTotal);
				Session::add('cartTotal', $amountInCents);
				echo json_encode(["cartItems" => $result, "cartTotal" => $cartTotal, 'authenticated' => isAuthenticated(), 'amountInCents' => $amountInCents]);
				exit;
			}
		} catch (\Exception $ex) {
			throw new \Exception("Critical error puttin item in cart" . $ex->getMessage());
		}
	}

	public function updateQty() {
		if (Request::has("post")) {
			$request = Request::get("post");
			try {
				$quantity = "";
				$index = 0;
				foreach ($_SESSION['user_cart'] as $cart_items) {
					$index++;
					foreach ($cart_items as $key => $value) {

						if ($key === "product_id" && $value === $request->product_id) {
							switch ($request->operator) {
							case '+':
								$quantity = $cart_items['quantity'] + 1;
								break;
							case '-':
								$quantity = $cart_items['quantity'] - 1;
								if ($quantity < 1) {
									$quantity = 1;
								}
								break;
							default:
								throw new \Exception("Unauthorized Item Quantity Change Request");
							}
							array_splice($_SESSION['user_cart'], $index - 1, 1, [[
								'product_id' => $request->product_id,
								'quantity' => $quantity,
							]]);
						}
					}
				}
			} catch (\Exception $ex) {
				echo $ex->getMessage();
			}
		}
	}

	public function removeItem() {
		if (Request::has('post')) {
			$request = Request::get('post');
			try {
				if ($request->index === " ") {
					throw new \Exception("Unauthorized request to change item quantity");
				}
				if (Session::has("user_cart") && count(Session::get("user_cart")) <= 1) {
					unset($_SESSION['user_cart']);
					$request->index = NULL;
					echo json_encode(array("success" => "Item removed successfully"));
					exit;
				} else {
					$index = $request->index;

					unset($_SESSION['user_cart'][$index]);
					sort($_SESSION['user_cart']);

					echo json_encode(array("success" => "Item removed successfully"));
					exit;
				}
			} catch (\Exception $ex) {
				echo $ex->getMessage();
			}
		}
	}

	public function checkOut() {
		if (Request::has('post')) {
			$request = Request::get('post');
			$token = $request->stripeToken;
			$email = $request->stripeEmail;
			try {
				$customer = Customer::create([
					'email' => $email,
					'source' => $token,
				]); //You can save custome to charge later plus user()->id. Note.
				$amount = Session::get('cartTotal'); //we get session amount because javascript amount can be manipulated.
				$charge = Charge::create([
					'customer' => $customer->id,
					'amount' => $amount,
					'description' => user()->name . " rejoy store purchase",
					'currency' => 'usd',
				]);
				$result['product'] = array(); //we create unique id for each item
				$result['order_id'] = array();
				$result['total'] = array();
				foreach ($_SESSION['user_cart'] as $cart_items) {
					$productId = $cart_items['product_id'];
					$quantity = $cart_items['quantity'];
					$item = Product::where('id', $productId)->first();
					if (!$item) {continue;}
					$order_id = strtoupper(uniqid());
					$totalPrice = $item->saleprice * $quantity;
					Order::create([ //we want to create an order for each cart item
						'product_id' => $productId,
						'user_id' => user()->id,
						'customer' => $customer->id,
						'item_price' => $item->saleprice,
						'tax1' => $item->price * (1 / 100),
						'tax2' => $charge->status,
						'total' => $totalPrice,
						'quantity' => $quantity,
						'status' => 'pending',
						'order_num' => $order_id,
						'created_at' => Carbon::now("America/New_York"),
						'updated_at' => Carbon::now("America/New_York"),
					]);
					$item->quantity -= $quantity; //we reduce the item quantity
					$item->save();
					array_push($result['product'], [ //we will need this for email sending.
						'name' => $item->name,
						'description' => $item->description,
						'price' => $item->price,
						'percentoff' => $item->percentoff,
						'quantity' => $item->quantity,
						'saleprice' => $item->saleprice,
						'image' => $item->image1,
						'buyer_quantity' => $quantity,
						'totalPrice' => $totalPrice,
					]);
				}
				$order_num = strtoupper(uniqid());
				Payment::create([
					'user_id' => user()->id,
					'order_num' => $order_num,
					'amount' => $charge->amount,
					'status' => $charge->amount,
					'created_at' => Carbon::now("America/New_York"),
					'updated_at' => Carbon::now("America/New_York"),
				]);
				$result['order_id'] = $order_num;
				$result['total'] = Session::get('cartTotal');
				$data = [
					'to' => user()->email,
					'subject' => 'order confirmation',
					'view' => 'purchase',
					'name' => user()->name,
					'body' => $result,
				];
				(new Mail())->send($data);

			} catch (\Exception $ex) {
				throw new \Exception("Error creating stripe order and payment" . $ex->getMessage());
			}
			unset($_SESSION['user_cart']);

			echo json_encode(["success" => "Thank you for the purchase. Your payment was received and your order is being processed"]);
			exit;
		}
	}

	public function paypalCheckout() {
		try {

			if (Request::has("post")) {
				$request = Request::get("post");

				if (getenv("APP_ENV") == "production") {
					$paypal_url = "https://api.paypal.com/v1/oauth2/token";
				} else {
					$paypal_url = "https://api.sandbox.paypal.com/v1/oauth2/token";
				}

				$client = new Client;

				$requestToken = $client->post($paypal_url, [
					"headers" => [
						"Accept" => "application/json",
					],
					"auth" => [getenv("PAYPAL_CLIENT"), getenv("PAYPAL_SECRET")],
					"form_params" => [
						"grant_type" => "client_credentials",
					],
				]);

				$token = json_decode($requestToken->getBody());
				$accessToken = $token->access_token;

				// $access_token = "A21AAGGle1krI11eESyXUUfxwjjt30wNumD2oXbYFeSPfCeilvUFxdftqvxqrujnzi4Gz6wvo6ZIUfZg_maDSVRQNfES1X7xg";
				//
				$transaction = $client->get("https://api.sandbox.paypal.com/v2/checkout/orders/25N17337B1207492K", [
					"headers" => [
						"Content-Type" => "application/json",
						"Authorization" => "Bearer " . $accessToken,
					],
				]);

				$details = json_decode($transaction->getBody());

				$paymentData = [
					"order_id" => $details->id,
					"name" => $details->purchase_units->shipping->name->full_name,
					"currency_code" => $details->purchase_units->amount->currency_code,
					"amount" => $details->purchase_units->amount->value,
					"email_address" => $details->purchase_units->payee->email_address,
					"capture_id" => $details->purchase_units->payments->captures->id,
					"status" => $details->purchase_units->payments->captures->status,
					"created_at" => $details->purchase_units->payments->captures->create_time,
					"updated_at" => $details->purchase_units->payments->captures->update_time,
				];

				$result['product'] = array(); //we create unique id for each item
				$result['order_id'] = array();
				$result['total'] = array();
				foreach ($_SESSION['user_cart'] as $cart_items) {
					$productId = $cart_items['product_id'];
					$quantity = $cart_items['quantity'];
					$item = Product::where('id', $productId)->first();
					if (!$item) {continue;}
					$order_id = strtoupper(uniqid());
					$totalPrice = $item->saleprice * $quantity;
					Order::create([ //we want to create an order for each cart item
						'product_id' => $productId,
						'user_id' => user()->id,
						'customer' => $customer->id,
						'item_price' => $item->saleprice,
						'tax1' => $item->price * (1 / 100),
						'tax2' => $charge->status,
						'total' => $totalPrice,
						'quantity' => $quantity,
						'status' => 'pending',
						'order_num' => $order_id,
						'created_at' => Carbon::now("America/New_York"),
						'updated_at' => Carbon::now("America/New_York"),
					]);
					$item->quantity -= $quantity; //we reduce the item quantity
					$item->save();
					array_push($result['product'], [ //we will need this for email sending.
						'name' => $item->name,
						'description' => $item->description,
						'price' => $item->price,
						'percentoff' => $item->percentoff,
						'quantity' => $item->quantity,
						'saleprice' => $item->saleprice,
						'image' => $item->image1,
						'buyer_quantity' => $quantity,
						'totalPrice' => $totalPrice,
					]);
				}

				$order_num = strtoupper(uniqid());
				Payment::create([
					'user_id' => user()->id,
					'order_num' => $order_num,
					'amount' => $details->purchase_units->amount->value,
					'status' => json_encode($paymentData),
					'created_at' => Carbon::now("America/New_York"),
					'updated_at' => Carbon::now("America/New_York"),
				]);
				$result['order_id'] = $order_num;
				$result['total'] = Session::get('cartTotal');
				$data = [
					'to' => user()->email,
					'subject' => 'order confirmation',
					'view' => 'purchase',
					'name' => user()->name,
					'body' => $result,
				];
				(new Mail())->send($data);

				unset($_SESSION['user_cart']);
				echo json_encode(["success" => "Thank you for the purchase. Your payment was received and your order is being processed"]);
				exit;
			}

		} catch (\Exception $ex) {
			echo $ex->getMessage();
			//25N17337B1207492K
		}
	}
}