function addToCart(productId) {
  // Show loading indicator
  showToast('Info', 'Adding product to cart...', 'info');

  const xhr = new XMLHttpRequest();
  xhr.open('POST', '../controller/cart_process.php', true);
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  xhr.responseType = 'json';

  xhr.onload = function () {
    if (xhr.status === 200) {
      let response;
      try {
        response = xhr.response;

        if (response.status === 'success') {
          // Show success toast
          showToast(
            'Success',
            'Product added to cart successfully!',
            'success'
          );

          // Update all cart count elements
          const cartCountElements = document.querySelectorAll('.cart-count');
          if (cartCountElements.length > 0) {
            cartCountElements.forEach((element) => {
              const currentCount = parseInt(element.textContent || '0', 10);
              element.textContent = currentCount + 1;
            });
          }

          // Optional: Update cart total if on cart page
          const cartTotal = document.querySelector(
            '.summary-total .total-amount'
          );
          if (cartTotal && response.cartTotal) {
            cartTotal.textContent = response.cartTotal;
          }
        } else {
          // Show error message from server
          showToast(
            'Error',
            response.message || 'Failed to add product to cart',
            'error'
          );
        }
      } catch (e) {
        console.error('Error parsing response:', e);
        showToast('Error', 'Invalid response from server', 'error');
      }
    } else {
      showToast('Error', 'Server error occurred', 'error');
    }
  };

  xhr.onerror = function () {
    showToast('Error', 'Network error occurred. Please try again.', 'error');
  };

  xhr.send('product_id=' + encodeURIComponent(productId));
}

// Helper function to show toasts/notifications
function showToast(title, message, type = 'info') {
  // Check for Bootstrap toast component
  if (typeof bootstrap !== 'undefined') {
    const toastEl = document.createElement('div');
    toastEl.className =
      'toast align-items-center text-white bg-' +
      (type === 'error' ? 'danger' : type) +
      ' border-0';
    toastEl.setAttribute('role', 'alert');
    toastEl.setAttribute('aria-live', 'assertive');
    toastEl.setAttribute('aria-atomic', 'true');

    toastEl.innerHTML = `
      <div class="d-flex">
        <div class="toast-body">
          <strong>${title}:</strong> ${message}
        </div>
        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
      </div>
    `;

    document.body.appendChild(toastEl);
    const toast = new bootstrap.Toast(toastEl, { delay: 3000 });
    toast.show();

    // Remove toast element after it's hidden
    toastEl.addEventListener('hidden.bs.toast', () => {
      toastEl.remove();
    });
  } else {
    // Fallback to alert if Bootstrap is not available
    alert(`${title}: ${message}`);
  }
}

function removeFromCart(productId) {
  // Show loading indicator
  showToast('Info', 'Removing product from cart...', 'info');

  const xhr = new XMLHttpRequest();
  xhr.open('POST', '../controller/cart_remove_process.php', true);
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  xhr.responseType = 'json';

  xhr.onload = function () {
    if (xhr.status === 200) {
      let response;
      try {
        response = xhr.response;

        if (response.status === 'success') {
          // Show success message
          showToast(
            'Success',
            'Product removed from cart successfully!',
            'success'
          );

          // Update cart count
          const cartCountElements = document.querySelectorAll('.cart-count');
          if (cartCountElements.length > 0) {
            cartCountElements.forEach((element) => {
              const currentCount = parseInt(element.textContent || '1', 10);
              element.textContent = Math.max(0, currentCount - 1);
            });
          }

          // Remove the cart item element if we're on the cart page
          const cartItem = document.querySelector(
            `[data-product-id="${productId}"]`
          );
          if (cartItem) {
            cartItem.remove();
          }

          // Update cart total if available
          if (response.cartTotal) {
            const cartTotal = document.querySelector(
              '.summary-total .total-amount'
            );
            if (cartTotal) {
              cartTotal.textContent = response.cartTotal;
            }
          }

          // If cart is empty, reload the page to show empty cart state
          const cartItems = document.querySelectorAll('.cart-item');
          if (cartItems.length === 0) {
            location.reload();
          }
        } else {
          showToast(
            'Error',
            response.message || 'Failed to remove product from cart',
            'error'
          );
        }
      } catch (e) {
        console.error('Error parsing response:', e);
        showToast('Error', 'Invalid response from server', 'error');
      }
    } else {
      showToast('Error', 'Server error occurred', 'error');
    }
  };

  xhr.onerror = function () {
    showToast(
      'Error',
      'Network error occurred while removing the product from the cart.',
      'error'
    );
  };

  xhr.send('remove_product_id=' + encodeURIComponent(productId));
}
