<?php declare (strict_types = 1);

namespace App\Controllers\Auth;
use App\Classes\CSRFToken;
use App\Classes\Mail;
use App\Classes\Redirect;
use App\Classes\Request;
use App\Classes\Session;
use App\Classes\validateRequest;
use App\Controllers\BaseController;
use App\Models\User;

class AuthController extends BaseController {

	public function __construct() {
		if (isAuthenticated()) {
			Redirect::to('/');
		}
	}

/** create login */
	public function login() {
		return view('member/login');
	}
/** create registration */
	public function create() {
		return view('member/register');
	}
/**
 * Store user
 * @return array
 */
	public function store() {
		if (Request::has('post')) {
			$request = Request::get('post');
			if (CSRFToken::validateToken($request->token, true)) {
				if ($request->password != $request->confirm_password) {
					$errors['password'] = ['Password did not match!'];
					return view('member/register', ['errors' => $errors]);
				}
				if (!filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
					$errors['email'] = ['Invalid email'];
					return view('member/register', ['errors' => $errors]);
				}
				$rules = ['name' => ['required' => true, 'maxLength' => 255],
					'email' => ['required' => true, 'unique' => 'users', 'maxLength' => 255],
					'username' => ['required' => true, 'unique' => 'users', 'maxLength' => 255],
					'password' => ['required' => true, 'minLength' => 5, 'maxLength' => 255],
				];
				validateRequest::abide($request, $rules);
				if (validateRequest::hasErrors()) {
					$errors = validateRequest::getErrors();
					return view('member/register', ['errors' => $errors]);
				}
				$hash_password = password_hash($request->password . "rejoy86", PASSWORD_BCRYPT);
				$verification_token = md5((openssl_random_pseudo_bytes(32) . "rejoy86"));
				User::create([
					'name' => $request->name,
					'email' => $request->email,
					'username' => $request->username,
					'verification_token' => $verification_token,
					'role_id' => User::REGULAR_USER,
					'password' => $hash_password,
				]);
				$body = ['name' => $request->name,
					'verification_token' => $verification_token,
					'email' => $request->email,
				];
				$data = [
					'to' => $request->email,
					'subject' => 'Verify Account',
					'view' => 'verification',
					'name' => $request->name,
					'body' => $body,
				];
				(new Mail())->send($data);
				Request::refresh();
				$_SESSION['register']['success'] = 'after verifying your account. An email has been sent to you. Check your inbox and spam folder for the email';
				Redirect::to('/login');
				exit;
			}
			return view("errors/token");
		}
		return view("errors/request");
	}

	public function auth() {
		if (Request::has('post')) {
			$request = Request::get("post");
			if (CSRFToken::validateToken($request->token, true)) {
				$rules = ['username' => ['required' => true, 'maxLength' => 255],
					'password' => ['required' => true, 'maxLength' => 255],
				];
				validateRequest::abide($request, $rules);
				if (validateRequest::hasErrors()) {
					$errors = validateRequest::getErrors();
					return view('member/login', ['errors' => $errors]);
				}
				$user = User::where('username', $request->username)->orwhere('email', $request->username)->first();
				if ($user->verification_token === "verified") {
					$hashed_password = $user->password;
					if (password_verify($request->password . "rejoy86", $hashed_password)) {
						Session::add('is_logged_in_user', $user->id);
						Session::add('user_login', 'true');
						Session::add('user_print', $user->name);
						if ($user->isAdmin()) {
							Redirect::to('/admin/dashboard');
							exit;
						} else if ($user->isEditor()) {
							Redirect::to('/admin/products');
							exit;
						} else if (Session::has('user_cart')) {
							Redirect::to('/cart');
							exit;
						} else {
							Redirect::to('/');
							exit;
						}
					}
					$errors['unauthorized'] = ['Incorrect username or password'];
					return view('member/login', ['errors' => $errors]);
				}
				$errors['unauthorized'] = ['Please verify your account before login'];
				return view('member/login', ['errors' => $errors]);
			}
			$errors['unauthorized'] = ['Incorrect credential. Please login!'];
			return view('member/login', ['errors' => $errors]);
		}
	}
/**
 * Logout
 * @return mix
 */
	public function signOut() {
		if (isAuthenticated()) {
			if (Session::has('is_logged_in_user') && Session::has('user_login') && Session::has('user_print')) {
				Session::unset('is_logged_in_user');
				Session::unset('user_login');
				Session::unset('user_print');
			} else {
				Session::unset('is_logged_in_user');
				Session::unset('user_login');
				Session::unset('user_print');
				die("Illegal activity");
			}
			if (!Session::has('user_cart')) {
				session_destroy();
				session_regenerate_id(true);
			}
		}
		Redirect::to('/login');
	}

	public function verify($token) {
		$user = User::where('verification_token', $token)->first()
		;
		if ($user) {
			$user->verification_token = "verified";
			$user->save();
			$_SESSION['register']['success'] = 'You have successfully verified your account';
			Redirect::to('/login');
		}
		return view("errors/404");
	}
}