<?php declare (strict_types = 1);

namespace App\Controllers\Admin;
use App\Classes\CSRFToken;
use App\Classes\Redirect;
use App\Classes\Request;
use App\Classes\Role;
use App\Classes\Session;
use App\Classes\UploadFile;
use App\Classes\validateImages;
use App\Classes\validateRequest;
use App\Controllers\BaseController;
use App\Models\Category;
use App\Models\Image;
use App\Models\Product;
use App\Models\SubCategory;
use App\Models\User;
use Carbon\Carbon;

class ProductController extends BaseController {

	public $categories;
	public $subcategories;
	public $users;
	private $table = "products";
	public $products;
	public $links;

	public function __construct() {
		if ((!Role::middleware('66')) && (!Role::middleware('56'))) {
			Redirect::to('/');
		}
		$this->categories = Category::all();
		$this->subcategories = SubCategory::all();
		$this->users = User::all();

		$total = Product::all()->count();
		$obj = new Product;
		list($this->products, $this->links) = paginate(8, $total, $this->table, $obj);
	}
	/**
	 * display all products
	 * @return object
	 */
	public function show() {
		$categories = $this->categories;
		$users = $this->users;
		$subcategories = $this->subcategories;
		$links = $this->links;
		$products = json_decode(json_encode($this->products));

		return view("admin/allproducts", ["products" => $products, "links" => $links, "categories" => $categories, "subcategories" => $subcategories, "users" => $users]);
	}
	/**
	 * Create product form
	 * @return object
	 */
	public function create() {
		$categories = $this->categories;
		return view('admin/products', compact("categories"));
	}
/**
 * Event listener subcategories for category
 * @param  $id category_id
 * @return  object
 */
	public function subcategories($id) {
		$subcategories = SubCategory::where('category_id', $id)->get();
		if ($subcategories) {
			echo json_encode($subcategories);
			exit;
		}
		echo json_encode(array("Message" => "No subcategory found"));
		exit;
	}
/**
 * Create product
 * @return mix
 */
	public function store() {
		if (Request::has('post')) {
			$request = Request::get('post');
			if (CSRFToken::validateToken($request->token, true)) {
				$file = Request::get('file');
				$rules = ['name' => ['required' => true, 'minLength' => 2, 'maxLength' => 255],
					'price' => ['required' => true, 'number' => true, 'maxLength' => 12],
					'featured' => ['required' => true, 'string' => true],
					'quantity' => ['required' => true, 'number' => true, 'maxLength' => 8],
					'saledate' => ['required' => true, 'maxLength' => 255],
					'description' => ['required' => true, 'minLength' => 10, 'maxLength' => 1677723],
					'category' => ['required' => true, 'maxLength' => 2147483648],
					'subcategory' => ['required' => true, 'maxLength' => 2147483648],
				];
				validateRequest::abide($request, $rules);
				if (validateRequest::hasErrors()) {
					$errors = validateRequest::getErrors();
				}
				$image1 = validateImages::requiredImage($file->image1->name, $file->image1->size, "image1");
				$image2 = validateImages::requiredImage($file->image2->name, $file->image2->size, "image2");
				$image3 = validateImages::validImage($file->image3->name, $file->image3->size, "image3");
				$image4 = validateImages::validImage($file->image4->name, $file->image4->size, "image4");
				if ($image1 !== "completed") {
					$file_errors = $image1;
				}
				if ($image2 != "completed") {
					$file_errors = $image2;
				}
				if ($image3 != "completed") {
					$file_errors = $image3;
				}
				if ($image4 != "completed") {
					$file_errors = $image4;
				}
				if (!empty($file_errors) || !empty($errors)) {

					empty($errors) ? $errors = [] : $errors = $errors;
					isset($file_errors) ? $errors = array_merge($file_errors, $errors) : $errors = $errors;
					$categories = $this->categories;
					return view('admin/products', compact('categories', 'errors'));
				}
				try {
					$ds = DIRECTORY_SEPARATOR;
					if (UploadFile::move($file->image1->tmp_name, "uploads{$ds}products", $file->image1->name)) {
						$image_path = UploadFile::path();
					}
					/**
					 *validate and save other image files
					 * @var $image2, $image3, $image4
					 */
					$return = validateImages::storeImages($image_path, $file->image2->name, $file->image3->name, $file->image4->name, $file->image2->tmp_name, $file->image3->tmp_name, $file->image4->tmp_name);

					$percentoff = ($request->price * ($request->percentoff / 100));
					$saleprice = $request->price - $percentoff;
					if ($image_path) {
						$path = $image_path;
						$product = Product::create([
							'name' => $request->name,
							'slug' => slug($request->name),
							'description' => $request->description,
							'price' => $request->price,
							'saleprice' => $saleprice,
							'percentoff' => $request->percentoff,
							'save' => $percentoff,
							'image1' => $path,
							'user_id' => 1,
							'category_id' => $request->category,
							'sub_category_id' => $request->subcategory,
							'quantity' => $request->quantity,
							'saledate' => $request->saledate,
							'featured' => $request->featured,
							'created_at' => Carbon::now("America/New_York"),
							'updated_at' => Carbon::now("America/New_York"),
						]);

						if ($product) {
							Request::refresh();
							$categories = $this->categories;
							$success = "Product created successfully";
							return view('admin/products', compact('categories', 'success'));
						}
						return view("errors/request");
					}
				} catch (\Exception $ex) {
					throw new \Exception("Error storing product " . $ex->getMessage());
				}
			}
			return view("errors/request");
		}
		return view("errors/request");
	}

/**
 * change product to available
 * @return mix
 */
	public function toavailable() {

		if (Request::has('post')) {
			$request = Request::get('post');
			if (isset($request->id) && filter_var($request->id, FILTER_VALIDATE_INT)) {
				$product = Product::where('id', $request->id)->first();
				$product->status = "Available";
				$product->save();
				echo json_encode(array("success" => "Status updated to Available"));
				exit;
			}
		}
		die("Unprocessable entity");
	}
/**
 * change product to unavailable
 * @return [type] [description]
 */
	public function tounavailable() {
		if (Request::has('post')) {
			$request = Request::get('post');
			if (isset($request->id) && filter_var($request->id, FILTER_VALIDATE_INT)) {
				$product = Product::where('id', $request->id)->first();
				$product->status = "Unavailable";
				$product->save();
				echo json_encode(array("success" => "Status updated to Unavailable"));
				exit;
			}
		}
		die("Unprocessable entity");
	}

/**
 * edit product form
 * we want the view to be create
 * @return
 */
	public function edit($id) {
		try {
			if ($id) {
				$product = Product::where('id', $id)->with(["Category", "subCategory"])->first();
				if (!empty($product)) {
					$categories = $this->categories;
					return view('admin/editproduct', ['product' => $product, 'categories' => $categories]);
				}
			}
		} catch (\Exception $ex) {
			throw new \Exception("Illegal activity with editing product");
		}
	}

/**
 * update product
 * @param $id
 * @return object
 */
	public function update($id) {
		if (Request::has('post')) {
			$request = Request::get('post');
			if (CSRFToken::validateToken($request->token, true)) {
				$file = Request::get('file');
				$product = Product::findOrFail($request->id);
				if (!$product) {
					throw new \Exception("Illegal request to update product");
				}
				if (isset($request->name)) {
					$rules = ['name' => ['minLength' => 3, 'maxLength' => 255, 'unique' => 'products']];
				}
				if (isset($request->price) || !empty($request->price)) {
					$rules = ['price' => ['number' => true, 'minLength' => 1, 'maxLength' => 10]];
				}
				if (isset($request->featured) || !empty($request->featured)) {
					$rules = ['featured' => ['string' => true]];
				}
				if (isset($request->quantity) || !empty($request->quantity)) {
					$rules = ['quantity' => ['number' => true, 'maxLength' => 8]];
				}
				if (isset($request->saledate) || !empty($request->saledate)) {
					$rules = ['saledate' => ['minLength' => 6, 'maxLength' => 255]];
				}
				if (isset($request->description) || !empty($request->description)) {
					$rules = ['description' => ['minLength' => 10, 'maxLength' => 1677723]];
				}
				if (isset($request->category) || !empty($request->category)) {
					$rules = ['category' => ['maxLength' => 2147483648]];
				}
				if (isset($request->category) || !empty($request->category)) {
					$rules = ['subcategory' => ['maxLength' => 2147483648]];
				}
				if (isset($rules)) {
					validateRequest::abide($request, $rules);
				}
				if (validateRequest::hasErrors()) {
					$errors = validateRequest::getErrors();
				}
				$image1 = validateImages::validImage($file->image1->name, $file->image1->size, "image1");
				$image2 = validateImages::validImage($file->image2->name, $file->image2->size, "image2");
				$image3 = validateImages::validImage($file->image3->name, $file->image3->size, "image3");
				$image4 = validateImages::validImage($file->image4->name, $file->image4->size, "image4");
				if ($image1 !== "completed") {
					$file_errors = $image1;
				}
				if ($image2 !== "completed") {
					$file_errors = $image2;
				}
				if ($image3 !== "completed") {
					$file_errors = $image3;
				}
				if ($image4 !== "completed") {
					$file_errors = $image4;
				}
				if (!empty($file_errors) || !empty($errors)) {

					empty($errors) ? $errors = [] : $errors = $errors;
					isset($file_errors) ? $errors = array_merge($file_errors, $errors) : $errors = $errors;
					return view('admin/editproduct', compact('errors'));
				}
				try {
					$ds = DIRECTORY_SEPARATOR;
					if (UploadFile::move($file->image1->tmp_name, "uploads{$ds}products", $file->image1->name)) {
						$image_path = UploadFile::path();
						unlink('/' . $product->image1);
					} else { $image_path = NULL;}
					/**
					 *validate and save other image files
					 * @var $image2, $image3, $image4
					 */
					$imageobj = Image::where('image1', $product->image1)->first();

					validateImages::updateImages($image_path, $file->image2->name, $file->image3->name, $file->image4->name, $file->image2->tmp_name, $file->image3->tmp_name, $file->image4->tmp_name, $imageobj);

					$percentoff = ($request->price * ($request->percentoff / 100));
					$saleprice = $request->price - $percentoff;

					$product->name = $request->name ? $request->name : $product->name;
					$product->description = $request->description ? $request->description : $product->description;
					$product->price = $request->price ? $request->price : $product->price;
					$product->saleprice = $saleprice ? $saleprice : $product->saleprice;
					$product->save = $percentoff ? $percentoff : $product->save;
					$product->percentoff = $request->percentoff ? $request->percentoff : $product->percentoff;
					$product->image1 = $image_path ? $image_path : $product->image1;
					$product->user_id = 1; //session admin
					$product->category_id = $request->category ? $request->category : $product->category_id;
					$product->sub_category_id = $request->subcategory ? $request->subcategory : $product->sub_category_id;
					$product->quantity = $request->quantity ? $request->quantity : $product->quantity;
					$product->saledate = $request->saledate ? $request->saledate : $product->saledate;
					$product->featured = $request->featured ? $request->featured : $product->featured;
					$product->updated_at = Carbon::now("America/New_York");
					$product->save();
					Session::add("success", "Product updated successfully");
					Redirect::to('/admin/products/rejoy');

				} catch (\Exception $ex) {
					throw new \Exception("Error updating post " . $ex->getMessage());
				}
			}
			return view("errors/token");
		}
		return view("errors/request");
	}

	public function delete() {
		if (Request::has('post')) {
			$request = Request::get('post');
			if (isset($request->id) && filter_var($request->id, FILTER_VALIDATE_INT)) {
				$product = Product::where('id', $request->id)->first();
				$product->delete();
				echo json_encode(array("success" => 56200));
				exit;
			}
		}
		die("Unprocessable entity");
	}
}