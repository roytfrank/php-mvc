<?php declare (strict_types = 1);
/**
 * Categories
 */
//Category Controller
$router->map('GET', '/admin/categories', 'App\Controllers\Admin\ProductCategoryController@show', 'product-categories');
$router->map('POST', '/admin/categories', 'App\Controllers\Admin\ProductCategoryController@store', 'product-categories-create');
$router->map('POST', '/admin/categories/[i:id]/update', 'App\Controllers\Admin\ProductCategoryController@update', 'product-categories-update');
$router->map('POST', '/admin/categories/[i:id]/delete', 'App\Controllers\Admin\ProductCategoryController@delete', 'product-categories-delete');

//Sub Category Controller
$router->map('POST', '/admin/subcategories/create', 'App\Controllers\Admin\ProductSubCategoryController@store', 'product-subcategories-create');
$router->map('POST', '/admin/subcategories/[i:id]/update', 'App\Controllers\Admin\ProductSubCategoryController@update', 'product-subcategories-update');
$router->map('POST', '/admin/subcategories/[i:id]/delete', 'App\Controllers\Admin\ProductSubCategoryController@delete', 'product-subcategories-delete');
/**
 * Products
 * All controller methods
 */
$router->map('GET', '/admin/products/rejoy', '\App\Controllers\Admin\ProductController@show', 'products-show');
$router->map('GET', '/admin/products', '\App\Controllers\Admin\ProductController@create', 'products-create');
$router->map('GET', '/admin/products/category/[i:id]/subcategories', '\App\Controllers\Admin\ProductController@subcategories', 'products-subcategories');
$router->map('POST', '/admin/products', '\App\Controllers\Admin\ProductController@store', 'products-store');
/**
 *REJOY USERS
 */
$router->map('GET', '/rejoy/users', '\App\Controllers\Admin\UserController@show', 'rejoy-users');
/**
 *REJOY PAYMENTS
 */
$router->map('GET', '/rejoy/payments', '\App\Controllers\Admin\PaymentController@show', 'rejoy-payments');
/**
 *REJOY ORDER
 */
$router->map('GET', '/rejoy/orders', '\App\Controllers\Admin\OrderController@show', 'rejoy-orders');
/**
 * Edit update and delete product
 */
$router->map('GET', '/admin/products/[i:id]/edit', '\App\Controllers\Admin\ProductController@edit', 'products-edit');

$router->map('POST', '/admin/products/[i:id]/update', '\App\Controllers\Admin\ProductController@update', 'products-update');

$router->map('POST', '/admin/products/delete', '\App\Controllers\Admin\ProductController@delete', 'products-delete');
/**
 * Change product to aavailable and unailable
 */
$router->map('POST', '/admin/products/toavailable', '\App\Controllers\Admin\ProductController@toavailable', 'products-toavailable');

$router->map('POST', '/admin/products/tounavailable', '\App\Controllers\Admin\ProductController@tounavailable', 'products-tounavailabe');
/**
 * CartController with stripe
 */
$router->map('POST', '/cart/payment', '\App\Controllers\CartController@checkOut', 'checkout');
$router->map('POST', '/checkout/payment', '\App\Controllers\CartController@paypalCheckout', 'paypal-checkout');
/**
 * Admin Dashboard
 */
$router->map('GET', '/admin/dashboard', '\App\Controllers\Admin\DashboardController@show', 'dashboard');
$router->map('GET', '/dashboard/chart', '\App\Controllers\Admin\DashboardController@chart', 'dashboard-chart');