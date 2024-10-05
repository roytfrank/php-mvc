<?php declare (strict_types = 1);

namespace App\Models;
use App\Models\Product;
use App\Models\subCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model {
	use softDeletes;

	protected $fillable = ['name', 'slug'];
//we want eloquent to create created_at and updated_at times
	// public $timestamps = true;
	protected $date = ['deleted_at'];

	public function transform($data) {
		$categories = [];
		foreach ($data as $category) {
			array_push($categories, [
				'id' => $category->id,
				'name' => $category->name,
				'created_at' => $category->created_at,
				'updated_at' => $category->updated_at,
			]);
		}
		return $categories;
	}

	public function Products() {
		return $this->hasMany(Product::class);
	}

	public function SubCategories() {
		return $this->hasMany(Subcategory::class);
	}

}