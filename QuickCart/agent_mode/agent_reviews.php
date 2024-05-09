<?php
$fetch_dreview = "SELECT * FROM DeliveryReview WHERE agentID = $agent_id;";
$result_fetch = mysqli_query($con, $fetch_dreview);
$num_of_rows = mysqli_num_rows($result_fetch);
if ($num_of_rows == 0) {
    echo "<h2 class='text-center text-danger'> No Delivery Reviews have been submitted by the customers! </h2>";
} else {
    ?>
        <h2 class="text-center text-success"><?php echo "$agent_name's Delivery Reviews"; ?></h2>
    <table class="table table-bordered mt-5">
        <thead class="table-info text-center text-white">
            <tr>
                <th>S.No.</th>
                <th>Order ID</th>
                <th>Comment</th>
                <th>Rating</th>
                <th>Tip</th>
            </tr>
        </thead>
        <tbody class="table-secondary text-white">
            <?php
            $fetch_dreview = "SELECT * FROM DeliveryReview WHERE agentID = $agent_id ORDER BY orderID DESC;";
            $result_fetch = mysqli_query($con, $fetch_dreview);
            $count = 1;
            while ($fetch_row = mysqli_fetch_assoc($result_fetch)) {
                $review_id = $fetch_row["deliveryReviewID"];
                $order_id = $fetch_row["orderID"];
                $comment = $fetch_row['comment'];
                $rating = $fetch_row['rating'];
                $tip = $fetch_row['tip'];
                ?>
                <tr class='text-center align-middle'>
                    <td>
                        <?php echo $count++; ?>
                    </td>
                    <td>
                        <?php echo $order_id; ?>
                    </td>
                    <td>
                        <?php echo $comment; ?>
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
