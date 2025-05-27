document.addEventListener('DOMContentLoaded', function () {
  // Gallery Image Handling
  const thumbnails = document.querySelectorAll('.thumbnail-img');
  const mainImage = document.querySelector('.main-img');

  thumbnails.forEach((thumb) => {
    thumb.addEventListener('click', function () {
      mainImage.src = this.dataset.full;
      mainImage.alt = this.alt;
      thumbnails.forEach((t) => t.classList.remove('active'));
      this.classList.add('active');
    });
  });

  // Quantity Controls
  const quantityInput = document.querySelector(
    'input[type="text"].form-control'
  );
  const decrementBtn = quantityInput.previousElementSibling;
  const incrementBtn = quantityInput.nextElementSibling;
  const maxStock = parseInt(quantityInput.dataset.maxStock || '0');

  function updateQuantity(newValue) {
    newValue = Math.max(1, Math.min(newValue, maxStock));
    quantityInput.value = newValue;
  }

  decrementBtn.addEventListener('click', () => {
    updateQuantity(parseInt(quantityInput.value) - 1);
  });

  incrementBtn.addEventListener('click', () => {
    updateQuantity(parseInt(quantityInput.value) + 1);
  });

  quantityInput.addEventListener('change', function () {
    let value = parseInt(this.value);
    if (isNaN(value)) value = 1;
    updateQuantity(value);
  });

  // Color Selection
  const colorOptions = document.querySelectorAll('.color-option');
  colorOptions.forEach((option) => {
    option.addEventListener('click', function () {
      colorOptions.forEach((opt) => opt.classList.remove('active'));
      this.classList.add('active');
    });
  });

  // Storage Selection
  const storageOptions = document.querySelectorAll('.btn-outline-secondary');
  storageOptions.forEach((option) => {
    option.addEventListener('click', function () {
      storageOptions.forEach((opt) => opt.classList.remove('active'));
      this.classList.add('active');
    });
  });

  // Add to Cart Functionality
  const addToCartBtn = document.getElementById('addToCartBtn');
  const cartMessage = document.getElementById('cartMessage');

  function showMessage(message, isError = false) {
    cartMessage.textContent = message;
    cartMessage.classList.remove('d-none', 'alert-success', 'alert-danger');
    cartMessage.classList.add('alert-' + (isError ? 'danger' : 'success'));
    setTimeout(() => cartMessage.classList.add('d-none'), 3000);
  }

  addToCartBtn.addEventListener('click', function () {
    const quantity = parseInt(quantityInput.value);
    const color = document.querySelector('.color-option.active')?.dataset.color;
    const storage = document
      .querySelector('.btn-outline-secondary.active')
      ?.textContent.trim();

    if (!color || !storage) {
      showMessage('Please select color and storage options', true);
      return;
    }

    const formData = new FormData();
    formData.append('product_id', this.dataset.productId);
    formData.append('quantity', quantity);
    formData.append('color', color);
    formData.append('storage', storage);

    fetch('../controller/cart_process.php', {
      method: 'POST',
      body: formData
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.success) {
          showMessage('Product added to cart successfully!');
          if (data.cartCount) {
            const cartCount = document.querySelector('.cart-count');
            if (cartCount) cartCount.textContent = data.cartCount;
          }
        } else {
          showMessage(data.message || 'Failed to add product to cart', true);
        }
      })
      .catch((error) => {
        console.error('Error:', error);
        showMessage('An error occurred. Please try again.', true);
      });
  });
});
