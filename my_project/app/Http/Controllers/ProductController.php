<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;

class ProductController extends Controller
{
    public function removeProduct($id)
    {
        $cartItem = Cart::find($id); // Tìm sản phẩm trong giỏ hàng bằng ID

        if ($cartItem) {
            $cartItem->delete(); // Xóa sản phẩm
            return response()->json(['success' => true]); // Trả về phản hồi JSON thành công
        }

        return response()->json(['success' => false], 404); // Nếu không tìm thấy, trả về 404 
    }

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
