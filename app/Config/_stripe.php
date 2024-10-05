<?php declare (strict_types = 1);
use App\Classes\Session;

$stripe = array(
	'stripe_secret' => getenv('STRIPE_SECRET'),
	'stripe_publishable_key' => getenv('SRTIPE_PUBLISHABLE_KEY'),
);

Session::add('publishable_key', $stripe['stripe_publishable_key']);
\Stripe\Stripe::setApiKey($stripe['stripe_secret']);