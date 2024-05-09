<?php
$fetch_orders = "SELECT * FROM `order` WHERE customerID = $cust_id ORDER BY orderID DESC;";
$result_fetch = mysqli_query($con, $fetch_orders);
$num_of_rows = mysqli_num_rows($result_fetch);
if ($num_of_rows == 0) {
    echo "<h2 class='text-center text-danger'> You have not placed any order till now! </h2>";
} else {
    ?>

    <h2 class="text-center text-success">
        <?php echo "$cust_name's Order History"; ?>
    </h2>
    <table class="table table-bordered mt-5">
        <thead class="table-info text-center text-white">
            <tr>
                <th>Order ID</th>
                <th>Customer Name</th>
                <th>Order Cost</th>
                <th>Delivered to Address</th>
                <th>Order Placed on</th>
                <th>Delivery Agent</th>
                <th>Order Status</th>
            </tr>
        </thead>
        <tbody class="table-secondary text-white">
            <?php
            while ($fetch_row = mysqli_fetch_assoc($result_fetch)) {
                $order_id = $fetch_row["orderID"];
                $order_location = $fetch_row["location"];
                $order_price = $fetch_row["total_price"];
                $order_time = $fetch_row["time"];
                $order_custID = $fetch_row["customerID"];
                $order_status = $fetch_row["status"];
                $order_agentID = $fetch_row["agentID"];

                if ($order_status == "Confirmed") {
                    $current_status = "Order placed successfully. Your order is being packed!";
                } else if ($order_status == "Packed and Shipped") {
                    $current_status = "Order has been shipped. Agent is on the way to delivery your order.";
                } else if ($order_status == "Delivered") {
                    $current_status = "Order delivered successfully. Give Reviews in the 'Rate Order/Delivery' section.";
                }
                ?>
                <tr class='text-center align-middle'>
                    <td>
                        <?php echo $order_id; ?>
                    </td>
                    <td>
                        <?php
                        $get_cust = "SELECT * FROM customer WHERE customerID = $order_custID;";
                        $result_get = mysqli_query($con, $get_cust);
                        $row_cust = mysqli_fetch_assoc($result_get);
                        $cust_fname = $row_cust['first_name'];
                        $cust_lname = $row_cust['last_name'];
                        // Check if last_name is null
                        if ($cust_lname === null) {
                            $cust_name = $cust_fname;
                        } else {
                            $cust_name = $cust_fname . ' ' . $cust_lname;
                        }
                        echo $cust_name;
                        ?>
                    </td>
                    <td>
                        <?php echo "₹$order_price"; ?>
                    </td>
                    <td>
                        <?php echo $order_location; ?>
                    </td>
                    <td>
                        <?php echo $order_time; ?>
                    </td>
                    <td>
                        <?php
                        $get_agent = "SELECT * FROM deliveryAgent WHERE agentID = $order_agentID;";
                        $result_get = mysqli_query($con, $get_agent);
                        $row_agent = mysqli_fetch_assoc($result_get);
                        $agent_fname = $row_agent['first_name'];
                        $agent_lname = $row_agent['last_name'];
                        // Check if last_name is null
                        if ($agent_lname === null) {
                            $agent_name = $agent_fname;
                        } else {
                            $agent_name = $agent_fname . ' ' . $agent_lname;
                        }
                        echo "$agent_name";
                        ?>
                    </td>
                    <td>
                        <?php echo $current_status; ?>
                    </td>
                </tr>
                <?php
            }
            ?>
        </tbody>
    </table>
    <?php
}
?>