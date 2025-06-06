<tr>
    <td>
        <div class="d-flex align-items-center">
            <img src="../../assets/uploads/products/<?= htmlspecialchars($product['image_url']) ?>" class="product-img" alt="<?= htmlspecialchars($product['product_name']) ?>" width="40" height="40">
            <span><?php echo $productName ?></span>
        </div>
    </td>
    <td><?php echo $productBrandName ?></td>
    <td><?php echo $productPrice ?></td>
    <td><?php echo $productStock ?></td>
    <td>

        <?php
        if ($productStock == 0) { ?>
            <span class="badge bg-danger">
                <?php
                echo 'Out of Stock'; ?>
            </span>
        <?php
        } else if ($productStock <= 5) { ?>
            <span class="badge bg-warning">
                <?php
                echo 'Low Stock';
                ?> </span>
        <?php   } else {
            echo "<span class='badge bg-success'>In Stock</span>";
        } ?>


    </td>

</tr>