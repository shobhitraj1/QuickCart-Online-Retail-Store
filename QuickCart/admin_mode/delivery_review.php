<?php
$fetch_dreview = "SELECT * FROM DeliveryReview;";
$result_fetch = mysqli_query($con, $fetch_dreview);
$num_of_rows = mysqli_num_rows($result_fetch);
if ($num_of_rows == 0) {
    echo "<h2 class = 'text-center text-danger'> No Delivery Reviews have been submitted by the customers! </h2>";
} else {
    ?>
    <h2 class="text-center text-success">All Delivery Reviews</h2>
    <table class="table table-bordered mt-5">
        <thead class="table-info text-center text-white">
            <tr>
                <th>S.No.</th>
                <th>Delivery Agent Name</th>
                <th>Order ID</th>
                <th>Comment</th>
                <th>Rating</th>
                <th>Tip</th>
            </tr>
        </thead>
        <tbody class="table-secondary text-white">
            <?php
            $fetch_dreview = "SELECT * FROM DeliveryReview ORDER BY orderID DESC;";
            $result_fetch = mysqli_query($con, $fetch_dreview);
            while ($fetch_row = mysqli_fetch_assoc($result_fetch)) {
                $agent_id = $fetch_row["agentID"];
                $review_id = $fetch_row["deliveryReviewID"];
                $order_id = $fetch_row["orderID"];
                $comment = $fetch_row['comment'];
                $rating = $fetch_row['rating'];
                $tip = $fetch_row['tip'];
                ?>
                <tr class='text-center align-middle'>
                    <td>
                        <?php echo "$review_id"; ?>
                    </td>
                    <td>
                        <?php
                        $get_agent = "SELECT * FROM deliveryAgent WHERE agentID = $agent_id;";
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
                        <?php echo "$order_id"; ?>
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
                        echo $stars;
                        ?>
                    </td>
                    <td>
                        <?php echo "₹$tip"; ?>
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