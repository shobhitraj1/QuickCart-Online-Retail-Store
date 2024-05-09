<?php
if (isset ($_GET['edit_profile']) and isset($_GET['agent_id'])) {
    $agent_id = $_GET['agent_id'];
    $get_data = "SELECT * FROM deliveryAgent WHERE agentID = $agent_id;";
    $result_get = mysqli_query($con, $get_data);
    $row_data = mysqli_fetch_assoc($result_get);
    $agent_id = $row_data["agentID"];
    $agent_fname = $row_data['first_name'];
    $agent_lname = $row_data['last_name'];
    $pass = $row_data['password'];
    $email = $row_data['email'];
    $phone = $row_data['phone_no'];


    // Check if last_name is null
    if ($agent_lname === null) {
        $agent_name = $agent_fname;
    } else {
        $agent_name = $agent_fname . ' ' . $agent_lname;
    }
}
?>

<div class="container mt-3">
    <h2 class="text-center">Edit Profile</h2>
    <form action="" method="post">
        <div class="form-outline mb-4 w-50 m-auto">
            <label for="first_name" class="form-label">First Name</label>
            <input type="text" name="first_name" id="first_name" value="<?php echo "$agent_fname"; ?>"
                class="form-control" placeholder="Enter First Name" autocomplete="off" required="required">
        </div>
        <div class="form-outline mb-4 w-50 m-auto">
            <label for="last_name" class="form-label">Last Name</label>
            <input type="text" name="last_name" id="last_name" value="<?php echo "$agent_lname"; ?>" class="form-control"
                placeholder="Enter Last Name" autocomplete="off">
        </div>
        <div class="form-outline mb-4 w-50 m-auto">
            <label for="phone_no" class="form-label">Phone Number</label>
            <input type="number" name="phone_no" id="phone_no" value="<?php echo "$phone"; ?>" class="form-control"
                placeholder="Enter your Phone Number" autocomplete="off" required="required" min="0"/>
        </div>
        <div class="form-outline mb-4 w-50 m-auto">
            <label for="email" class="form-label">Email</label>
            <input type="text" name="email" id="email" value="<?php echo "$email"; ?>" class="form-control"
                placeholder="Enter your Email ID" autocomplete="off" required="required">
        </div>
        <div class="form-outline mb-4 w-50 m-auto">
            <label for="password" class="form-label">Password</label>
            <input type="password" id="password" class="form-control" placeholder="Enter Password" autocomplete="off"
                required="required" name="password" />
        </div>
        <div class="form-outline mb-4 w-50 m-auto">
            <label for="conf_agent_password" class="form-label">Confirm Password</label>
            <input type="password" id="conf_agent_password" class="form-control" placeholder="Confirm Password"
                autocomplete="off" required="required" name="conf_agent_password" />
        </div>
        <div class="form-outline mb-4 w-50 m-auto">
            <label for="dob" class="form-label">Date of Birth (YYYY-MM-DD)</label>
            <input type="text" id="dob" class="form-control" pattern="\d{4}-\d{2}-\d{2}" value="<?php echo "$dob"; ?>"
                placeholder="Enter your Date of Birth (YYYY-MM-DD)" autocomplete="off" required="required" name="dob" />
            <small class="text-muted">Format: YYYY-MM-DD</small>
        </div>
        <div class="form-outline mb-4 w-50 m-auto">
            <input type="submit" name="edit_prof" class="btn btn-info mb-3 px-3" value="Update Profile">
        </div>
    </form>
</div>

<!-- updating agent's details in the database -->
<?php
if (isset ($_POST['edit_prof'])) {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $phone_no = $_POST['phone_no'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $conf_password = $_POST['conf_agent_password'];
    $dob = $_POST['dob'];

    // Calculate age based on date of birth
    $dob_timestamp = strtotime($dob);
    $age = date('Y') - date('Y', $dob_timestamp);
    if (date('md', $dob_timestamp) > date('md')) {
        $age--;
    }

    $select_query = "SELECT * FROM deliveryAgent WHERE (email='$email' OR phone_no='$phone_no') AND agentID != '$agent_id';";
    $result = mysqli_query($con, $select_query);
    $rows_count = mysqli_num_rows($result);
    if ($rows_count > 0) {
        echo "<script>alert('Agent with given Email or Phone Number already exist. Please enter again.')</script>";
    } else if ($password != $conf_password) {
        echo "<script>alert('Passwords do not match. Please try again.')</script>";
    } else if ($age < 18){
        echo "<script>alert('You must be at least 18 years old to register as a delivery agent.')</script>";
    } else {
        // update agent to table - SET safe mode OFF to update
        $safe_mode_query = "SET SQL_SAFE_UPDATES = 0;";
        $result_safe = mysqli_query($con, $safe_mode_query);
        if ($result_safe == 0) {
            echo "Couldn't turn safe mode OFF";
        }
        $update_query = "UPDATE deliveryAgent SET first_name = '$first_name', last_name = '$last_name', phone_no = '$phone_no', email = '$email', password = '$password', dob = '$dob', age = '$age' WHERE agentID = '$agent_id';";
        $result_query = mysqli_query($con, $update_query);
        if ($result_query) {
            echo "<script>alert('Profile has been updated successfully.'); window.location.href = 'profile_page.php?agent_id=" . $agent_id . "&view_profile';</script>";
        }
    }
}
?>