<?php
include ('../includes/connect.php');
include ('age_trigger.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Registration</title>
    <!-- bootstrap CSS link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

</head>

<body>
    <div class="container-fluid my-5">
        <h2 class="text-center">New Customer Registration</h2>
        <div class="row d-flex align-items-center justify-content-center mt-4">
            <div class="col-lg-l2 col-xl-6">
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="form-outline mb-4">
                        <!-- customer firstname field -->
                        <label for="first_name" class="form-label">First Name</label>
                        <input type="text" id="first_name" class="form-control" placeholder="Enter your First Name"
                            autocomplete="off" required="required" name="first_name" />
                    </div>
                    <div class="form-outline mb-4">
                        <!-- customer lastname field -->
                        <label for="last_name" class="form-label">Last Name</label>
                        <input type="text" id="last_name" class="form-control" placeholder="Enter your Last Name"
                            autocomplete="off" name="last_name" />
                    </div>
                    <div class="form-outline mb-4">
                        <!-- address street field -->
                        <label for="address_street" class="form-label">Street Address</label>
                        <input type="text" id="address_street" class="form-control"
                            placeholder="Enter your Street Address" autocomplete="off" required="required"
                            name="address_street" />
                    </div>
                    <div class="form-outline mb-4">
                        <!-- address city field -->
                        <label for="address_city" class="form-label">City</label>
                        <input type="text" id="address_city" class="form-control" placeholder="Enter your City"
                            autocomplete="off" required="required" name="address_city" />
                    </div>
                    <div class="form-outline mb-4">
                        <!-- address state field -->
                        <label for="address_state" class="form-label">State</label>
                        <input type="text" id="address_state" class="form-control" placeholder="Enter your State"
                            autocomplete="off" required="required" name="address_state" />
                    </div>
                    <div class="form-outline mb-4">
                        <!-- pincode field -->
                        <label for="pincode" class="form-label">Pincode</label>
                        <input type="number" id="pincode" class="form-control" placeholder="Enter your Pincode"
                            autocomplete="off" required="required" name="pincode" min="0"/>
                    </div>
                    <div class="form-outline mb-4">
                        <!-- phone number field -->
                        <label for="phone_no" class="form-label">Phone Number</label>
                        <input type="number" id="phone_no" class="form-control" placeholder="Enter your Phone Number"
                            autocomplete="off" required="required" name="phone_no" min="0"/>
                    </div>
                    <div class="form-outline mb-4">
                        <!-- email field -->
                        <label for="email" class="form-label">Email</label>
                        <input type="text" id="email" class="form-control" placeholder="Enter your Email ID"
                            autocomplete="off" required="required" name="email" />
                    </div>
                    <div class="form-outline mb-4">
                        <!-- password field -->
                        <label for="password" class="form-label">Password</label>
                        <input type="password" id="password" class="form-control" placeholder="Enter Password"
                            autocomplete="off" required="required" name="password" />
                    </div>
                    <div class="form-outline mb-4">
                        <label for="conf_customer_password" class="form-label">Confirm Password</label>
                        <input type="password" id="conf_customer_password" class="form-control"
                            placeholder="Confirm Password" autocomplete="off" required="required"
                            name="conf_customer_password" />
                    </div>
                    <div class="form-outline mb-4">
                        <!-- date of birth field -->
                        <label for="dob" class="form-label">Date of Birth (YYYY-MM-DD)</label>
                        <input type="text" id="dob" class="form-control" pattern="\d{4}-\d{2}-\d{2}"
                            placeholder="Enter your Date of Birth (YYYY-MM-DD)" autocomplete="off" required="required"
                            name="dob" />
                        <small class="text-muted">Format: YYYY-MM-DD</small>
                    </div>
                    <div class="form-outline mb-4">
                        <!-- gender field -->
                        <label for="gender" class="form-label">Gender</label>
                        <select id="gender" class="form-select" required="required" name="gender">
                            <option value="" disabled selected>Select your Gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div class=" mt-4 pt-2">
                        <input type="submit" value="Register" class="btn btn-info py-2 px-3 border-0"
                            name="customer_register">
                        <p class="small fw-bold mt-2 pt-1 mb-0">Already have an account? <a href="customer_login.php"
                                class="text-danger"> Login</a></p>
                    </div>
                </form>
            </div>
        </div>

    </div>

</body>

</html>

<!-- php code -->
<?php
if (isset ($_POST['customer_register'])) {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $address_street = $_POST['address_street'];
    $address_city = $_POST['address_city'];
    $address_state = $_POST['address_state'];
    $pincode = $_POST['pincode'];
    $phone_no = $_POST['phone_no'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $conf_password = $_POST['conf_customer_password'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    // $customer_ip=getIPAddress();  <!--After adding the function in the functions folder -->

    $select_total = "SELECT * FROM customer;";
    $result_total = mysqli_query($con, $select_total);
    $row_total = mysqli_num_rows($result_total);        
    $select_query = "SELECT * FROM customer WHERE email='$email' OR phone_no='$phone_no';";
    $result = mysqli_query($con, $select_query);
    $rows_count = mysqli_num_rows($result);
    if ($rows_count > 0) {
        echo "<script>alert('Customer with given Email or Phone Number already exist. Please use Login option to login into your account')</script>";
    } else if ($password != $conf_password) {
        echo "<script>alert('Passwords do not match. Please try again.')</script>";
    } else {
        $insert_query = "INSERT INTO customer (first_name, last_name, address_street, address_city, address_state, pincode, phone_no, email, password, dob,age, gender) values ('$first_name','$last_name','$address_street','$address_city','$address_state','$pincode','$phone_no','$email','$password','$dob',DEFAULT,'$gender');";
        $sql_execute = mysqli_query($con, $insert_query);

        // Update the age of customers as derived attribute - SET safe mode OFF to update
        $safe_mode_query = "SET SQL_SAFE_UPDATES = 0;";
        $result_safe = mysqli_query($con, $safe_mode_query);
        if ($result_safe == 0) {
            echo "Couldn't turn safe mode OFF";
        }
        $update_customers = "UPDATE Customer SET age = DATEDIFF(CURDATE(), dob) / 365;";
        $result_update = mysqli_query($con, $update_customers);
        
        $new_cust = $row_total+1;
        $upi_id = 'customer'. $new_cust . '@upi';
        $insert_wallet = "INSERT INTO wallet (customerID, balance, upiID, rewardPoints) VALUES
        ('$new_cust', DEFAULT, '$upi_id', DEFAULT);";
        $sql_wallet = mysqli_query($con, $insert_wallet);
        if ($sql_execute and $sql_wallet) {
            echo "<script>alert('You are registered successfully. Kindly login into your account.');  window.location.href = 'customer_login.php';</script>";
        } else {
            die (mysqli_error($con));
        }
    }

}
?>