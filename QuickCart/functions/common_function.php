<?php
include ('../includes/connect.php'); // Connect file to MySQL

// display all products on home-page
function display_products($cust_id)
{
    global $con;
    if (!isset ($_GET['cat'])) {
        $select_prod = "SELECT * FROM product;";
        $result_prod = mysqli_query($con, $select_prod);
        $num_of_rows = mysqli_num_rows($result_prod);
        if ($num_of_rows == 0) {
            echo "<h2 class = 'text-center text-danger'> No Products available in Store right now! Please visit again! </h2>";
        }
        while ($row_prod = mysqli_fetch_assoc($result_prod)) {
            $prod_id = $row_prod['productID'];
            $prod_name = $row_prod['name'];
            $prod_desc = $row_prod['description'];
            $prod_image = $row_prod['prod_image'];
            $prod_price = $row_prod['price'];

            // // Truncate description to a fixed number of characters
            // $truncated_desc = substr($prod_desc, 0, 100); // Adjust the number of characters as needed

            echo "<div class='col-md-4 mb-2'>
                            <div class='card h-100'> <!-- Set a fixed height for the card -->
                                <img src='../images/$prod_image' class='card-img-top' alt='$prod_name image'>
                                <div class='card-body d-flex flex-column'> <!-- Use flex column to align content -->
                                    <h5 class='card-title'>$prod_name</h5>
                                    <p class='card-text flex-grow-1'>$prod_desc</p> <!-- Truncated description -->
                                    <div class='row justify-content-between align-items-center'> <!-- Align items horizontally -->
                                        <div class='col'>
                                            <p class='card-text'>Price: ₹$prod_price</p>
                                        </div>
                                        <div class='col-auto'>
                                            <a href='index.php?add_to_cart=$prod_id&customer_id=$cust_id' class='btn btn-primary'>Add to Cart</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>";
        }
    }
}

// display unique category products only
function display_cat_products($cust_id)
{
    global $con;
    if (isset ($_GET['cat'])) {
        $cat_id = $_GET['cat'];
        $select_prod = "SELECT * FROM product where categoryID = $cat_id;";
        $result_prod = mysqli_query($con, $select_prod);
        $num_of_rows = mysqli_num_rows($result_prod);
        if ($num_of_rows == 0) {
            echo "<h2 class = 'text-center text-danger'> No Products available in this Category! </h2>";
        }
        while ($row_prod = mysqli_fetch_assoc($result_prod)) {
            $prod_id = $row_prod['productID'];
            $prod_name = $row_prod['name'];
            $prod_desc = $row_prod['description'];
            $prod_image = $row_prod['prod_image'];
            $prod_price = $row_prod['price'];

            // // Truncate description to a fixed number of characters
            // $truncated_desc = substr($prod_desc, 0, 100); // Adjust the number of characters as needed

            echo "<div class='col-md-4 mb-2'>
                                <div class='card h-100'> <!-- Set a fixed height for the card -->
                                    <img src='../images/$prod_image' class='card-img-top' alt='$prod_name image'>
                                    <div class='card-body d-flex flex-column'> <!-- Use flex column to align content -->
                                        <h5 class='card-title'>$prod_name</h5>
                                        <p class='card-text flex-grow-1'>$prod_desc</p> <!-- Truncated description -->
                                        <div class='row justify-content-between align-items-center'> <!-- Align items horizontally -->
                                            <div class='col'>
                                                <p class='card-text'>Price: ₹$prod_price</p>
                                            </div>
                                            <div class='col-auto'>
                                                <a href='index.php?add_to_cart=$prod_id&customer_id=$cust_id' class='btn btn-primary'>Add to Cart</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>";
        }
    }
}

// display categories on side-nav
function display_categories($cust_id)
{
    global $con;
    $select_cat = "SELECT * FROM productCategory;";
    $cat_result = mysqli_query($con, $select_cat);
    while ($row = mysqli_fetch_assoc($cat_result)) {
        $cat_name = $row["name"];
        $cat_id = $row["categoryID"];
        echo "<li class='nav-item'>
                            <a href='index.php?customer_id=$cust_id&cat=$cat_id' class='nav-link text-light'>$cat_name</a>
                        </li>";
    }

}

