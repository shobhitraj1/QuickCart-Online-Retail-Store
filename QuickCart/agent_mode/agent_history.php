<?php
$fetch_orders = "SELECT * FROM `order` WHERE agentID = $agent_id AND status = 'Delivered' ORDER BY orderID DESC;";
$result_fetch = mysqli_query($con, $fetch_orders);
$num_of_rows = mysqli_num_rows($result_fetch);
if ($num_of_rows == 0) {
    echo "<h2 class='text-center text-danger'> Deliver orders to view history! </h2>";
} else {
    ?>
    
    <h2 class="text-center text-success"><?php echo "$agent_name's Order History"; ?></h2>
    <table class="table table-bordered mt-5">
        <thead class="table-info text-center text-white">
            <tr>
                <th>Order ID</th>
                <th>Customer Name</th>
                <th>Delivered to Address</th>
                <th>Order Placed on</th>
                <th>Your Earning</th>
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
                $order_agentPayment = $fetch_row["agentPayment"];
                $order_status = $fetch_row["status"];
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
                        <?php echo $order_location; ?>
                    </td>
                    <td>
                        <?php echo $order_time; ?>
                    </td>
                    <td>
                        <?php echo "₹$order_agentPayment"; ?>
                    </td>
                    <td>
                        <?php echo $order_status; ?>
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
