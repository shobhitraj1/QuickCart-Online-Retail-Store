<?php
$fetch_orders = "SELECT * FROM `order` WHERE customerID = $cust_id AND status = 'Delivered' ORDER BY orderID DESC;";
$result_fetch = mysqli_query($con, $fetch_orders);
$num_of_rows = mysqli_num_rows($result_fetch);
if ($num_of_rows == 0) {
    echo "<h2 class='text-center text-danger'> No orders have been delivered to you yet! </h2>";
} else {
    ?>

    <h2 class="text-center text-success">
        <?php echo "$cust_name's Order Reviews"; ?>
    </h2>
    <table class="table table-bordered mt-5">
        <thead class="table-info text-center text-white">
            <tr>
                <th>S.No.</th>
                <th>Order ID</th>
                <th>Order Placed on</th>
                <th>Your Comment</th>
                <th>Rating</th>
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

                // Search if order review exists for this orderID in ProductReview table
                $isReview = "Yes";
                $search_review = "SELECT * FROM ProductReview WHERE orderID = '$order_id' AND customerID = '$cust_id';";
                $result_review = mysqli_query($con, $search_review);
                $num_of_rows = mysqli_num_rows($result_review);
                if ($num_of_rows == 0) {
                    $isReview = "No";
                } else {
                    $row_review = mysqli_fetch_assoc($result_review);
                    $comment = $row_review['comment'];
                    $rating = $row_review['rating'];
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
                        <td colspan="2">
                            <form action='profile_page.php?customer_id=<?php echo "$cust_id"; ?>&give_oreview&order_id=<?php echo "$order_id";?>' method="post">
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