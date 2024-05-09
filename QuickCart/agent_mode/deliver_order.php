<?php
if (isset ($_GET['deliver_order']) and isset ($_GET['agent_id']) and isset ($_GET['order_id'])) {
    $agent_id = $_GET['agent_id'];
    $order_id = $_GET['order_id'];

    $order_query = "SELECT * FROM `order` WHERE status = 'Packed and Shipped' AND orderID = '$order_id';";
    $order_result = mysqli_query($con, $order_query);
    $row = mysqli_fetch_assoc($order_result);
    $order_id = $row['orderID'];
    $order_location = $row['location'];
    $order_price = $row['total_price'];
    $order_time = $row['time'];
    $order_custID = $row['customerID'];
    $order_agentID = $row['agentID'];
    $order_status = $row['status'];
    $order_agentPayment = $row['agentPayment'];

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

    $get_Dwallet = "SELECT * FROM delivery_agent_wallet WHERE agentID = '$agent_id';";
    $result_Dwallet = mysqli_query($con, $get_Dwallet);
    $row_Dwallet = mysqli_fetch_assoc($result_Dwallet);
    $balance = $row_Dwallet["earning_balance"];
    $withdrawn = $row_Dwallet["earning_paid"];
    $total = $row_Dwallet["earning_total"];
    $transaction = $row_Dwallet["Transaction_history"];
}
?>

<div class="container mt-3">
    <h2 class="text-center">Deliver Order</h2>
    <h5 class="w-50 m-auto my-4"> Order ID:
        <?php echo "$order_id"; ?>
    </h5>
    <h5 class="w-50 m-auto my-4"> Customer Name:
        <?php echo "$cust_name"; ?>
    </h5>
    <h5 class="w-50 m-auto my-4"> Delivered to Address:
        <?php echo "$order_location"; ?>
    </h5>
    <h5 class="w-50 m-auto my-4"> Order Placed on:
        <?php echo "$order_time"; ?>
    </h5>
    <h5 class="w-50 m-auto my-4"> Your Earning:
        <?php echo "₹$order_agentPayment"; ?>
    </h5>

    <form action="" method="post">
        <div class="form-outline mb-4 w-50 m-auto">
            <input type="submit" name="submit_deliver" class="btn btn-info mb-3 px-3" value="Deliver Order">
        </div>
    </form>
</div>

<!-- updating order's details in the database -->
<?php
if (isset ($_POST['submit_deliver'])) {

    // update agent to table - SET safe mode OFF to update
    $safe_mode_query = "SET SQL_SAFE_UPDATES = 0;";
    $result_safe = mysqli_query($con, $safe_mode_query);
    if ($result_safe == 0) {
        echo "Couldn't turn safe mode OFF";
    }
    
    $update_agentStatus = "UPDATE deliveryAgent SET availabilityStatus = 'Available' WHERE agentID = '$agent_id';";
    $result_status = mysqli_query($con, $update_agentStatus);

    $new_balance = $balance + $order_agentPayment;
    $new_balance1 = number_format($new_balance, 2); 
    // number_format() - thousand separators with ',', hance changed , to ^
    $new_total = $total + $order_agentPayment;
    $new_total1 = number_format($new_total, 2);

    $current_date = date("d-m-Y");

    $trans_statement = "$current_date^ You earned ₹$order_agentPayment for successfully delivering order $order_id^ $new_balance1^ $withdrawn^ $new_total1";
    $new_Trans = $transaction . "| " . $trans_statement;

    $update_Dwallet = "UPDATE delivery_agent_wallet SET earning_balance = $new_balance, earning_total = $new_total, Transaction_history = '$new_Trans' WHERE agentID = '$agent_id';";
    $result_Dwallet = mysqli_query($con, $update_Dwallet);

    $update_order = "UPDATE `order` SET status = 'Delivered' WHERE orderID = '$order_id';";
    $result_update = mysqli_query($con, $update_order);
    if ($result_update and $result_status and $result_Dwallet) {
        echo "<script>alert('Order has been delivered successfully.'); window.location.href = 'index.php?agent_id=" . $agent_id . "&home';</script>";
    }
}
?>