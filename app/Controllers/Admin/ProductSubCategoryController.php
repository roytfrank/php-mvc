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

class ProductsubCategoryController extends BaseController {
	public function __construct() {
		if (!Role::middleware('56') && !Role::middleware('66')) {
			Redirect::to('/');
		}
	}
	public function store() {
		if (Request::has('post')) {
			$request = Request::get('post');
			// Session::unset('token');

			if (CSRFToken::validateToken($request->token, false)) {
				//we dont check unique because we can have the same sub category for 2 different categories
				$rules = ['name' => ['required' => true, 'maxLength' => 100, 'minLength' => 3]];
				validateRequest::abide($request, $rules);
				if (validateRequest::hasErrors()) {
					$errors = validateRequest::getErrors();
					header("HTTP/1.1 422 Unprocessable entity");
					echo json_encode($errors);
					exit;
				}
				//check is subcategory already exists for this category.
				$duplicateSub = SubCategory::where('name', $request->name)->where('category_id', $request->category_id)->exists();

				if ($duplicateSub) {
					$errors["name"] = ["SubCategory already exists"];
				}

				//check if there exists a category that we are creating a subcategory for.
				$category = Category::where('id', $request->category_id)->first();
				if (!$category) {
					$errors["name"] = ["No category exists for this subcategory"];
				}
				if (isset($errors)) {
					header("HTTP/1.1 422 Unprocessable entity");
					echo json_encode($errors);
					exit;
				}
				SubCategory::create([
					"name" => $request->name,
					"category_id" => $request->category_id,
					"category_name" => $category->name,
					"slug" => slug($request->name),
				]);
				echo json_encode((array("success" => "SubCategory created successfully")));
				exit;
			}
			die(header("HTTP/1.1 422 Token mismatch"));
		}
		die(header("HTTP/1.1 405 Invalid Request Method"));
	}

	public function update($id) {
		if (Request::has('post')) {
			$request = Request::get('post');
			// Session::unset('token');
			if (CSRFToken::validateToken($request->token, false)) {
				$rules = ['name' => ['required' => true, 'maxLength' => 100, 'minLength' => 3]];
				validateRequest::abide($request, $rules);
				if (validateRequest::hasErrors()) {
					$errors = validateRequest::getErrors();
					header("HTTP/1.1 422 Unprocessable entity");
					echo json_encode($errors);
					exit;
				}

				//check if there exists a category that we are creating a subcategory for.
				$category = Category::where('id', $request->category_id)->first();
				if (!$category) {
					$errors["name"] = ["This category does not exists"];
				}
				if (!empty($errors)) {

					header("HTTP/1.1 422 Unprocessable entity");
					echo json_encode($errors);
					exit;
				}
				SubCategory::where("id", $id)->update([
					"name" => $request->name,
					"category_id" => $request->category_id,
					"category_name" => $category->name,
				]);
				echo json_encode((array("success" => "SubCategory updated successfully")));
				exit;
			}

			die(header("HTTP/1.1 422 Token mismatch"));
		}
		die(header("HTTP/1.1 405 Invalid Request Method"));
	}

	public function delete($id) {
		if (Request::has('post')) {
			$request = Request::get('post');
			// Session::unset('token');
			if (CSRFToken::validateToken($request->token, false)) {

				$subcategory = SubCategory::where('id', $id)->exists();
				if ($subcategory) {
					SubCategory::destroy($id);
					echo json_encode(array("success" => "Category deleted successfully"));
					exit;
				}
				header("HTTP/1.1 422 Unprocessable entity");
				echo json_encode(array("Message" => "An error occurred contect support!"));
				exit;
			}
			die(header("HTTP/1.1 405 Illegal activity"));
		}
		die(header("HTTP/1.1 405 Invalid request"));
	}
}