<?php declare (strict_types = 1);

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Image extends Model {
	use softDeletes;

	protected $fillable = ['image1', 'image2', 'image3', 'image4'];
	protected $date = ['deleted_at'];

	public function transform($data) {
		$images = [];
		foreach ($data as $image) {
			array_push($images, [
				'id' => $image->id,
				'image1' => $image->image1,
				'image2' => $image->image2,
				'image3' => $image->image3,
				'image4' => $image->image4,
				'created_at' => $image->created_at,
				'updated_at' => $image->updated_at,
				'deleted_at' => $image->deleted_at,
			]);
		}
		return $images;
	}

	public function Product() {
		return $this->hasOne(Product::class);
	}
}