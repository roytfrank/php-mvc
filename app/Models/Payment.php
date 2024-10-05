<?php declare (strict_types = 1);

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model {
	use softDeletes;

	protected $fillable = ['user_id', 'order_num', 'amount', 'status', 'created_at', 'updated_at', 'deleted_at'];
	protected $date = ['deleted_at'];

	public function transform($data) {
		$payments = [];
		foreach ($data as $payment) {
			array_push($payments, [
				'id' => $payment->id,
				'user_id' => $payment->user_id,
				'order_num' => $payment->order_num,
				'amount' => $payment->amount,
				'status' => $payment->status,
				'created_at' => $payment->created_at,
				'updated_at' => $payment->updated_at,
				'deleted_at' => $payment->deleted_at,
			]);
		}
		return $payments;
	}
}