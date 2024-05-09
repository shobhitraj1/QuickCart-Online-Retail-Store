<?php
// include('../includes/connect.php'); // Connect file to MySQL - already did in common_function.php and including that file
include ('../functions/common_function.php'); // Common functions file

if (isset ($_GET['agent_id'])) {
    $agent_id = $_GET['agent_id'];
    $get_data = "SELECT * FROM deliveryAgent WHERE agentID = $agent_id;";
    $result_get = mysqli_query($con, $get_data);
    $row_data = mysqli_fetch_assoc($result_get);
    $agent_fname = $row_data['first_name'];
    $agent_lname = $row_data['last_name'];
    $current_status = $row_data['availabilityStatus'];
    // Check if last_name is null
    if ($agent_lname === null) {
        $agent_name = $agent_fname;
    } else {
        $agent_name = $agent_fname . ' ' . $agent_lname;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agent Mode</title>
    <!-- bootstrap CSS link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- font awesome link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- CSS file link -->
    <link rel="stylesheet" href="style.css">
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
                            <!-- <a href="index.php?agent_id=<?php echo "$agent_id"; ?>&agent_profile"
                                class="nav-link text-dark bg-info my-1 mx-1">My Profile</a></button> -->
                            <a class="nav-link active" aria-current="page"
                                href='profile_page.php?agent_id=<?php echo "$agent_id"; ?>'>My Profile</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>



        <!-- third child -->
        <div class="row">
            <div class="col-md-10">
                <!-- products -->
                <div class="row">
                    <!-- fetching orders from the database -->
                    <?php
                    # function to display the order assigned
                    ?>
                </div>
            </div>
        </div>

        <!-- fourth child -->

        <?php
        // if (isset($_GET['agent_profile'])) {
        //     include('profile_page.php');
        // }
        // if (isset ($_GET['agent_offline'])) {
        //     include ('agent_offline.php');
        // }
        // if (isset ($_GET['agent_available'])) {
        //     include ('agent_available.php');
        // }
        // if (isset ($_GET['agent_busy'])) {
        //     include ('agent_busy.php');
        // }
        if (isset ($_GET['offlineHome'])) {
            include ('offlineHome.php');
        }
        if (isset ($_GET['home'])) {
            include ('home.php');
        }
        if (isset ($_GET['deliver_order'])) {
            include ('deliver_order.php');
        }
        if (isset ($_GET['takeToHome'])) {
            include ('takeToHome.php');
        }
        if (isset ($_GET['takeToOffline'])) {
            include ('takeToOffline.php');
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