// displaying products searched
function search_products($cust_id)
{
    global $con;
    if (isset ($_GET['search_data'])) {
        $searched_word = $_GET['search_bar'];
        $select_prod = "SELECT * FROM product WHERE name LIKE '%$searched_word%' AND stock>0;";
        $result_prod = mysqli_query($con, $select_prod);
        $num_of_rows = mysqli_num_rows($result_prod);
        if ($num_of_rows == 0) {
            echo "<h2 class = 'text-center text-danger'> No results match! </h2>";
        }
        while ($row_prod = mysqli_fetch_assoc($result_prod)) {
            $prod_id = $row_prod['productID'];
            $prod_name = $row_prod['name'];
            $prod_desc = $row_prod['description'];
            $prod_image = $row_prod['prod_image'];
            $prod_price = $row_prod['price'];

            // // Truncate description to a fixed number of characters
            // $truncated_desc = substr($prod_desc, 0, 100); // Adjust the number of characters as needed

            echo "<div class='col-md-4 mb-2'>
                                <div class='card h-100'> <!-- Set a fixed height for the card -->
                                    <img src='../images/$prod_image' class='card-img-top' alt='$prod_name image'>
                                    <div class='card-body d-flex flex-column'> <!-- Use flex column to align content -->
                                        <h5 class='card-title'>$prod_name</h5>
                                        <p class='card-text flex-grow-1'>$prod_desc</p> <!-- Truncated description -->
                                        <div class='row justify-content-between align-items-center'> <!-- Align items horizontally -->
                                            <div class='col'>
                                                <p class='card-text'>Price: ₹$prod_price</p>
                                            </div>
                                            <div class='col-auto'>
                                                <a href='index.php?add_to_cart=$prod_id&customer_id=$cust_id' class='btn btn-primary'>Add to Cart</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>";
        }
    }
}

// function for adding products to cart
function add_to_Cart($cust_id)
{
    if (isset ($_GET['add_to_cart'])) {
        global $con;
        $prod_id = $_GET['add_to_cart'];
        $user_id = $cust_id; // auto set customer id
        $select_cart = "SELECT * FROM addstocart WHERE productID = '$prod_id' AND customerID = '$user_id'";
        $result_query = mysqli_query($con, $select_cart);
        $num_of_rows = mysqli_num_rows($result_query);
        // echo "check if the function is called!";
        if ($num_of_rows > 0) {
            echo "<script> alert('Product already added to cart!') </script>";
            echo "<script> window.open('index.php?customer_id=$cust_id', '_self') </script>";
        } else {
            $insert_cart = "INSERT INTO addstocart (customerID, productID, quantity) VALUES ('$user_id', '$prod_id', 1)";
            $result_cart = mysqli_query($con, $insert_cart);
            if ($result_cart) {
                echo "<script>alert('Product added to cart successfully!')</script>";
                echo "<script>window.open('index.php?customer_id=$cust_id', '_self')</script>";
            }
        }
    }
}

// function1 to get cart item numbers
function cart_item($cust_id)
{
    global $con;
    $user_id = $cust_id; // auto set customer id
    $select_cart = "SELECT * FROM addstocart WHERE customerID = '$user_id'";
    $result_cart = mysqli_query($con, $select_cart);
    $count_items = mysqli_num_rows($result_cart);
    echo $count_items;

}

// function2 to get cart item numbers
function cart_total_item($cust_id)
{
    global $con;
    $user_id = $cust_id; // auto set customer id
    $select_cart = "SELECT * FROM addstocart WHERE customerID = '$user_id'";
    $result_cart = mysqli_query($con, $select_cart);
    $count_items = mysqli_num_rows($result_cart);
    return $count_items;

}

//function to get total price in cart
function total_cart($cust_id)
{
    global $con;
    $user_id = $cust_id; // auto set customer id
    $total = 0;
    $select_cart = "SELECT * FROM addstocart WHERE customerID = '$user_id'";
    $result_cart = mysqli_query($con, $select_cart);
    while ($row_cart = mysqli_fetch_assoc($result_cart)) {
        $prod_id = $row_cart['productID'];
        $prod_qty = $row_cart['quantity'];
        $select_prod = "SELECT * FROM product WHERE productID = '$prod_id'";
        $result_prod = mysqli_query($con, $select_prod);
        $row_prod = mysqli_fetch_assoc($result_prod);
        $prod_price = $row_prod['price'];
        $total += $prod_price * $prod_qty;

    }
    return $total;

}

// function to remove products from cart
function remove_cart($cust_id)
{
    if (isset ($_GET['remove_cart'])) {
        global $con;
        $prod_id = $_GET['remove_cart'];
        $user_id = $cust_id; // auto set customer id
        $delete_cart = "DELETE FROM addstocart WHERE productID = '$prod_id' AND customerID = '$user_id'";
        $result_cart = mysqli_query($con, $delete_cart);
        if ($result_cart) {
            echo "<script>alert('Product removed from cart successfully!')</script>";
            echo "<script>window.open('index.php?customer_id=$cust_id', '_self')</script>";
        }
    }

}

