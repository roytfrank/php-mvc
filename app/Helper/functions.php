<?php declare (strict_types = 1);

use App\Classes\Session;
use App\Models\User;
use Illuminate\Database\Capsule\Manager as Capsule;
use Philo\Blade\Blade;
use voku\helper\Paginator;

function view($path, $data = []) {
	$view = __DIR__ . '/../../resources/views';
	$cache = __DIR__ . '/../../bootstrap/cache';
	$blade = new Blade($view, $cache);
	echo $blade->view()->make($path, $data)->render();
}

function make($filename, $data) {
	extract($data);
	ob_start();
	include __DIR__ . "/../../resources/views/emails/" . $filename . ".php";
	$content = ob_get_contents();
	ob_end_clean();
	return $content;
}

function slug($value) {
	$value = preg_replace('![^' . preg_quote('_') . '\PN\PL\s]+!u', '', mb_strtolower($value));
	$value = preg_replace('![' . preg_quote('_') . '\s]+!u', '-', $value);
	return trim($value, '-'); //remove white spaces
}

function paginate($number_of_records, $total, $table, $object) {
	$entity = []; //e. categories etc
	$pages = new Paginator($number_of_records, 'p');
	$pages->set_total($total);
// get number of total records
	$data = Capsule::select("SELECT * FROM " . $table . " WHERE deleted_at IS NULL ORDER BY created_at DESC " . $pages->get_limit());
	$entity = $object->transform($data);
// create the page links
	return [$entity, $pages->page_links()];
}

function isAuthenticated() {
	if (Session::has('user_login') && Session::has('user_print')) {
		return true;
	} else {return false;}
	die("Illegal attempt");
}

function user() {
	if (isAuthenticated()) {
		return User::findOrFail(Session::get('is_logged_in_user'));
	}
	return false;
}

function toCents($value) {
	$value = preg_replace('/[^0-9\.]/i', '', $value);
	$value = (float) $value;
	return round($value, 2) * 100;
}