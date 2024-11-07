<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;

class ProductController extends Controller
{

    public function submitForm(Request $request)
    {
        // Validate the form data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|regex:/^[0-9]{10}$/', // Assuming phone number is 10 digits
            'address1' => 'required|string|max:255',
            'address2' => 'required|string|max:255',
            'payment_method' => 'required|string'
        ]);

        // Process the data if validation passes
        // Save or use the data as needed
    }
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
    // Trong Controller của bạn
public function showCart()
{

    $selectedProducts = Cart::with('product')->get(); 

    return view('cart.index', compact('selectedProducts'));
}

}
