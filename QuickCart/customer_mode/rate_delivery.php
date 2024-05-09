<?php
$fetch_orders = "SELECT * FROM `order` WHERE customerID = $cust_id AND status = 'Delivered' ORDER BY orderID DESC;";
$result_fetch = mysqli_query($con, $fetch_orders);
$num_of_rows = mysqli_num_rows($result_fetch);
if ($num_of_rows == 0) {
    echo "<h2 class='text-center text-danger'> No orders have been delivered to you yet! </h2>";
} else {
    ?>

    <h2 class="text-center text-success">
        <?php echo "$cust_name's Delivery Reviews"; ?>
    </h2>
    <table class="table table-bordered mt-5">
        <thead class="table-info text-center text-white">
            <tr>
                <th>S.No.</th>
                <th>Order ID</th>
                <th>Order Placed on</th>
                <th>Delivery Agent</th>
                <th>Your Comment</th>
                <th>Rating</th>
                <th>Tip Amount</th>
            </tr>
        </thead>
        <tbody class="table-secondary text-white">
            <?php
            $number = 0;
            while ($fetch_row = mysqli_fetch_assoc($result_fetch)) {
                $order_id = $fetch_row["orderID"];
                $order_location = $fetch_row["location"];
                $order_price = $fetch_row["total_price"];
                $order_time = $fetch_row["time"];
                $order_custID = $fetch_row["customerID"];
                $order_status = $fetch_row["status"];
                $order_agentID = $fetch_row["agentID"];
                $number++;

                // Search if delivery review exists for this orderID in DeliveryReview table
                $isReview = "Yes";
                $search_review = "SELECT * FROM DeliveryReview WHERE orderID = '$order_id' AND agentID = '$order_agentID';";
                $result_review = mysqli_query($con, $search_review);
                $num_of_rows = mysqli_num_rows($result_review);
                if ($num_of_rows == 0) {
                    $isReview = "No";
                } else {
                    $row_review = mysqli_fetch_assoc($result_review);
                    $comment = $row_review['comment'];
                    $rating = $row_review['rating'];
                    $tip = $row_review['tip'];
                }
                ?>
                <tr class='text-center align-middle'>
                    <?php if ($isReview == "Yes") { ?>
                        <td>
                            <?php echo "$number"; ?>
                        </td>
                        <td>
                            <?php echo "$order_id"; ?>
                        </td>
                        <td>
                            <?php echo "$order_time"; ?>
                        </td>
                        <td>
                            <?php
                            $get_agent = "SELECT * FROM deliveryAgent WHERE agentID = $order_agentID;";
                            $result_get = mysqli_query($con, $get_agent);
                            $row_agent = mysqli_fetch_assoc($result_get);
                            $agent_fname = $row_agent['first_name'];
                            $agent_lname = $row_agent['last_name'];
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
                            <?php echo "$comment"; ?>
                        </td>
                        <td>
                            <?php
                            $stars = '';
                            $filledStars = intval($rating); // Number of filled stars
                            $emptyStars = 5 - $filledStars; // Number of empty stars
                            // Add filled stars
                            for ($i = 0; $i < $filledStars; $i++) {
                                $stars .= '★'; // Filled star
                            }
                            // Add empty stars
                            for ($i = 0; $i < $emptyStars; $i++) {
                                $stars .= '☆'; // Empty star
                            }
                            echo "$stars";
                            ?>
                        </td>
                        <td>
                            <?php echo "₹$tip"; ?>
                        </td>
                    <?php } else { ?>
                        <td>
                            <?php echo "$number"; ?>
                        </td>
                        <td>
                            <?php echo "$order_id"; ?>
                        </td>
                        <td>
                            <?php echo "$order_time"; ?>
                        </td>
                        <td>
                            <?php
                            $get_agent = "SELECT * FROM deliveryAgent WHERE agentID = $order_agentID;";
                            $result_get = mysqli_query($con, $get_agent);
                            $row_agent = mysqli_fetch_assoc($result_get);
                            $agent_fname = $row_agent['first_name'];
                            $agent_lname = $row_agent['last_name'];
                            // Check if last_name is null
                            if ($agent_lname === null) {
                                $agent_name = $agent_fname;
                            } else {
                                $agent_name = $agent_fname . ' ' . $agent_lname;
                            }
                            echo "$agent_name";
                            ?>
                        </td>
                        <td colspan="3">
                            <form
                                action='profile_page.php?customer_id=<?php echo "$cust_id"; ?>&give_dreview&order_id=<?php echo "$order_id"; ?>&agent_id=<?php echo"$order_agentID";?>'
                                method="post">
                                <button type="submit" class="btn btn-info my-1 px-3" name="submit_review">Give Review</button>
                            </form>
                        </td>
                    <?php }
                    ?>
                </tr>
                <?php
            }
            ?>
        </tbody>
    </table>
    <?php
}
?>