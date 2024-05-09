<?php
// include('../includes/connect.php'); // Connect file to MySQL - already did in common_function.php and including that file
include ('../functions/common_function.php'); // Common functions file
include ('busystatus_trigger.php');

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
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QuickCart</title>
    <!-- bootstrap CSS link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- font awesome link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- CSS file link -->
    <link rel="stylesheet" href="../style.css">
    <style>
        body {
            overflow-x: hidden;
        }
    </style>
</head>

<body>

    <!-- responsive navbar - container fluid is a bootstrap class which takes complete 100% width -->
    <div class="container-fluid p-0">
        <!-- first child -->
        <nav class="navbar navbar-expand-lg bg-info">
            <div class="container-fluid">
                <a class="navbar-brand" href="#"><i class="fa fa-shopping-basket" aria-hidden="true"> QuickCart</i></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <!-- Here, it will redirect to profile page of the customer -->
                            <a class="nav-link active" aria-current="page"
                                href='profile_page.php?customer_id=<?php echo "$cust_id"; ?>'>My Profile</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active"
                                href='index.php?customer_id=<?php echo "$cust_id"; ?>'>Products</a>
                        </li>
                        <!-- <li class="nav-item">
                            <a class="nav-link" href="#">Reviews</a>
                        </li> -->
                        <!-- <li class="nav-item">
                            <a class="nav-link" href="#"><i class="fa fa-shopping-cart"></i> My Cart </a>
                        </li> -->

                    </ul>
                </div>
            </div>
        </nav>


        <!-- second child -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-secondary">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link text-light" href="">Welcome
                        <?php echo "$cust_name"; ?>
                    </a> <!-- will be changed to customer's name -->
                </li>
                <li class="nav-item">
                    <a class="nav-link text-light" href="../start.php">Logout</a>
                </li>
            </ul>
        </nav>

        <!-- third child -->
        <div class="container my-3">
            <h2 class="text-center text-success mt-3">Order's details</h2>
            <h4>Order Summary :</h4>
            <table class="table table-bordered mt-3">
                <thead class="table-info text-center text-white">
                    <tr>
                        <th>S.No.</th>
                        <th>Item</th>
                        <th>Quantity</th>
                        <th>Price</th>
                    </tr>
                </thead>
                <tbody class="table-secondary text-white text-center">
                    <?php
                    $get_cart = "SELECT * FROM addsToCart WHERE customerID = '$cust_id';";
                    $result_get = mysqli_query($con, $get_cart);
                    $number = 0;
                    while ($row_get = mysqli_fetch_assoc($result_get)) {
                        $prodID = $row_get["productID"];
                        $q = $row_get["quantity"];
                        $get_prod = "SELECT * FROM product WHERE productID = '$prodID';";
                        $result_prod = mysqli_query($con, $get_prod);
                        $row_prod = mysqli_fetch_assoc($result_prod);
                        $prod_name = $row_prod["name"];
                        $prod_price = $row_prod["price"];
                        $number++ ;
                        ?>
                        <tr>
                            <td>
                                <?php echo "$number"; ?>
                            </td>
                            <td>
                                <?php echo "$prod_name"; ?>
                            </td>
                            <td>
                                <?php echo "$q"; ?>
                            </td>
                            <td>
                                <?php echo "₹$prod_price"; ?>
                            </td>
                        </tr>
                    <?php }

                    ?>
                </tbody>
            </table>

            <p><strong>Grand Total:</strong>
                <?php echo "₹$totalPrice"; ?>
            </p>

            <h4>Address to be Delivered:</h4>
            <p>
                <?php echo $cust_address; ?>
            </p>

            <form action="place_order.php?customer_id=<?php echo $cust_id; ?>" method="post">
                <input type="submit" name="confirm_order" class="btn btn-info mb-3 px-3" value="Confirm and Place Order">
                <a href='index.php?customer_id=<?php echo "$cust_id"; ?>' class="btn btn-secondary mb-3 px-3 mx-2">Go Back</a>
            </form>
        </div>



        <!-- last child - footer -->
        <?php
        include ("../includes/footer.php");
        ?>
    </div>




    <!-- bootstrap JS link -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

    <!-- JS file link -->
    <!-- <script src="script.js"></script> -->
</body>

</html>