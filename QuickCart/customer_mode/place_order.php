<?php
// include('../includes/connect.php'); // Connect file to MySQL - already did in common_function.php and including that file
include ('../functions/common_function.php'); // Common functions file

if (isset ($_GET['customer_id'])) {
    $cust_id = $_GET['customer_id'];
    $get_data = "SELECT * FROM customer WHERE customerID = $cust_id;";
    $result_get = mysqli_query($con, $get_data);
    $row_data = mysqli_fetch_assoc($result_get);
    $cust_id = $row_data["customerID"];
    $cust_fname = $row_data['first_name'];
    $cust_lname = $row_data['last_name'];
    $street = $row_data['address_street'];
    $city = $row_data['address_city'];
    $state = $row_data['address_state'];
    $pincode = $row_data['pincode'];
    // Check if last_name is null
    if ($cust_lname === null) {
        $cust_name = $cust_fname;
    } else {
        $cust_name = $cust_fname . ' ' . $cust_lname;
    }
    $totalPrice = total_cart($cust_id);
    $total_items = cart_total_item($cust_id);
    $cust_address = $street . ', ' . $city . ', ' . $state . ', Pincode - ' . $pincode;
    $order_location = $street . ', ' . $city;

    // update - SET safe mode OFF to update
    $safe_mode_query = "SET SQL_SAFE_UPDATES = 0;";
    $result_safe = mysqli_query($con, $safe_mode_query);
    if ($result_safe == 0) {
        echo "Couldn't turn safe mode OFF";
    }

    // Delivery Agent mapping - finding an agent i.e. 'Available' and then randomly choose one from it
    // Select all available agents
    $get_available_agents = "SELECT agentID FROM deliveryAgent WHERE availabilityStatus = 'Available';";
    $result_available_agents = mysqli_query($con, $get_available_agents);

    // What to do when no delivery agents available?? -- No agents available, try to order again later, SORRY message.

    if (mysqli_num_rows($result_available_agents) == 0) {
        $alert_message = "Sorry, no delivery agent available at the moment. Please try again later.";
        // Redirect to home page
        echo "<script>alert('$alert_message'); window.location.href = 'index.php?customer_id=$cust_id';</script>";
        exit(); // Stop further execution
    }

    // Check if there are any available agents
    if (mysqli_num_rows($result_available_agents) > 0) {
        // Fetch all available agent IDs
        $available_agent_ids = [];
        while ($row = mysqli_fetch_assoc($result_available_agents)) {
            $available_agent_ids[] = $row['agentID'];
        }

        // Choose a random agent ID from the available agents
        $random_agent_id = $available_agent_ids[array_rand($available_agent_ids)];
    }

    // making this assigned agent busy -- this is being done now by a trigger in busystatus_trigger.php
    // $update_agent = "UPDATE deliveryAgent SET availabilityStatus='Busy' WHERE agentID = '$random_agent_id';";
    // $result_update = mysqli_query($con, $update_agent);

    // Convert Cart to Order & OrderConsistsProduct
    $get_orders = "SELECT * FROM `order`;";
    $result_get = mysqli_query($con, $get_orders);
    $total_orders = mysqli_num_rows($result_get);
    $order_no = $total_orders + 1;
    // inserting into order table
    $insert_order = "INSERT INTO `order` (orderID, status, total_price, time, location, agentPayment, customerID, agentID) VALUES
    ('$order_no',DEFAULT, '$totalPrice', DEFAULT, '$order_location', DEFAULT, '$cust_id', '$random_agent_id');";
    $result_insert_order = mysqli_query($con, $insert_order);

    // inserting into OCP table
    $get_cart = "SELECT * FROM addsToCart where customerID = '$cust_id';";
    $result_get = mysqli_query($con, $get_cart);
    while ($row_get = mysqli_fetch_assoc($result_get)) {
        $productID = $row_get["productID"];
        $quantity = $row_get["quantity"];
        $insert_ocp = "INSERT INTO orderConsistsProduct (orderID, productID, quantity) VALUES
        ('$order_no', '$productID', '$quantity');";
        $result_insert_ocp = mysqli_query($con, $insert_ocp);
    }

    // update inventory
    $update_inv = "UPDATE product
    SET qty_bought = qty_bought + COALESCE((
        SELECT SUM(ocp.quantity)
        FROM orderConsistsProduct ocp
        WHERE ocp.productID = product.productID AND ocp.orderID = '$order_no'
    ), 0),
    stock = stock - COALESCE((
        SELECT SUM(ocp.quantity)
        FROM orderConsistsProduct ocp
        WHERE ocp.productID = product.productID  AND ocp.orderID = '$order_no'
     ), 0);";
    $result_update = mysqli_query($con, $update_inv);


    // update wallet of the customer
    $get_wallet = "SELECT * FROM wallet WHERE customerID = '$cust_id';";
    $result_update = mysqli_query($con, $get_wallet);
    $row_wallet = mysqli_fetch_assoc($result_update);
    $balance = $row_wallet['balance'];
    $new_balance = $balance - $totalPrice;
    $update_wallet = "UPDATE wallet SET balance = '$new_balance' WHERE customerID = '$cust_id';";
    $result_update = mysqli_query($con, $update_wallet);


    // emptying cart of the customer
    $delete_cart = "DELETE FROM addsToCart WHERE customerID = '$cust_id';";
    $result_delete_cart = mysqli_query($con, $delete_cart);

    // Redirect to view orders page
    $alert_message = "Order has been placed successfully. Your order is being packed! Thank you for using QuickCart!";
    // Redirect to home page
    echo "<script>alert('$alert_message'); window.location.href = 'profile_page.php?customer_id=$cust_id&view_orders';</script>";
    exit(); // Stop further execution
}
?>