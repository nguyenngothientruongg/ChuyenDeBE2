<!-- resources/views/cart/index.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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

        .popup-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1000;
        }

        .popup-content {
            position: relative;
            background: white;
            width: 90%;
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .close-popup {
            position: absolute;
            right: 20px;
            top: 20px;
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            color: #666;
        }

        .popup-title {
            font-size: 20px;
            margin-bottom: 20px;
            color: #333;
        }

        .popup-layout {
            display: flex;
            gap: 30px;
        }

        .form-section {
            flex: 1;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #333;
        }

        .form-input {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }

        .product-summary {
            width: 300px;
            padding: 20px;
            background: #f9f9f9;
            border-radius: 8px;
        }

        .selected-product {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
        }

        .summary-image {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 4px;
        }

        .product-details h3 {
            font-size: 16px;
            margin-bottom: 8px;
        }

        .price-summary {
            padding: 15px 0;
            border-top: 1px solid #ddd;
            border-bottom: 1px solid #ddd;
            margin-bottom: 20px;
        }

        .total-price {
            color: #666;
            margin-bottom: 5px;
        }

        .price-value {
            font-size: 18px;
            font-weight: bold;
            color: #ff4444;
        }

        .action-buttons {
            display: flex;
            gap: 10px;
        }

        .buy-now, .add-to-cart {
            flex: 1;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            transition: background 0.3s;
        }

        .buy-now {
            background: #ff4444;
            color: white;
        }

        .add-to-cart {
            background: #007bff;
            color: white;
        }

        .buy-now:hover {
            background: #cc0000;
        }

        .add-to-cart:hover {
            background: #0056b3;
        }

        .popup-overlay1 {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: none;
            justify-content: center;
            align-items: center;
        }

        .popup-content1 {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            width: 300px;
        }

        .close-success-popup {
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
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
                    <input type="checkbox" name="selected_products[]" value="{{ $cart->id }}" class="product-checkbox"
                            data-name="{{ $cart->product->name }}"
                            data-price="{{ $cart->product->price }}"
                            data-quantity="{{ $cart->quantity }}"
                            data-image="{{ $cart->product->image }}"
                            data-id="{{ $cart->id }}"
                        > <!-- Use the cart item's ID -->
                    <div class="product-content">
                        <div class="product-source">Apple.vn</div>
                        <img src="{{ $cart->product->image }}" alt="{{ $cart->product->name }}" class="product-image"> <!-- Use actual product image URL -->
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

        <!-- Add this popup HTML after your products-grid div -->
        <div id="productPopup" class="popup-overlay">
            <div class="popup-content">
                <button class="close-popup">&times;</button>
                <h2 class="popup-title">Thanh Toán</h2>
                
                <div class="popup-layout">
                    <div class="form-section">
                        <div class="form-group">
                            <label>Liên Hệ</label>
                            <input type="text" class="form-input" placeholder="Họ Và Tên">
                            <input type="tel" class="form-input" placeholder="Số Điện Thoại">
                        </div>

                        <div class="form-group">
                            <label>Địa Chỉ</label>
                            <input type="text" class="form-input" placeholder="Tỉnh/Thành phố, Quận/huyện, Phường/Xã">
                            <input type="text" class="form-input" placeholder="Tên đường, Số nhà">
                        </div>

                        <div class="form-group">
                            <label>Phương Thức Thanh Toán</label>
                            <select class="form-input">
                                <option>Thanh Toán Khi Nhận Hàng</option>
                                <option>Chuyển Khoản Ngân Hàng 24/7</option>
                            </select>
                        </div>
                    </div>

                    <div class="product-summary">
                        <div class="selected-product">
                            <img src="" alt="iPhone" class="summary-image popup-product-image">
                            <div class="product-details">
                                <h3 class="popup-product-name">Product Name</h3>
                                <p class="popup-product-quantity">Quantity: 1</p>
                            </div>
                        </div>
                        
                        <div class="price-summary">
                            <p class="total-price">Tổng Tiền Hàng</p>
                            <p class="popup-product-price">Price: 0 đ</p>
                        </div>

                        <div class="action-buttons">
                            <button id="cancelButton" class="buy-now">Hủy</button>
                            <button id="buyButton" class="add-to-cart">Đặt Hàng</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Success Popup HTML -->
        <div id="successPopup" class="popup-overlay1" >
            <div class="popup-content1">
                <h2>Đặt Hàng Thành Công!</h2>
                <br>
                <p>Cảm ơn bạn đã đặt hàng. Chúng tôi sẽ xử lý đơn hàng của bạn sớm nhất có thể.</p>
                <button class="close-success-popup">Đóng</button>
            </div>
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
            <button id="checkoutButton" class="checkout-btn">Thanh Toán</button>
        </div>
    </div>

    <script>

        document.addEventListener('DOMContentLoaded', function() {
            const checkoutButton = document.getElementById('checkoutButton');
            const cancelButton = document.getElementById('cancelButton');
            const popup = document.getElementById('productPopup');
            const closeButton = document.querySelector('.close-popup');
            const productNameElement = document.querySelector('.popup-product-name');
            const productQuantityElement = document.querySelector('.popup-product-quantity');
            const productPriceElement = document.querySelector('.popup-product-price');
            const productImageElement = document.querySelector('.popup-product-image');

            const buyButton = document.getElementById('buyButton');
            const successPopup = document.getElementById('successPopup');
            const closeSuccessPopupButton = document.querySelector('.close-success-popup');

            async function deleteProduct(productId) {
                try {
                    const response = await fetch(`/cart/delete/${productId}`, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    });

                    if (response.ok) {
                        console.log("1");
                        popup.style.display = 'none'; // Ẩn popup
                        successPopup.style.display = 'flex'; // Hiện popup thành công

                        // Xóa sản phẩm khỏi giao diện
                        document.querySelector(`input[data-id="${productId}"]`).closest('.product-card').remove();
                    } else {
                        const errorData = await response.json();
                        console.error('Error:', errorData);
                        alert('Không thể xóa sản phẩm. Vui lòng thử lại sau.');
                    }
                } catch (error) {
                    console.error('Lỗi:', error);
                    alert('Đã xảy ra lỗi. Vui lòng thử lại sau.');
                }
            }

            buyButton.addEventListener('click', function() {
                const selectedProducts = document.querySelectorAll('.product-checkbox:checked');
                const selectedProduct = selectedProducts[0];
                // Hide the main popup and show the success popup
                const productId = selectedProduct.getAttribute('data-id');
                // Remove the product element from the cart in the DOM
                deleteProduct(productId);
            });

            // Close the success popup when clicking the close button
            closeSuccessPopupButton.addEventListener('click', function() {
                successPopup.style.display = 'none';
                document.body.style.overflow = 'auto'; // Restore scrolling
            });

            // Close the success popup when clicking outside the content
            successPopup.addEventListener('click', function(e) {
                if (e.target === successPopup) {
                    successPopup.style.display = 'none';
                    document.body.style.overflow = 'auto';
                }
            });
            

            // Event listener for the "Thanh Toán" button
            checkoutButton.addEventListener('click', function() {
                const selectedProducts = document.querySelectorAll('.product-checkbox:checked');

                if (selectedProducts.length > 0) {
                    // Assuming only one product is selected at a time for simplicity
                    const selectedProduct = selectedProducts[0];
                    const productName = selectedProduct.getAttribute('data-name');
                    const productPrice = selectedProduct.getAttribute('data-price');
                    const productQuantity = selectedProduct.getAttribute('data-quantity');
                    const productImage = selectedProduct.getAttribute('data-image');

                    //Caculate total price
                    const totalPrice = productQuantity * productPrice

                    // Populate the popup with selected product data
                    productNameElement.textContent = productName;
                    productQuantityElement.textContent = `Số lượng: ${productQuantity}`;
                    productPriceElement.textContent = `${totalPrice.toLocaleString()} đ`;
                    productImageElement.src = productImage;

                    // Show the popup
                    popup.style.display = 'block';
                    document.body.style.overflow = 'hidden'; // Prevent background scrolling
                } else {
                    // Alert the user if no products are selected
                    alert("Vui lòng chọn ít nhất một sản phẩm để thanh toán.");
                }
            });

            // Close the popup when clicking the close button
            closeButton.addEventListener('click', function() {
                popup.style.display = 'none';
                document.body.style.overflow = 'auto'; // Restore scrolling
            });

            cancelButton.addEventListener('click', function() {
                popup.style.display = 'none';
                document.body.style.overflow = 'auto'; // Restore scrolling
            });

            // Close the popup when clicking outside the popup content
            popup.addEventListener('click', function(e) {
                if (e.target === popup) {
                    popup.style.display = 'none';
                    document.body.style.overflow = 'auto';
                }
            });
        });

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
                        const productPrice = checkbox.getAttribute('data-price');
                        const productQuantity = checkbox.getAttribute('data-quantity');

                        const totalPrice = productQuantity * productPrice
                        total += totalPrice; // Replace with actual price
                    }
                });
                document.querySelector('.total-info').innerHTML = 
                    `Vui lòng chọn sản phẩm !<br>Tổng thanh toán: ${total.toLocaleString()} đ`;
            }
        });

    </script>
</body>
</html>