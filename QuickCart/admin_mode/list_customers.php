<?php
$fetch_customers = "SELECT * FROM customer;";
$result_fetch = mysqli_query($con, $fetch_customers);
$num_of_rows = mysqli_num_rows($result_fetch);
if ($num_of_rows == 0) {
    echo "<h2 class = 'text-center text-danger'> No Customers have registered! </h2>";
} else {
    ?>
    <h2 class="text-center text-success">All Customers</h2>
    <table class="table table-bordered mt-5">
        <thead class="table-info text-center text-white">
            <tr>
                <th>Customer ID</th>
                <th>Name</th>
                <th>Address</th>
                <th>Email ID</th>
                <th>Mobile No</th>
                <th>Gender</th>
                <th>Age</th>
            </tr>
        </thead>
        <tbody class="table-secondary text-white">
            <?php
            // Update the age of customers as derived attribute - SET safe mode OFF to update
            $safe_mode_query = "SET SQL_SAFE_UPDATES = 0;";
            $result_safe = mysqli_query($con, $safe_mode_query);
            if ($result_safe == 0) {
                echo "Couldn't turn safe mode OFF";
            }
            $update_customers = "UPDATE Customer SET age = DATEDIFF(CURDATE(), dob) / 365;";
            $result_update = mysqli_query($con, $update_customers);
            $fetch_customers = "SELECT * FROM customer;";
            $result_fetch = mysqli_query($con, $fetch_customers);
            while ($fetch_row = mysqli_fetch_assoc($result_fetch)) {
                $cust_id = $fetch_row["customerID"];
                $cust_fname = $fetch_row['first_name'];
                $cust_lname = $fetch_row['last_name'];
                $cust_street = $fetch_row["address_street"];
                $cust_city = $fetch_row["address_city"];
                $cust_state = $fetch_row["address_state"];
                $cust_pincode = $fetch_row["pincode"];
                $cust_email = $fetch_row["email"];
                $cust_mobile = $fetch_row["phone_no"];
                $cust_gender = $fetch_row["gender"];
                $cust_dob = $fetch_row["dob"];
                $cust_age = $fetch_row["age"];
                ?>
                <tr class='text-center align-middle'>
                    <td>
                        <?php echo "$cust_id"; ?>
                    </td>
                    <td>
                        <?php
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
                        <?php
                        $cust_addr = $cust_street . ', ' . $cust_city . ', ' . $cust_state . ', PINCODE - ' . $cust_pincode;
                        echo "$cust_addr";
                        ?>
                    </td>
                    <td>
                        <?php echo "$cust_email"; ?>
                    </td>
                    <td>
                        <?php echo "$cust_mobile"; ?>
                    </td>
                    <td>
                        <?php echo "$cust_gender"; ?>
                    </td>
                    <td>
                        <?php echo "$cust_age"; ?>
                    </td>
                </tr>
                <?php
            }
            ?>
        </tbody>
    </table>
    <?php
}
?>