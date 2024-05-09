<?php
include ('../includes/connect.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Login</title>
    <!-- bootstrap CSS link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <style>
        body {
            overflow-x: hidden
        }
    </style>

</head>

<body>
    <div class="container-fluid my-5">
        <h2 class="text-center">Customer Login</h2>
        <div class="row d-flex align-items-center justify-content-center mt-4">
            <div class="col-lg-l2 col-xl-6">
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="form-outline mb-4">
                        <!-- email field -->
                        <label for="email" class="form-label">Email</label>
                        <input type="text" id="email" class="form-control" placeholder="Enter your Email ID"
                        autocomplete="off" required="required" name="email" />
                    </div>
                    <div class="form-outline mb-4">
                        <!-- password field -->
                        <label for="password" class="form-label">Password</label>
                        <input type="password" id="password" class="form-control" placeholder="Enter your Password"
                        autocomplete="off" required="required" name="password" />
                    </div>
                    <div class=" mt-4 pt-2">
                        <input type="submit" value="Login" class="btn btn-info py-2 px-3 border-0" name="user_login">
                        <p class="small fw-bold mt-2 pt-1 mb-0">Don't have an account? <a
                                href="customer_registration.php" class="text-danger"> Register</a></p>
                    </div>
                </form>
            </div>
        </div>

    </div>

</body>

</html>

<?php

if (isset ($_POST['user_login'])) {

    $email = $_POST['email'];
    $password = $_POST['password'];

    $select_query = "SELECT * FROM customer WHERE email='$email' AND password='$password';";
    $result = mysqli_query($con, $select_query);
    $rows_count = mysqli_num_rows($result);
    if ($rows_count > 0) {
        $row_data = mysqli_fetch_assoc($result);
        $customer_id = $row_data["customerID"];
        echo "<script>alert('Logged In successfully'); window.location.href = 'index.php?customer_id=" . $customer_id . "';</script>";

    } else {
        echo "<script>alert('Invalid Credentials')</script>";
    }

}

?>