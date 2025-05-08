function addToCart(productId) {
  console.log(productId);
  $.ajax({
    url: '../../controller/cart_process.php',
    type: 'POST',
    dataType: 'json', // Expect JSON from the server
    data: { product_id: productId },
    success: function (response) {
      if (response.status === 'success') {
        alert('Product added to cart successfully!');
      } else {
        alert('Failed to add product to cart: ' + response.message);
      }
    },
    error: function () {
      alert('An error occurred while adding the product to the cart.');
    }
  });
}
