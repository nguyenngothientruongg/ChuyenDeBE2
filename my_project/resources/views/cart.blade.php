<!-- resources/views/cart/index.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Giỏ Hàng</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
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
                    data-id="{{ $cart->id }}"> <!-- Use the cart item's ID -->
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


                    <button class="delete-btn" onclick="confirmDelete({{ $cart->id }})">Xoá</button>
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
                        <div class="selected-product-list">
                            <!-- Danh sách sản phẩm sẽ được thêm vào đây -->
                        </div>

                        <div class="price-summary">
                     <p class="total-price">0000</p>
                            <!-- <p class="popup-product-price">Giá: 0 đ</p> -->
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
        <div id="successPopup" class="popup-overlay1">
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
                if (selectedProductListData.length > 0) {
                    // Lặp qua từng sản phẩm trong danh sách và xóa số lượng
                    selectedProductListData.forEach(product => {
                        deleteProductQuantity(product.id, product.quantity);
                    });

                    // Đóng popup thanh toán và hiển thị popup thành công
                    popup.style.display = 'none';
                    successPopup.style.display = 'flex';
                } else {
                    alert("Vui lòng chọn một sản phẩm để thanh toán.");
                }
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









            checkoutButton.addEventListener('click', function() {
    const selectedProducts = document.querySelectorAll('.product-checkbox:checked');
    let totalPrice = 0; // Tổng giá sản phẩm
    const selectedProductList = document.querySelector('.selected-product-list');
    selectedProductList.innerHTML = ''; // Xóa danh sách sản phẩm đã chọn trước đó

    // Khởi tạo lại danh sách sản phẩm đã chọn
    selectedProductListData = [];

    // Kiểm tra xem có sản phẩm nào được chọn không
    if (selectedProducts.length > 0) {
        // Lặp qua từng sản phẩm đã chọn
        selectedProducts.forEach(selectedProduct => {
            const productId = selectedProduct.getAttribute('data-id');
            const productName = selectedProduct.getAttribute('data-name');
            const productPrice = parseFloat(selectedProduct.getAttribute('data-price'));
            const productQuantity = parseInt(selectedProduct.getAttribute('data-quantity'));
            const productImage = selectedProduct.getAttribute('data-image');

            // Tính tổng giá sản phẩm
            const productTotalPrice = productQuantity * productPrice;
            totalPrice += productTotalPrice; // Cộng dồn vào tổng giá

            // Lưu sản phẩm vào danh sách đã chọn
            selectedProductListData.push({
                id: productId,
                quantity: productQuantity
            });

            // Tạo phần tử cho sản phẩm đã chọn
            const productItem = document.createElement('div');
            productItem.classList.add('selected-product');
            productItem.innerHTML = `
                <img src="${productImage}" alt="${productName}" class="summary-image popup-product-image">
                <div class="product-details">
                    <h3 class="popup-product-name">${productName}</h3>
                    <p class="popup-product-quantity">Số lượng: <span class="quantity">${productQuantity}</span></p>
                    <p class="popup-product-price">Giá: <span class="price">${productTotalPrice.toLocaleString()} đ</span></p>
                </div>
            `;

            selectedProductList.appendChild(productItem); // Thêm sản phẩm vào danh sách
        });

        // Cập nhật tổng giá vào giao diện
        const totalElement = document.querySelectorAll('.popup-product-price');
        totalElement.textContent = `Giá: ${totalPrice.toLocaleString()} đ`;

        // Hiển thị popup và khóa cuộn trang
        popup.style.display = 'block';
        document.body.style.overflow = 'hidden';

        // Cập nhật tổng thanh toán trong footer
        document.querySelector('.total-price').innerHTML =
            `Tổng thanh toán: ${totalPrice.toLocaleString()} VNĐ`;
    } else {
        alert("Vui lòng chọn ít nhất một sản phẩm để thanh toán.");
    }
});










            async function deleteProductQuantity(productId, quantity) {
                try {
                    const response = await fetch(`/cart/delete/${productId}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            quantity: quantity
                        })
                    });

                    if (response.ok) {
                        const productCard = document.querySelector(`input[data-id="${productId}"]`).closest('.product-card');
                        const qtyInput = productCard.querySelector('.qty-input');
                        const currentQuantity = parseInt(qtyInput.value, 10);

                        if (currentQuantity - quantity > 0) {
                            qtyInput.value = currentQuantity - quantity;
                        } else {
                            productCard.remove();
                        }
                    } else {
                        console.error('Error:', await response.json());
                        alert('Không thể xóa số lượng sản phẩm. Vui lòng thử lại sau.');
                    }
                } catch (error) {
                    console.error('Lỗi:', error);
                    alert('Đã xảy ra lỗi. Vui lòng thử lại sau.');
                }
            }

























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

        function updateQuantity(cartId, change) {
            const qtyInput = document.getElementById(`qty-${cartId}`);
            let currentQuantity = parseInt(qtyInput.value);

            // Cập nhật số lượng
            currentQuantity += change;

            // Đảm bảo số lượng không nhỏ hơn 1 và không lớn hơn 99
            if (currentQuantity < 1) {
                currentQuantity = 1;
            } else if (currentQuantity > 99) {
                currentQuantity = 99;
            }

            // Cập nhật giá trị trong input
            qtyInput.value = currentQuantity;

            // Cập nhật data-quantity của checkbox
            const productCheckbox = document.querySelector(`input[name="selected_products[]"][value="${cartId}"]`);
            if (productCheckbox) {
                productCheckbox.setAttribute('data-quantity', currentQuantity);
            }
        }


        function removeProduct(index) {
            const productCard = document.querySelector(`.product-card:nth-child(${index})`);
            if (productCard) {
                productCard.remove(); // Xóa thẻ sản phẩm
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Handle checkboxes
            const checkboxes = document.querySelectorAll('input[type="checkbox"]');
            checkboxes.forEach(checkbox => {
              //  checkbox.addEventListener('change', updateTotal);
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
                document.querySelector('.total-price').innerHTML =
                    `Tổng thanh toán: ${total.toLocaleString()} VNĐ`;
            }
        });



        function confirmDelete(productId) {
        // Hiển thị hộp thoại xác nhận
        const userConfirmed = confirm("Bạn có chắc chắn muốn xóa sản phẩm này khỏi giỏ hàng?");

        // Nếu người dùng xác nhận, gọi hàm xóa
        if (!userConfirmed) {
            return;
           
        }
        deleteCartItem(productId);
    }

    async function deleteCartItem(productId) {
        try {
            const response = await fetch(`/cart/delete/${productId}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });

            if (response.ok) {
                // Xóa sản phẩm khỏi giao diện
                document.querySelector(`input[data-id="${productId}"]`).closest('.product-card').remove();
                alert('Sản phẩm đã được xóa khỏi giỏ hàng.');
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
    </script>
</body>

</html>