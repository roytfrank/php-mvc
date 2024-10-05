<?php declare (strict_types = 1);

namespace App\Controllers;
use App\Classes\CSRFToken;
use App\Classes\Request;
use App\Models\Image;
use App\Models\Product;

class IndexController extends BaseController {

	public $featuredProducts;
	public $products;
	public $categories;
	public $subcategories;
	public $images;
	private $table = "products";

	public function __construct() {
		$this->products = Product::where('status', 'Available')->orderBy('created_at', 'desc')->skip(0)->take(16)->get();
		$this->featuredProducts = Product::where('featured', 'Y')->inRandomOrder()->limit(6)->get();
	}

/**
 * home page display
 * @return mix
 */
	public function show() {
		return view('store/index');
	}

/**
 * To get featured products
 * @return object
 */
	public function featured() {
		$products = $this->products;
		$featuredProducts = $this->featuredProducts;
		echo json_encode(['featured' => $featuredProducts, 'products' => $products]);
		exit;
	}

/** get single product */
	public function getitem($id) {
		$id = $id[0]['action'];
		$data = explode('&', $id);
		$theId = $data[0];
		if (filter_var($theId, FILTER_VALIDATE_INT)) {
			$product = Product::where('id', $theId)->with(['Category', 'subCategory'])->first();
			$image = Image::where('image1', $product->image1)->first();

			if ($product) {
				$token = CSRFToken::token();
				return view('store/single', ['product' => $product, 'image' => $image, 'token' => $token]);
			}
			return view("errors/request");
		}
		return view("errors/request");
	}
/**
 * get request. validate params, get details
 * @return object
 */
	public function getproductdetails($id) {
		$id = $id[0]['id'];
		if (filter_var($id, FILTER_VALIDATE_INT)) {
			$product = Product::where('id', $id)->first();
			if ($product) {
				$similarProducts = Product::where('category_id', $product->category_id)->where('id', '!=', $id)->inRandomOrder()->limit(11)->get();
				echo json_encode(["similarproducts" => $similarProducts, 'count' => count($similarProducts)]);
				exit;
			}
			header("HTTP/1.1 422 Unprocessable entity first");
			echo json_encode(array("Error" => "unauthorized activity"));
			exit;
		}
		header("HTTP/1.1 422 Unprocessable entity here");
		echo json_encode(array("Error" => "unauthorized activity"));
		exit;
	}

/**
 * To load more similar products
 * @return [type] [description]
 */
	public function loadmore() {
		if (Request::has('post')) {
			$request = Request::get('post');
			if (CSRFToken::validateToken($request->token, false)) {
				CSRFToken::validateToken($request->token, true);
				$more_value = $request->count + $request->next;
				$moresimilarProducts = Product::where('category_id', $request->category_id)->where('id', '!=', $request->id)->inRandomOrder()->skip(0)->take($more_value)->get();
				if ($moresimilarProducts) {
					echo json_encode(["moresimilarproducts" => $moresimilarProducts, 'count' => count($moresimilarProducts)]);
					exit;
				}
				return;
			}
			header("HTTP/1.1 Unprocessable entity");
			echo json_encode(["message" => "Unauthorize request"]);
			exit;
		}
	}

}