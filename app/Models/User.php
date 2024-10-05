<?php declare (strict_types = 1);

namespace App\Models;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model {
	use softDeletes;

	protected $fillable = ['name', 'email', 'username', 'password', 'verification_token', 'role_id', 'avatar', 'bio'];
	protected $date = ['deleted_at'];
	protected $hidden = ['password'];

	const ADMIN_USER = '56';
	const REGULAR_USER = '86';
	const EDITOR_USER = '66';

	public function isAdmin() {
		return $this->role_id == self::ADMIN_USER;
	}

	public function isEditor() {
		return $this->role_id == self::EDITOR_USER;
	}

	public function isRegular() {
		return $this->role_id == self::REGULAR_USER;
	}

	public function Products() {
		return $this->hasMany(Product::class);
	}

	public function Orders() {
		return $this->hasMany(Order::class);
	}

}