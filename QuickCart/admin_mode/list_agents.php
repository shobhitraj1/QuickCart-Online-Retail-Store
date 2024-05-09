<?php
$fetch_agents = "SELECT * FROM deliveryAgent;";
$result_fetch = mysqli_query($con, $fetch_agents);
$num_of_rows = mysqli_num_rows($result_fetch);
if ($num_of_rows == 0) {
    echo "<h2 class = 'text-center text-danger'> No Delivery Agents have registered! </h2>";
} else {
    ?>
    <h2 class="text-center text-success">All Delivery Agents</h2>
    <table class="table table-bordered mt-5">
        <thead class="table-info text-center text-white">
            <tr>
                <th>Agent ID</th>
                <th>Name</th>
                <th>Email ID</th>
                <th>Mobile No</th>
                <th>Age</th>
                <th>Availability Status</th>
            </tr>
        </thead>
        <tbody class="table-secondary text-white">
            <?php
            // Update the age of agents as derived attribute - SET safe mode OFF to update
            $safe_mode_query = "SET SQL_SAFE_UPDATES = 0;";
            $result_safe = mysqli_query($con, $safe_mode_query);
            if ($result_safe == 0) {
                echo "Couldn't turn safe mode OFF";
            }
            $update_agents = "UPDATE deliveryAgent SET age = DATEDIFF(CURDATE(), dob) / 365;";
            $result_update = mysqli_query($con, $update_agents);
            $fetch_agents = "SELECT * FROM deliveryAgent;";
            $result_fetch = mysqli_query($con, $fetch_agents);
            while ($fetch_row = mysqli_fetch_assoc($result_fetch)) {
                $agent_id = $fetch_row["agentID"];
                $agent_fname = $fetch_row['first_name'];
                $agent_lname = $fetch_row['last_name'];
                $agent_email = $fetch_row["email"];
                $agent_mobile = $fetch_row["phone_no"];
                $agent_status = $fetch_row["availabilityStatus"];
                $agent_age = $fetch_row["age"];
                ?>
                <tr class='text-center align-middle'>
                    <td>
                        <?php echo "$agent_id"; ?>
                    </td>
                    <td>
                        <?php
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
                        <?php echo "$agent_email"; ?>
                    </td>
                    <td>
                        <?php echo "$agent_mobile"; ?>
                    </td>
                    <td>
                        <?php echo "$agent_age"; ?>
                    </td>
                    <td>
                        <?php echo "$agent_status"; ?>
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