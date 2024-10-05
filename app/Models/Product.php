<?php declare (strict_types = 1);

namespace App\Models;
use App\Models\Category;
use App\Models\Order;
use App\Models\SubCategory;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model {
	use softDeletes;

	protected $fillable = ['name', 'slug', 'price', 'saleprice', 'featured', 'image1', 'percentoff', 'save', 'quantity', 'saledate', 'status', 'description', 'user_id', 'category_id', 'sub_category_id'];
	protected $date = ['deleted_at'];

	public function transform($data) {
		$products = [];
		foreach ($data as $product) {
			array_push($products, [
				'id' => $product->id,
				'name' => $product->name,
				'slug' => $product->slug,
				'price' => $product->price,
				'saleprice' => $product->saleprice,
				'percentoff' => $product->percentoff,
				'featured' => $product->featured,
				'save' => $product->save,
				'image1' => $product->image1,
				'quantity' => $product->quantity,
				'saledate' => $product->saledate,
				'status' => $product->status,
				'description' => $product->description,
				'user_id' => $product->user_id,
				'category_id' => $product->category_id,
				'sub_category_id' => $product->sub_category_id,
				'created_at' => $product->created_at,
				'updated_at' => $product->updated_at,
				'deleted_at' => $product->deleted_at,
			]);
		}
		return $products;
	}

	public function User() {
		return $this->belongsTo(User::class);
	}

	public function Category() {
		return $this->belongsTo(Category::class);
	}

	public function SubCategory() {
		return $this->belongsTo(SubCategory::class);
	}

	public function Image() {
		return $this->hasOne(Image::class);
	}

	public function Orders() {
		return $this->hasMany(Order::class);
	}
}