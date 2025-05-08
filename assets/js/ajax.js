function addToCart(productId) {
  const xhr = new XMLHttpRequest();
  xhr.open('POST', '../../controller/cart_process.php', true);
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  xhr.responseType = 'json';

  xhr.onload = function () {
    if (xhr.status === 200) {
      const response = xhr.response;
      if (response.status === 'success') {
        alert('Product added to cart successfully!');
      } else {
        alert('Failed to add product to cart: ' + response.message);
      }
    } else {
      alert('An error occurred while adding the product to the cart.');
    }
  };

  xhr.onerror = function () {
    alert('An error occurred while adding the product to the cart.');
  };

  xhr.send('product_id=' + encodeURIComponent(productId));
}

function removeFromCart(productId) {
  const xhr = new XMLHttpRequest();
  xhr.open('POST', '../../controller/cart_remove_process.php', true);
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  xhr.responseType = 'json';

  xhr.onload = function () {
    if (xhr.status === 200) {
      const response = xhr.response;
      if (response.status === 'success') {
        alert('Product removed from cart successfully!');
        location.reload(); // Reload the page to reflect changes in the cart
      } else {
        alert('Failed to remove product from cart: ' + response.message);
      }
    } else {
      alert('An error occurred while removing the product from the cart.');
    }
  };

  xhr.onerror = function () {
    alert('An error occurred while removing the product from the cart.');
  };

  xhr.send('remove_product_id=' + encodeURIComponent(productId));
}

// Alternative modern version using fetch API
function addToCartFetch(productId) {
  fetch('../../controller/cart_process.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded'
    },
    body: 'product_id=' + encodeURIComponent(productId)
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.status === 'success') {
        alert('Product added to cart successfully!');
      } else {
        alert('Failed to add product to cart: ' + data.message);
      }
    })
    .catch((error) => {
      alert('An error occurred while adding the product to the cart.');
    });
}

function removeFromCart(productId) {
  const xhr = new XMLHttpRequest();
  xhr.open('POST', '../../controller/cart_remove_process.php', true);
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

  // Don't set responseType, let's handle parsing manually
  // xhr.responseType = 'json';

  xhr.onload = function () {
    if (xhr.status === 200) {
      // Log the raw response for debugging
      console.log('Raw server response:', xhr.responseText);

      let response;
      try {
        // Try to parse the response as JSON
        response = JSON.parse(xhr.responseText);

        if (response && typeof response === 'object') {
          if (response.status === 'success') {
            alert('Product removed from cart successfully!');
            location.reload(); // Reload the page to reflect changes in the cart
          } else {
            // Use default message if message is undefined
            const errorMsg = response.message || 'Unknown error occurred';
            alert('Failed to remove product from cart: ' + errorMsg);
          }
        } else {
          console.error('Invalid response structure:', response);
          alert(
            'Invalid response structure from server. Check console for details.'
          );
        }
      } catch (e) {
        console.error('Failed to parse JSON response:', e);
        console.error('Response text:', xhr.responseText);
        alert('Server returned invalid JSON. Check console for details.');
      }
    } else {
      console.error('HTTP Error:', xhr.status, xhr.statusText);
      alert('Server error: ' + xhr.status + ' ' + xhr.statusText);
    }
  };

  xhr.onerror = function () {
    console.error('Network error occurred');
    alert('Network error occurred while removing the product from the cart.');
  };

  // Log what we're sending for debugging
  console.log('Sending request with data:', 'remove_product_id=' + productId);
  xhr.send('remove_product_id=' + encodeURIComponent(productId));
}
