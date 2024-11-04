<!-- resources/views/cart/index.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ Hàng</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
        }

        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .cart-label {
            background: #4CAF50;
            color: white;
            padding: 8px 16px;
            border-radius: 4px;
            font-weight: bold;
        }

        .close-btn {
            background: none;
            border: none;
            font-size: 20px;
            cursor: pointer;
            color: #666;
        }

        .products-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }

        .product-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            display: flex;
            gap: 10px;
        }

        .product-content {
            flex: 1;
        }

        .product-source {
            color: #666;
            font-size: 14px;
            margin-bottom: 10px;
        }

        .product-image {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 4px;
        }

        .product-name {
            font-size: 14px;
            margin: 10px 0;
        }

        .delete-btn {
            background: #ff4444;
            color: white;
            border: none;
            padding: 8px;
            border-radius: 4px;
            width: 100%;
            cursor: pointer;
            font-size: 14px;
            transition: background 0.3s;
        }

        .delete-btn:hover {
            background: #cc0000;
        }

        .pagination {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin: 20px 0;
        }

        .page-btn {
            width: 32px;
            height: 32px;
            border: 1px solid #ddd;
            background: white;
            border-radius: 4px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .page-btn.active {
            background: #007bff;
            color: white;
            border-color: #007bff;
        }

        .footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }

        .total-info {
            font-size: 14px;
            color: #666;
        }

        .checkout-btn {
            background: #007bff;
            color: white;
            border: none;
            padding: 10px 24px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            transition: background 0.3s;
        }

        .checkout-btn:hover {
            background: #0056b3;
        }

        @media (max-width: 1024px) {
            .products-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media (max-width: 768px) {
            .products-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 480px) {
            .products-grid {
                grid-template-columns: 1fr;
            }
        }
        .quantity-controls {
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 10px 0;
        gap: 5px;
        }

        .qty-btn {
            width: 28px;
            height: 28px;
            border: 1px solid #ddd;
            background: white;
            border-radius: 4px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            color: #333;
            transition: all 0.2s;
        }

        .qty-btn:hover {
            background: #f0f0f0;
        }

        .qty-btn:active {
            background: #e0e0e0;
        }

        .qty-input {
            width: 40px;
            height: 28px;
            text-align: center;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
            padding: 0 5px;
        }

        /* Remove spinner arrows from number input */
        .qty-input::-webkit-inner-spin-button,
        .qty-input::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        .qty-input[type=number] {
            -moz-appearance: textfield;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div class="cart-label">Giỏ Hàng</div>
            <button class="close-btn">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <!-- Products Grid -->
        <div class="products-grid">
            @foreach($carts as $cart) <!-- Use the $cart variable here -->
                <div class="product-card">
                    <input type="checkbox" name="selected_products[]" value="{{ $cart->id }}"> <!-- Use the cart item's ID -->
                    <div class="product-content">
                        <div class="product-source">Apple.vn</div>
                        <img src="{{ $cart->product->image_url }}" alt="{{ $cart->product->name }}" class="product-image"> <!-- Use actual product image URL -->
                        <div class="product-name">{{ $cart->product->name }}</div>
                        
                        <!-- Quantity Controls -->
                        <div class="quantity-controls">
                            <button class="qty-btn decrease" onclick="updateQuantity({{ $cart->id }}, -1)">-</button>
                            <input type="number" class="qty-input" id="qty-{{ $cart->id }}" value="{{ $cart->quantity }}" min="1" max="99" readonly> <!-- Use actual quantity from the cart -->
                            <button class="qty-btn increase" onclick="updateQuantity({{ $cart->id }}, 1)">+</button>
                        </div>

                        <button class="delete-btn" onclick="deleteCartItem({id }})">Xoá</button> <!-- Add delete functionality -->
                    </div>
                </div>
            @endforeach
        </div>




        <!-- Pagination -->
        <div class="pagination">
            @foreach(range(1, 4) as $page)
            <button class="page-btn {{ $page === 1 ? 'active' : '' }}">
                {{ $page }}
            </button>
            @endforeach
        </div>
        

        <!-- Footer -->
        <div class="footer">
            <div class="total-info">
                Vui lòng chọn sản phẩm !<br>
                Tổng thanh toán: 0 đ
            </div>
            <button class="checkout-btn">Thanh Toán</button>
        </div>
    </div>

    <script>
        function updateQuantity(index, change) {
            const qtyInput = document.getElementById(`qty-${index}`);
            let currentQty = parseInt(qtyInput.value);
            currentQty += change;

            // Đảm bảo số lượng không dưới 1 và không vượt quá 99
            if (currentQty < 1) {
                currentQty = 1;
            } else if (currentQty > 99) {
                currentQty = 99;
            }

            qtyInput.value = currentQty;
        }

        function removeProduct(index) {
            const productCard = document.querySelector(`.product-card:nth-child(${index})`);
            if (productCard) {
                productCard.remove();  // Xóa thẻ sản phẩm
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Handle checkboxes
            const checkboxes = document.querySelectorAll('input[type="checkbox"]');
            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', updateTotal);
            });

            // Handle pagination
            const pageButtons = document.querySelectorAll('.page-btn');
            pageButtons.forEach(button => {
                button.addEventListener('click', function() {
                    pageButtons.forEach(btn => btn.classList.remove('active'));
                    this.classList.add('active');
                });
            });

            // Handle delete buttons
            const deleteButtons = document.querySelectorAll('.delete-btn');
            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const card = this.closest('.product-card');
                    card.remove();
                    updateTotal();
                });
            });

            function updateTotal() {
                // Add logic to calculate total based on selected items
                // This is a placeholder - implement actual calculation
                let total = 0;
                checkboxes.forEach(checkbox => {
                    if (checkbox.checked) {
                        // Add product price to total
                        total += 0; // Replace with actual price
                    }
                });
                document.querySelector('.total-info').innerHTML = 
                    `Vui lòng chọn sản phẩm !<br>Tổng thanh toán: ${total.toLocaleString()} đ`;
            }
        });
    </script>
</body>
</html>