// function to show the cart as dropdown
function show_cart($cust_id)
{
    global $con;
    $user_id = $cust_id; // auto set customer id
    $select_cart = "SELECT * FROM addstocart WHERE customerID = '$user_id'";
    $result_cart = mysqli_query($con, $select_cart);
    $num_of_rows = mysqli_num_rows($result_cart);
    if ($num_of_rows == 0) {
        echo "<h2 class='text-center text-danger'>No Products available in Cart!</h2>";
    }
    while ($row_cart = mysqli_fetch_assoc($result_cart)) {
        $prod_id = $row_cart['productID'];
        $prod_qty = $row_cart['quantity'];
        $select_prod = "SELECT * FROM product WHERE productID = '$prod_id'";
        $result_prod = mysqli_query($con, $select_prod);
        while ($row_prod = mysqli_fetch_assoc($result_prod)) {
            $prod_name = $row_prod['name'];
            $prod_image = $row_prod['prod_image'];
            $prod_price = $row_prod['price'];
            $total_price = $prod_price * $prod_qty;
            echo "<div class='card'>
                <div class='card-body'>
                    <div class='row align-items-center'>
                        <div class='col-md-4'>
                            <img src='../images/$prod_image' class='img-fluid' alt='$prod_name image'>
                        </div>
                        <div class='col-md-8'>
                            <h6>$prod_name</h6>
                            <p>Price: ₹$prod_price</p>
                        </div>
                    </div>
                    <div class='row align-items-center mt-1'>
                        <div class='col-md-6'>
                            <input type='number' class='form-control text-center' value='$prod_qty'>
                        </div>
                        <div class='col-md-6'>
                            <div class='row justify-content-center'>
                                <div class='col-md-6'>
                                    <a href='index.php?update_qnt=$prod_id&update_val=-1&customer_id=$cust_id' class='btn btn-dark btn-sm rounded-circle'>−</a>
                                </div> 
                                <div class='col-md-6'>
                                    <a href='index.php?update_qnt=$prod_id&update_val=1&customer_id=$cust_id' class='btn btn-dark btn-sm rounded-circle'>+</a>
                                </div>
                            </div>
                            
                        </div>
                        <a href='index.php?remove_cart=$prod_id&customer_id=$cust_id' class='btn btn-danger btn-sm mt-2'>Remove</a>
                    </div>
                </div>
            </div>";
        }
    }
}
function wallet($cust_id)
{
    global $con;
    $user_id = $cust_id; // auto set customer id
    $select_wallet = "SELECT * FROM wallet where customerID = '$user_id'";
    $result_wallet = mysqli_query($con, $select_wallet);
    $row_wallet = mysqli_fetch_assoc($result_wallet);
    $wallet = $row_wallet['balance'];
    return $wallet;
}

function updateCart($cust_id)
{
    if (isset ($_GET['update_qnt'])) {
        global $con;
        $prod_id = $_GET['update_qnt'];
        $update_val = $_GET['update_val'];
        $user_id = $cust_id; // auto set customer id
        $select_cart = "SELECT * FROM addstocart WHERE productID = '$prod_id' AND customerID = '$user_id'";
        $result_cart = mysqli_query($con, $select_cart);
        $row_cart = mysqli_fetch_assoc($result_cart);
        $prod_qty = $row_cart['quantity'];
        $new_qty = $prod_qty + $update_val;
        if ($new_qty < 1) {
            echo "<script>alert('Quantity cannot be less than 1! Click on Remove to remove the product from cart.')</script>";
            echo "<script>window.open('index.php?customer_id=$cust_id', '_self')</script>";
        }
        $update_cart = "UPDATE addstocart SET quantity = '$new_qty' WHERE productID = '$prod_id' AND customerID = '$user_id'";
        $result_update = mysqli_query($con, $update_cart);
        if ($result_update) {
            echo "<script>alert('Cart updated successfully!')</script>";
            echo "<script>window.open('index.php?customer_id=$cust_id', '_self')</script>";
        }
    }
}

// function to check if order within stock
function check_stock($cust_id)
{
    global $con;
    // Query to fetch products added by the customer along with their quantities
    $stock_query = "SELECT a.productID, a.quantity, p.name, p.stock FROM addsToCart a INNER JOIN product p ON a.productID = p.productID WHERE a.customerID = $cust_id;";
    $stock_result = mysqli_query($con, $stock_query);
    if (mysqli_num_rows($stock_result) > 0) {
        // Loop for each product
        while ($row = mysqli_fetch_assoc($stock_result)) {
            if ($row['quantity'] > $row['stock']) {
                // Quantity exceeds stock, return false
                return $row['name'];
            }
        }
    }
    // All products have sufficient stock, return true
    return true;
}

