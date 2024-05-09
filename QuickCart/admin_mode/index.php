<?php
// include('../includes/connect.php'); // Connect file to MySQL - already did in common_function.php and including that file
include ("../functions/common_function.php"); // Common functions file

if (isset ($_GET['admin_id'])) {
    $admin_id = $_GET['admin_id'];
    if ($admin_id == 1) {
        $name = "Aarzoo";
    }
    if ($admin_id == 2) {
        $name = "Shobhit";
    }
    if ($admin_id == 3) {
        $name = "Sidhartha";
    }
    if ($admin_id == 4) {
        $name = "Vanshika";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Mode</title>
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

        .prod_image {
            width: 100px;
            height: 100px;
            object-fit: contain;
        }

        .edit_image {
            width: 100%;
            height: 100px;
            object-fit: contain;
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
    <!-- navbar -->
    <div class="container-fluid p-0">
        <!-- first child -->
        <nav class="navbar navbar-expand-lg navbar-light bg-info">
            <div class="container-fluid">
                <a class="navbar-brand" href="#"><i class="fa fa-shopping-basket" aria-hidden="true"> QuickCart</i></a>
                <nav class="navbar navbar-expand-lg">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page"
                                href="index.php?admin_id=<?php echo "$admin_id"; ?>&home">Home</a>
                        </li>
                        <li class="nav-item">
                            <a href="" class="nav-link text-dark">Welcome
                                <?php echo "$name"; ?>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </nav>

        <!-- second child -->
        <div class="bg-light">
            <h3 class="text-center p-2">Manage Inventory/View Analysis</h3>
        </div>

        <!-- third child -->

        <div class="row">
            <div class="col-md-12 bg-secondary p-1 align-items-center">
                <div class="button text-center">
                    <button class="my-3 mx-2"><a href="index.php?admin_id=<?php echo "$admin_id"; ?>&insert_product"
                            class="nav-link text-dark bg-info my-1 mx-1">Insert
                            Products</a></button>
                    <button class="my-3 mx-2"><a href="index.php?admin_id=<?php echo "$admin_id"; ?>&view_product"
                            class="nav-link text-dark bg-info my-1 mx-1">View
                            Products</a></button>
                    <button class="my-3 mx-2"><a href="index.php?admin_id=<?php echo "$admin_id"; ?>&insert_category"
                            class="nav-link text-dark bg-info my-1 mx-1">Insert
                            Categories</a></button>
                    <button class="my-3 mx-2"><a href="index.php?admin_id=<?php echo "$admin_id"; ?>&view_category"
                            class="nav-link text-dark bg-info my-1 mx-1">View
                            Categories</a></button>
                    <button class="my-3 mx-2"><a href="index.php?admin_id=<?php echo "$admin_id"; ?>&view_orders"
                            class="nav-link text-dark bg-info my-1 mx-1">All
                            Orders</a></button>
                    <button class="my-3 mx-2"><a href="index.php?admin_id=<?php echo "$admin_id"; ?>&list_customers"
                            class="nav-link text-dark bg-info my-1 mx-1">List
                            Customers</a></button>
                    <button class="my-3 mx-2"><a href="index.php?admin_id=<?php echo "$admin_id"; ?>&list_agents"
                            class="nav-link text-dark bg-info my-1 mx-1">List Delivery
                            Agents</a></button>
                    <button class="my-3 mx-2"><a href="index.php?admin_id=<?php echo "$admin_id"; ?>&order_review"
                            class="nav-link text-dark bg-info my-1 mx-1">View Order Reviews</a></button>
                    <button class="my-3 mx-2"><a href="index.php?admin_id=<?php echo "$admin_id"; ?>&delivery_review"
                            class="nav-link text-dark bg-info my-1 mx-1">View Delivery Reviews</a></button>
                    <button class="my-3 mx-2"><a href="../start.php"
                            class="nav-link text-dark bg-info my-1 mx-1">Logout</a></button>
                </div>
            </div>
        </div>

        <!-- fourth child -->
        <div class="container my-3">
            <?php
            if (isset ($_GET['insert_category'])) {
                include ('insert_category.php');
            }
            if (isset ($_GET['insert_product'])) {
                include ('insert_product.php');
            }
            if (isset ($_GET['view_product'])) {
                include ('view_product.php');
            }
            if (isset ($_GET['edit_product'])) {
                include ('edit_product.php');
            }
            if (isset ($_GET['delete_product'])) {
                include ('delete_product.php');
            }
            if (isset ($_GET['view_category'])) {
                include ('view_category.php');
            }
            if (isset ($_GET['edit_category'])) {
                include ('edit_category.php');
            }
            if (isset ($_GET['delete_category'])) {
                include ('delete_category.php');
            }
            if (isset ($_GET['view_orders'])) {
                include ('view_orders.php');
            }
            if (isset ($_GET['list_customers'])) {
                include ('list_customers.php');
            }
            if (isset ($_GET['list_agents'])) {
                include ('list_agents.php');
            }
            if (isset ($_GET['order_review'])) {
                include ('order_review.php');
            }
            if (isset ($_GET['delivery_review'])) {
                include ('delivery_review.php');
            }
            if (isset ($_GET['home'])) {
                include ('home.php');
            }
            if (isset ($_GET['dispatch_order'])) {
                include ('dispatch_order.php');
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