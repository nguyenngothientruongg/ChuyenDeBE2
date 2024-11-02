<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    // Khai báo tên bảng nếu không tuân theo quy tắc đặt tên
    protected $table = 'carts';

    // Các thuộc tính có thể gán hàng loạt
    protected $fillable = [
        'product_id',
        'quantity',
        'user_id', // Giả định có trường này để xác định người dùng
    ];

    // Các mối quan hệ nếu cần
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
