<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;

class CartController extends Controller
{
    public function deleteProductQuantity(Request $request, $productId) {
        // Nhận số lượng cần xóa từ yêu cầu
        $quantityToDelete = $request->input('quantity', 1); // Mặc định là 1 nếu không có giá trị
    
        // Lấy sản phẩm từ giỏ hàng
        $cartItem = Cart::where('id', $productId)->first();
    
        if ($cartItem) {
            // Lấy sản phẩm từ bảng Product dựa trên product_id từ giỏ hàng
            $product = Product::find($cartItem->product_id);
    
            if ($product) {
                // Giảm số lượng trong kho của sản phẩm
                if ($product->quantity >= $quantityToDelete) {
                    $product->quantity -= $quantityToDelete;
                    $product->save();
                } else {
                    return response()->json(['error' => 'Số lượng trong kho không đủ'], 400);
                }
            }
    
            if ($cartItem->quantity > $quantityToDelete) {
                // Giảm số lượng sản phẩm trong giỏ hàng
                $cartItem->quantity -= $quantityToDelete;
                $cartItem->save();
    
                return response()->json(['message' => 'Số lượng sản phẩm đã được cập nhật'], 200);
            } else {
                // Xóa sản phẩm nếu số lượng trong giỏ hàng <= số lượng cần xóa
                $cartItem->delete();
    
                return response()->json(['message' => 'Sản phẩm đã bị xóa khỏi giỏ hàng'], 200);
                
            }

            
        }
    
        return response()->json(['error' => 'Không tìm thấy sản phẩm'], 404);
    }
    
}
