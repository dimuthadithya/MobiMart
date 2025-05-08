       <div class="cart-item">
           <div class="row align-items-center">
               <div class="col-md-2 col-4 mb-3 mb-md-0">
                   <img src="../assets/images/product-item2.jpg" alt="AirPods Pro" class="item-image">
               </div>
               <div class="col-md-4 col-8 mb-3 mb-md-0">
                   <h3 class="item-title"><?php echo $productName ?></h3>
                   <p class="item-variant mb-0"><?php echo $brandName ?></p>
               </div>
               <div class="col-md-2 col-4">
                   <div class="quantity-control">
                       <button class="quantity-btn">-</button>
                       <input type="text" class="quantity-input" value="1" readonly>
                       <button class="quantity-btn">+</button>
                   </div>
               </div>
               <div class="col-md-2 col-4 text-md-center">
                   <p class="item-price mb-0">LKR <?php echo $productPrice ?></p>
               </div>
               <div class="col-md-2 col-4 text-md-end">
                   <button class="remove-btn"><i class="fas fa-trash-alt me-1"></i> Remove</button>
               </div>
           </div>
       </div>