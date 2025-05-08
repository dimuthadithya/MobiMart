<tr>
    <td>
        <div class="d-flex align-items-center">
            <img src="/api/placeholder/80/80" alt="iPhone" class="product-img me-2">
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
        } else if ($productStock > 10) { ?>
            <span class="badge bg-warning">
                <?php
                echo 'Low Stock';
                ?> </span>
        <?php   } else {
            echo "<span class='badge bg-success'>In Stock</span>";
        } ?>


    </td>

</tr>