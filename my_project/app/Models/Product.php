<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // Khai báo tên bảng nếu không tuân theo quy tắc đặt tên
    protected $table = 'products';

    // Các thuộc tính có thể gán hàng loạt
    protected $fillable = [
        'id_type',
        'name',
        'description',
        'price',
        'quantity',
        'image',
    ];

    // Các mối quan hệ nếu cần
    // Ví dụ: Mối quan hệ với Cart
    public function carts()
    {
        return $this->hasMany(Cart::class);
    }
}
