<?php
if (isset ($_GET['edit_profile']) and isset($_GET['customer_id'])) {
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

<div class="container mt-3">
    <h2 class="text-center">Edit Profile</h2>
    <form action="" method="post">
        <div class="form-outline mb-4 w-50 m-auto">
            <label for="first_name" class="form-label">First Name</label>
            <input type="text" name="first_name" id="first_name" value="<?php echo "$cust_fname"; ?>"
                class="form-control" placeholder="Enter First Name" autocomplete="off" required="required" />
        </div>
        <div class="form-outline mb-4 w-50 m-auto">
            <label for="last_name" class="form-label">Last Name</label>
            <input type="text" name="last_name" id="last_name" value="<?php echo "$cust_lname"; ?>" class="form-control"
                placeholder="Enter Last Name" autocomplete="off" />
        </div>
        <div class="form-outline mb-4 w-50 m-auto">
            <label for="address_street" class="form-label">Street Address</label>
            <input type="text" name="address_street" id="address_street" value="<?php echo "$street"; ?>"
                class="form-control" placeholder="Enter your Street Address" autocomplete="off" required="required" />
        </div>
        <div class="form-outline mb-4 w-50 m-auto">
            <label for="address_city" class="form-label">City</label>
            <input type="text" name="address_city" id="address_city" value="<?php echo "$city"; ?>" class="form-control"
                placeholder="Enter your City" autocomplete="off" required="required" />
        </div>
        <div class="form-outline mb-4 w-50 m-auto">
            <label for="address_state" class="form-label">State</label>
            <input type="text" name="address_state" id="address_state" value="<?php echo "$state"; ?>"
                class="form-control" placeholder="Enter your State" autocomplete="off" required="required" />
        </div>
        <div class="form-outline mb-4 w-50 m-auto">
            <label for="pincode" class="form-label">Pincode</label>
            <input type="number" name="pincode" id="pincode" value="<?php echo "$pincode"; ?>" class="form-control"
                placeholder="Enter your pincode" autocomplete="off" required="required" min="0" />
        </div>
        <div class="form-outline mb-4 w-50 m-auto">
            <label for="phone_no" class="form-label">Phone Number</label>
            <input type="number" name="phone_no" id="phone_no" value="<?php echo "$phone"; ?>" class="form-control"
                placeholder="Enter your Phone Number" autocomplete="off" required="required" min="0"/>
        </div>
        <div class="form-outline mb-4 w-50 m-auto">
            <label for="email" class="form-label">Email</label>
            <input type="text" name="email" id="email" value="<?php echo "$email"; ?>" class="form-control"
                placeholder="Enter your Email ID" autocomplete="off" required="required" />
        </div>
        <div class="form-outline mb-4 w-50 m-auto">
            <label for="password" class="form-label">Password</label>
            <input type="password" id="password" class="form-control" placeholder="Enter Password" autocomplete="off"
                required="required" name="password" />
        </div>
        <div class="form-outline mb-4 w-50 m-auto">
            <label for="conf_customer_password" class="form-label">Confirm Password</label>
            <input type="password" id="conf_customer_password" class="form-control" placeholder="Confirm Password"
                autocomplete="off" required="required" name="conf_customer_password" />
        </div>
        <div class="form-outline mb-4 w-50 m-auto">
            <label for="dob" class="form-label">Date of Birth (YYYY-MM-DD)</label>
            <input type="text" id="dob" class="form-control" pattern="\d{4}-\d{2}-\d{2}" value="<?php echo "$dob"; ?>"
                placeholder="Enter your Date of Birth (YYYY-MM-DD)" autocomplete="off" required="required" name="dob" />
            <small class="text-muted">Format: YYYY-MM-DD</small>
        </div>
        <div class="form-outline mb-4 w-50 m-auto">
            <label for="gender" class="form-label">Gender</label>
            <select id="gender" class="form-select" required="required" name="gender">
                <option value="" disabled selected>Select your Gender</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Other">Other</option>
            </select>
        </div>
        <div class="form-outline mb-4 w-50 m-auto">
            <input type="submit" name="edit_prof" class="btn btn-info mb-3 px-3" value="Update Profile">
        </div>
    </form>
</div>

<!-- updating customer's details in the database -->
<?php
if (isset ($_POST['edit_prof'])) {
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

    $select_query = "SELECT * FROM customer WHERE (email='$email' OR phone_no='$phone_no') AND customerID != '$cust_id';";
    $result = mysqli_query($con, $select_query);
    $rows_count = mysqli_num_rows($result);
    if ($rows_count > 0) {
        echo "<script>alert('Customer with given Email or Phone Number already exist. Please enter again.')</script>";
    } else if ($password != $conf_password) {
        echo "<script>alert('Passwords do not match. Please try again.')</script>";
    } else {
        // update customer to table - SET safe mode OFF to update
        $safe_mode_query = "SET SQL_SAFE_UPDATES = 0;";
        $result_safe = mysqli_query($con, $safe_mode_query);
        if ($result_safe == 0) {
            echo "Couldn't turn safe mode OFF";
        }

        $update_query = "UPDATE customer SET first_name = '$first_name', last_name = '$last_name', address_street = '$address_street', address_city = '$address_city', address_state = '$address_state', pincode = '$pincode', phone_no = '$phone_no', email = '$email', password = '$password', dob = '$dob', gender = '$gender' WHERE customerID = '$cust_id';";
        $result_query = mysqli_query($con, $update_query);
        if ($result_query) {
            echo "<script>alert('Profile has been updated successfully.'); window.location.href = 'profile_page.php?customer_id=" . $cust_id . "&view_profile';</script>";
        }
    }
}
?>