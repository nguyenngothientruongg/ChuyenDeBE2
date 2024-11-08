<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'id_type', 'description', 'price', 'promotion_price', 'image', 'new', 'quantity'];

    public function typeProduct()
    {
        return $this->belongsTo(TypeProduct::class, 'id_type'); // Use id_type as the foreign key
    }
}