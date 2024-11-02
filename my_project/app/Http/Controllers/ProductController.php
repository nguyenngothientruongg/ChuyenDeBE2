<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;

class ProductController extends Controller
{
    // Các phương thức của controller
    public function getListCart()
    {
        $carts = Cart::with('product')->get();
        return view('cart', compact('carts'));
    }

    public function show($id)
    {
        $product = Product::findOrFail($id); // Lấy sản phẩm theo ID
        return view('product.show', compact('product')); // Trả về view với sản phẩm
    }
}
