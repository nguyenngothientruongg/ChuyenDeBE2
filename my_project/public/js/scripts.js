document.addEventListener('DOMContentLoaded', function() {
    const checkoutButton = document.getElementById('checkoutButton');
    const cancelButton = document.getElementById('cancelButton');
    const popup = document.getElementById('productPopup');
    const closeButton = document.querySelector('.close-popup');
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
                popup.style.display = 'none'; // Hide popup
                successPopup.style.display = 'flex'; // Show success popup

                // Remove product from the interface
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

    checkoutButton.addEventListener('click', function() {
        const selectedProducts = document.querySelectorAll('.product-checkbox:checked');
        if (selectedProducts.length > 0) {
            // Logic to handle checkout
        } else {
            alert("Vui lòng chọn ít nhất một sản phẩm để thanh toán.");
        }
    });

    closeSuccessPopupButton.addEventListener('click', function() {
        successPopup.style.display = 'none';
    });

    // Additional JavaScript logic...
});

function updateQuantity(cartId, change) {
    const qtyInput = document.getElementById(`qty-${cartId}`);
    let currentQuantity = parseInt(qtyInput.value);

    currentQuantity += change;

    if (currentQuantity < 1) {
        currentQuantity = 1;
    } else if (currentQuantity > 99) {
        currentQuantity = 99;
    }

    qtyInput.value = currentQuantity;

    // Update data-quantity attribute
    const productCheckbox = document.querySelector(`input[name="selected_products[]"][value="${cartId}"]`);
    if (productCheckbox) {
        productCheckbox.setAttribute('data-quantity', currentQuantity);
    }
}
