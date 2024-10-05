<?php declare (strict_types = 1);

namespace App\Controllers\Admin;
use App\Classes\CSRFToken;
use App\Classes\Redirect;
use App\Classes\Request;
use App\Classes\Role;
use App\Classes\validateRequest;
use App\Controllers\BaseController;
use App\Models\Category;
use App\Models\SubCategory;

class ProductCategoryController extends BaseController {
	private $table = "categories";
	private $sub_table = "sub_categories";
	public $categories;
	public $links;
	public $subCategories;
	public $subCategories_links;

	public function __construct() {
		if (!Role::middleware('56') && !Role::middleware('66')) {
			Redirect::to('/');
		}
		$total = Category::all()->count();
		$obj = new Category;
		list($this->categories, $this->links) = paginate(5, $total, $this->table, $obj);
		//so we dont make a query in every request
		$subCategory_total = SubCategory::all()->count();
		$subObj = new SubCategory;
		list($this->subCategories, $this->subCategories_links) = paginate(8, $subCategory_total, $this->sub_table, $subObj);
	}
/**
 * show categories
 * @return $obj
 */
	public function show() {
		return view('admin/categories', ["categories" => $this->categories, "links" => $this->links,
			'subCategories' => $this->subCategories, 'subCategories_links' => $this->subCategories_links]);
	}
/**
 * create new category
 * @return categories
 */
	public function store() {
		if (Request::has('post')) {
			$request = Request::get('post');
			// Session::unset('token');
			if (CSRFToken::validateToken($request->token, true)) {
				$rules = ['name' => ['required' => true, 'maxLength' => 100, 'minLength' => 3, 'unique' => 'categories']];
				validateRequest::abide($request, $rules);
				if (validateRequest::hasErrors()) {
					$errors = validateRequest::getErrors();
					return view("admin/categories", ["categories" => $this->categories, 'links' => $this->links, 'subCategories' => $this->subCategories, 'subCategories_links' => $this->subCategories_links, "errors" => $errors]);
				}
				Category::create([
					"name" => $request->name,
					"slug" => slug($request->name),
				]);

				$total = Category::all()->count();
				$obj = new Category;

				list($this->categories, $this->links) = paginate(5, $total, $this->table, $obj);
				$message = "Category Created Successfully";
				return view("admin/categories", ["categories" => $this->categories, 'links' => $this->links, 'subCategories' => $this->subCategories, 'subCategories_links' => $this->subCategories_links, "message" => $message]);
			}
			return view("errors/token");
		}
		return view("errors/request");
	}

/**
 * update category
 * @param int $id category id
 */

	public function update($id) {
		if (Request::has('post')) {
			$request = Request::get('post');
			// Session::unset('token');
			if (CSRFToken::validateToken($request->token, false)) {
				$rules = ['name' => ['required' => true, 'maxLength' => 100, 'minLength' => 3, 'unique' => 'categories']];
				validateRequest::abide($request, $rules);
				if (validateRequest::hasErrors()) {
					$errors = validateRequest::getErrors();
					header("HTTP/1.1 422 Unprocessable Entity");
					echo json_encode($errors);
					exit;
				}
				Category::where('id', $id)->update([
					'name' => $request->name,
				]);
				echo json_encode(array("success" => "Update Successful"));
				exit;
			}
			return view("errors/token");
		}
		return view("errors/request");
	}

	/**
	 * Delete Category
	 * @param  int $id
	 */
	public function delete($id) {

		if (Request::has('post')) {
			$request = Request::get('post');

			if (CSRFToken::validateToken($request->token, false)) {
				$subcategories = SubCategory::where('category_id', $id)->get();
				if ($subcategories) {
					//when deleting category, we want to delete all entity associated with it
					foreach ($subcategories as $subcategory) {
						$subcategory->delete();
					}
					Category::destroy($id);
					echo json_encode(array("success" => "Category deleted successfully"));
					exit;
				}
				Category::destroy($id);
				echo json_encode(array("success" => "Category deleted successfully"));
				exit;
			}
			return view("errors/token");
		}
		return view("errors/request");
	}
}