<?php declare (strict_types = 1);

namespace App\Models;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model {
	use softDeletes;

	protected $fillable = ['product_id', 'user_id', 'customer', 'item_price', 'tax1', 'tax2', 'total', 'quantity', 'status', 'order_num', 'created_at', 'updated_at', 'deleted_at'];
	protected $date = ['deleted_at'];

	public function transform($data) {
		$orders = [];
		foreach ($data as $order) {
			array_push($orders, [
				'id' => $order->id,
				'product_id' => $order->product_id,
				'user_id' => $order->user_id,
				'item_price' => $order->item_price,
				'tax1' => $order->tax1,
				'tax2' => $order->tax2,
				'total' => $order->total,
				'quantity' => $order->quantity,
				'status' => $order->status,
				'order_num' => $order->order_num,
				'created_at' => $order->created_at,
				'updated_at' => $order->updated_at,
				'deleted_at' => $order->deleted_at,
			]);
		}
		return $orders;
	}

	public function Products() {
		return $this->hasMany(Product::class);
	}

	public function User() {
		return $this->belongsTo(User::class);
	}

}