<?php
if (isset ($_GET['dispatch_order']) and isset ($_GET['admin_id']) and isset ($_GET['order_id'])) {
    $admin_id = $_GET['admin_id'];
    $order_id = $_GET['order_id'];
    $order_query = "SELECT * FROM `order` WHERE status = 'Confirmed' AND orderID = '$order_id';";
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
}
?>

<div class="container mt-3">
    <h2 class="text-center">Dispatch Order</h2>
    <h5 class="w-50 m-auto my-4"> Order ID: <?php echo "$order_id"; ?></h5>
    <h5 class="w-50 m-auto my-4"> Customer Name: <?php echo "$cust_name"; ?></h5>
    <h5 class="w-50 m-auto my-4"> Order Cost: <?php echo "$order_price"; ?></h5>    
    <h5 class="w-50 m-auto my-4"> Delivered to Address: <?php echo "$order_location"; ?></h5>
    <h5 class="w-50 m-auto my-4"> Order Placed on: <?php echo "$order_time"; ?></h5>
    <h5 class="w-50 m-auto my-4"> Deliver Agent Name: <?php echo "$agent_name"; ?></h5>

    <form action="" method="post">
    <!-- deciding agent's payment for this particular delivery -->
    <div class="form-outline mb-4 w-50 m-auto">
            <label for="agentPrice" class="form-label">Agent Payment for this Delivery</label>
            <input type="number" name="agentPrice" id="agentPrice"  class="form-control"
                placeholder="Enter Amount (This will go directly to Delivery agent)" autocomplete="off" required="required" min="0" />
        </div>
        <div class="form-outline mb-4 w-50 m-auto">
            <input type="submit" name="submit_dispatch" class="btn btn-info mb-3 px-3" value="Dispatch Order">
        </div>
    </form>
</div>

<!-- updating order's details in the database -->
<?php
if (isset ($_POST['submit_dispatch'])) { 
    $agentPrice = $_POST['agentPrice'];

    $agentPayment = $agentPrice + $order_agentPayment;

    // update agent to table - SET safe mode OFF to update
    $safe_mode_query = "SET SQL_SAFE_UPDATES = 0;";
    $result_safe = mysqli_query($con, $safe_mode_query);
    if ($result_safe == 0) {
        echo "Couldn't turn safe mode OFF";
    }

    $update_order = "UPDATE `order` SET status = 'Packed and Shipped', agentPayment = '$agentPayment' WHERE orderID = '$order_id';";
    $result_update = mysqli_query($con, $update_order);
    if ($result_update) {
        echo "<script>alert('Order has been shipped successfully.'); window.location.href = 'index.php?admin_id=" . $admin_id . "&home';</script>";
    }
}
?>