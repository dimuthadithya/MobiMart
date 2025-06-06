<?php
$jsonData = $shippingAddress;
$data = json_decode($jsonData, true);
?>

<tr>
    <td>#<?php echo $order_id ?></td>
    <td><?php echo $orderDate ?></td>
    <td><?php echo $orderAmount ?></td>
    <td><?php echo $paymentMethod ?></td>
    <td><span class="order-status status-delivered"><?php echo $orderStatus ?></span></td>
    <td>
        <?php
        // Format the shipping address
        echo htmlspecialchars($data['full_name']) . '<br>';
        echo htmlspecialchars($data['street_address']) . " - ";
        echo htmlspecialchars($data['city']) . " - ";
        echo htmlspecialchars($data['district']) . '<br>';
        echo htmlspecialchars($data['phone']);
        ?>
    </td>
</tr>