// Function for admin to view pending orders & Dispatch them
function viewPendingOrders($admin_id)
{
    global $con;
    $order_query = "SELECT * FROM `order` WHERE status = 'Confirmed' ORDER BY orderID DESC;";
    $order_result = mysqli_query($con, $order_query);
    if (mysqli_num_rows($order_result) == 0) {
        echo "<h2 class='text-center text-success'> There are NO Pending Orders in the Store right now! </h2>";
    } else {
        ?>
        <div class="container my-3">
            <h2 class='text-center text-danger my-3'>Pending Orders</h2>
            <table class='table table-bordered mt-4'>
                <thead class='table-info text-center text-white'>
                    <tr>
                        <th>Order ID</th>
                        <th>Customer Name</th>
                        <th>Order Cost</th>
                        <th>Delivered to Address</th>
                        <th>Order Placed on</th>
                        <th>Delivery Agent Name</th>
                        <th>Pack and Dispatch Order</th>
                    </tr>
                </thead>
                <tbody class='table-secondary text-white'>
                    <?php
                    while ($row = mysqli_fetch_assoc($order_result)) {
                        $order_id = $row['orderID'];
                        $order_location = $row['location'];
                        $order_price = $row['total_price'];
                        $order_time = $row['time'];
                        $order_custID = $row['customerID'];
                        $order_agentID = $row['agentID'];
                        $order_status = $row['status'];
                        $order_agentPayment = $row['agentPayment'];
                        ?>
                        <tr class='text-center align-middle'>
                            <td>
                                <?php echo "$order_id"; ?>
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
                                echo "$cust_name";
                                ?>
                            </td>
                            <td>
                                <?php echo "₹$order_price"; ?>
                            </td>
                            <td>
                                <?php echo "$order_location"; ?>
                            </td>
                            <td>
                                <?php echo "$order_time"; ?>
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
                                <form
                                    action='index.php?admin_id=<?php echo "$admin_id"; ?>&dispatch_order&order_id=<?php echo "$order_id"; ?>'
                                    method="post">
                                    <button type="submit" class="btn btn-info my-1 px-3" name="ship_order">Dispatch Order</button>
                                </form>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <?php
    }
}

// Function for agent to view pending orders & deliver them
function viewDeliveringOrders($agent_id)
{
    global $con;
    $order_query = "SELECT * FROM `order` WHERE status = 'Confirmed' AND agentID = '$agent_id' ORDER BY orderID DESC;";
    $result_get = mysqli_query($con, $order_query);
    if (mysqli_num_rows($result_get) != 0) {
        echo "<h2 class='text-center text-danger'> You have been assigned an order to deliver! Kindly reach the store and wait there while the order is being packed. </h2>";
    } else {
        $order_query = "SELECT * FROM `order` WHERE status = 'Packed and Shipped' AND agentID = '$agent_id' ORDER BY orderID DESC;";
        $order_result = mysqli_query($con, $order_query);
        if (mysqli_num_rows($order_result) == 0) {
            echo "<h2 class='text-center text-success'> There are NO Orders that you have to deliver right now! </h2>";
        } else {
            ?>
            <div class="container my-3">
                <h2 class='text-center text-danger my-3'>Deliver Orders</h2>
                <table class='table table-bordered mt-4'>
                    <thead class='table-info text-center text-white'>
                        <tr>
                            <th>Order ID</th>
                            <th>Customer Name</th>
                            <th>Delivered to Address</th>
                            <th>Order Placed on</th>
                            <th>Your Earning</th>
                            <th>Deliver Order</th>
                        </tr>
                    </thead>
                    <tbody class='table-secondary text-white'>
                        <?php
                        while ($row = mysqli_fetch_assoc($order_result)) {
                            $order_id = $row['orderID'];
                            $order_location = $row['location'];
                            $order_price = $row['total_price'];
                            $order_time = $row['time'];
                            $order_custID = $row['customerID'];
                            $order_agentID = $row['agentID'];
                            $order_status = $row['status'];
                            $order_agentPayment = $row['agentPayment'];
                            ?>
                            <tr class='text-center align-middle'>
                                <td>
                                    <?php echo "$order_id"; ?>
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
                                    echo "$cust_name";
                                    ?>
                                </td>
                                <td>
                                    <?php echo "$order_location"; ?>
                                </td>
                                <td>
                                    <?php echo "$order_time"; ?>
                                </td>
                                <td>
                                    <?php echo "₹$order_agentPayment"; ?>
                                </td>
                                <td>
                                    <form
                                        action='index.php?agent_id=<?php echo "$agent_id"; ?>&deliver_order&order_id=<?php echo "$order_id"; ?>'
                                        method="post">
                                        <button type="submit" class="btn btn-info my-1 px-3" name="ship_order">Deliver Order</button>
                                    </form>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <?php
        }
    }
}

// Function to Display Current Status of the agent
function displayStatus($agent_id)
{
    global $con;
    $get_agent = "SELECT * FROM deliveryAgent WHERE agentID = $agent_id;";
    $result_get = mysqli_query($con, $get_agent);
    $row_agent = mysqli_fetch_assoc($result_get);
    $current_status = $row_agent['availabilityStatus'];
    ?>

    <?php
}

?>