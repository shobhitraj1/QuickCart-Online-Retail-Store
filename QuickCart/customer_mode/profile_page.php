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
    $pass = $row_data['password'];
    $email = $row_data['email'];
    $phone = $row_data['phone_no'];
    $street = $row_data['address_street'];
    $city = $row_data['address_city'];
    $state = $row_data['address_state'];
    $pincode = $row_data['pincode'];
    $dob = $row_data['dob'];
    $gender = $row_data['gender'];

    // Check if last_name is null
    if ($cust_lname === null) {
        $cust_name = $cust_fname;
    } else {
        $cust_name = $cust_fname . ' ' . $cust_lname;
    }
    $cust_address = $street . ', ' . $city . ', ' . $state. ', Pincode - ' . $pincode;
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Page</title>
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

        .button {
            display: flex;
            justify-content: center;
        }

        .button .nav-link {
            white-space: normal;
            max-width: 100px;
            min-height: 48px;
            text-align: center;
            display: flex;
            align-items: center;
            margin: 10px;
            /* Add margin to create space between buttons */
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
                </div>
                <nav class="navbar navbar-expand-lg">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a href="" class="nav-link text-dark">Welcome
                                <?php echo "$cust_name"; ?>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </nav>

        <!-- second child -->

        <div class="row">
            <div class="col-md-12 bg-secondary p-1 align-items-center">
                <div class="button text-center">
                    <button class="my-3 mx-2"><a
                            href="profile_page.php?customer_id=<?php echo "$cust_id"; ?>&view_profile"
                            class="nav-link text-dark bg-info my-1 mx-1">View Profile</a></button>
                    <button class="my-3 mx-2"><a
                            href="profile_page.php?customer_id=<?php echo "$cust_id"; ?>&view_orders"
                            class="nav-link text-dark bg-info my-1 mx-1">View Orders</a></button>
                    <button class="my-3 mx-2"><a href="profile_page.php?customer_id=<?php echo "$cust_id"; ?>&top_up"
                            class="nav-link text-dark bg-info my-1 mx-1">Top Up Wallet</a></button>
                    <button class="my-3 mx-2"><a href="profile_page.php?customer_id=<?php echo "$cust_id"; ?>&rate_order"
                            class="nav-link text-dark bg-info my-1 mx-1">Rate Order</a></button>
                    <button class="my-3 mx-2"><a href="profile_page.php?customer_id=<?php echo "$cust_id"; ?>&rate_delivery"
                            class="nav-link text-dark bg-info my-1 mx-1">Rate Delivery</a></button>
                    <button class="my-3 mx-2"><a href="../start.php"
                            class="nav-link text-dark bg-info my-1 mx-1">Logout</a></button>
                </div>
            </div>
        </div>



        <!-- third child -->
        <div class="container my-3">
            <?php
            if (isset ($_GET['view_profile'])) {
                include ('view_profile.php');
            }
            if (isset ($_GET['edit_profile'])) {
                include ('edit_profile.php');
            }
            if (isset ($_GET['view_orders'])) {
                include ('view_orders.php');
            }
            if (isset ($_GET['top_up'])) {
                include ('top_up.php');
            }
            if (isset ($_GET['rate_order'])) {
                include ('rate_order.php');
            }
            if (isset ($_GET['give_oreview'])) {
                include ('give_oreview.php');
            }
            if (isset ($_GET['rate_delivery'])) {
                include ('rate_delivery.php');
            }
            if (isset ($_GET['give_dreview'])) {
                include ('give_dreview.php');
            }
            ?>
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