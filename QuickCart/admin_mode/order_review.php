<?php
$fetch_oreview = "SELECT * FROM ProductReview;";
$result_fetch = mysqli_query($con, $fetch_oreview);
$num_of_rows = mysqli_num_rows($result_fetch);
if ($num_of_rows == 0) {
    echo "<h2 class = 'text-center text-danger'> No Order Reviews have been submitted by the customers! </h2>";
} else {
    ?>
    <h2 class="text-center text-success">All Order Reviews</h2>
    <table class="table table-bordered mt-5">
        <thead class="table-info text-center text-white">
            <tr>
                <th>S.No.</th>
                <th>Customer Name</th>
                <th>Order ID</th>
                <th>Comment</th>
                <th>Rating</th>
            </tr>
        </thead>
        <tbody class="table-secondary text-white">
            <?php
            $fetch_oreview = "SELECT * FROM ProductReview ORDER BY orderID DESC;";
            $result_fetch = mysqli_query($con, $fetch_oreview);
            while ($fetch_row = mysqli_fetch_assoc($result_fetch)) {
                $cust_id = $fetch_row["customerID"];
                $review_id = $fetch_row["productReviewID"];
                $order_id = $fetch_row["orderID"];
                $comment = $fetch_row['comment'];
                $rating = $fetch_row['rating'];
                ?>
                <tr class='text-center align-middle'>
                    <td>
                        <?php echo "$review_id"; ?>
                    </td>
                    <td>
                        <?php
                        $get_cust = "SELECT * FROM customer WHERE customerID = $cust_id;";
                        $result_get = mysqli_query($con, $get_cust);
                        $row_cust = mysqli_fetch_assoc($result_get);
                        $cust_fname = $row_cust['first_name'];
                        $cust_lname = $row_cust['last_name'];
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

                </tr>
                <?php
            }
            ?>
        </tbody>
    </table>
    <?php
}
?>