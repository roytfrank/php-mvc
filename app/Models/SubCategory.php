<?php declare (strict_types = 1);

namespace App\Models;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubCategory extends Model {
	use softDeletes;

	protected $fillable = ['name', 'slug', 'category_id', 'category_name'];
	protected $date = ['deleted_at'];

	public function transform($data) {
		$subCategories = [];
		foreach ($data as $subCategory) {
			array_push($subCategories, [
				'id' => $subCategory->id,
				'name' => $subCategory->name,
				'slug' => $subCategory->slug,
				'category_id' => $subCategory->category_id,
				'category_name' => $subCategory->category_name,
				'created_at' => $subCategory->created_at,
				'updated_at' => $subCategory->updated_at,
				'deleted_at' => $subCategory->deleted_at,
			]);
		}
		return $subCategories;
	}

	public function Category() {
		return $this->belongsTo(Category::class);
	}
	public function Products() {
		return $this->hasMany(Product::class);
	}
}