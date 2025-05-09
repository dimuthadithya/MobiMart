<tr>
    <td><?php echo htmlspecialchars($orderId); ?></td>
    <td><?php echo htmlspecialchars($customerEmail); ?></td>
    <td><?php echo htmlspecialchars($orderDate); ?></td>
    <td><?php echo htmlspecialchars($totalAmount); ?></td>
    <td>
        <form action="./controller/update_delivery_status.php" method="POST" class="d-inline">
            <input type="hidden" name="order_id" value="<?php echo htmlspecialchars($orderId); ?>">
            <select class="form-select form-select-sm" aria-label="Delivery status" name="delivery_status">
                <option value="pending" <?php echo (strtolower($deliveryStatus) == 'pending') ? 'selected' : ''; ?>>Pending</option>
                <option value="processing" <?php echo (strtolower($deliveryStatus) == 'processing') ? 'selected' : ''; ?>>Shipped</option>
                <option value="completed" <?php echo (strtolower($deliveryStatus) == 'completed') ? 'selected' : ''; ?>>Delivered</option>
                <option value="cancelled" <?php echo (strtolower($deliveryStatus) == 'cancelled') ? 'selected' : ''; ?>>Failed</option>
            </select>
    </td>
    <td>
        <button type="submit" class="btn btn-sm btn-dark">Update</button>
        </form>
    </td>
</tr>