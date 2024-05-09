<?php
if (isset($_GET['give_dreview']) and isset($_GET['customer_id']) and isset($_GET['order_id']) and isset($_GET['agent_id'])) {
    $cust_id = $_GET['customer_id'];
    $order_id = $_GET['order_id'];
    $agent_id = $_GET['agent_id'];
}
?>

<div class="container mt-3">
    <h2 class="text-center">Give Delivery Review</h2>
    <form action="" method="post">
        <div class="form-outline mb-4 w-50 m-auto">
            <label for="comment" class="form-label">Comment</label>
            <input type="text" name="comment" id="comment" class="form-control"
                placeholder="Enter Comment about the Delivery" autocomplete="off" required="required">
        </div>
        <div class="form-outline mb-4 w-50 m-auto">
            <label for="rating" class="form-label">Rating (1-5)</label>
            <select id="rating" class="form-select" required="required" name="rating">
                <option value="" disabled selected>Rate the Delivery</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
            </select>
        </div>
        <div class="form-outline mb-4 w-50 m-auto">
            <label for="tip" class="form-label">Tip Amount</label>
            <input type="number" name="tip" id="tip" class="form-control"
                placeholder="Enter Tip Amount (This will go directly to Delivery agent)" autocomplete="off"
                required="required" min="0">
        </div>
        <div class="form-outline mb-4 w-50 m-auto">
            <input type="submit" name="submit_review1" class="btn btn-info mb-3 px-3" value="Submit Review">
        </div>
        <!-- made submit_review1, because same post on submit button on previous page, so this is set when come to this page. -->
    </form>
</div>

<!-- updating review's details in the database -->
<?php
if (isset($_POST['submit_review1'])) {
    $comment = $_POST['comment'];
    $rating = $_POST['rating'];
    $tip = $_POST['tip'];

    // Here, check tip <= customer's wallet & deduct amount from the wallet
    $get_wallet = "SELECT * FROM wallet WHERE customerID = '$cust_id';";
    $result_get = mysqli_query($con, $get_wallet);
    $row_data = mysqli_fetch_assoc($result_get);
    $balance = $row_data["balance"];

    if ($balance < $tip) {
        echo "<script> alert('You don\'t have enough balance.')</script>";
        exit();
    } else {

        $new_amount = $balance - $tip;
        $update_query = "UPDATE wallet SET balance = '$new_amount' WHERE customerID = '$cust_id';";
        $result_query = mysqli_query($con, $update_query);


        $get_dreview = "SELECT * FROM DeliveryReview;";
        $result_get = mysqli_query($con, $get_dreview);
        $no_of_reviews = mysqli_num_rows($result_get);
        $review_id = $no_of_reviews + 1;

        $insert_review = "INSERT INTO DeliveryReview (deliveryReviewID, orderID, agentID, comment, rating, tip) VALUES
    ('$review_id', '$order_id', '$agent_id', '$comment', '$rating','$tip');";
        $result_insert = mysqli_query($con, $insert_review);

        $get_data = "SELECT * FROM delivery_agent_wallet WHERE agentID = $agent_id;";
        $result_get = mysqli_query($con, $get_data);
        $row_data = mysqli_fetch_assoc($result_get);
        $earning_balance = $row_data["earning_balance"];
        $earning_paid = $row_data["earning_paid"];
        $earning_total = $row_data["earning_total"];
        $trans_history = $row_data["Transaction_history"];

        $newBalance = $earning_balance + $tip;
        $newBalance1 = number_format($newBalance, 2);
        $newTotal = $earning_total + $tip;
        $newTotal1 = number_format($newTotal, 2);


        $current_date = date("d-m-Y");


        if ($tip > 0) {
            $trans_statement = "$current_date^ You were tipped ₹$tip for delivering order $order_id^ $newBalance1^ $earning_paid^ $newTotal1";
        } else {
            $trans_statement = "";
        }
        $new_Trans = $trans_history . "| " . $trans_statement;
        $update_Dwallet = "UPDATE delivery_agent_wallet SET earning_balance = earning_balance + $tip, earning_total = earning_total + $tip, Transaction_history = '$new_Trans' WHERE agentID = '$agent_id';";
        $result_Dwallet = mysqli_query($con, $update_Dwallet);

        if ($result_insert and $result_Dwallet and $result_query) {
            echo "<script>alert('Thank you for the review. We will try to improve based on your valuable feedback.'); window.location.href = 'profile_page.php?customer_id=" . $cust_id . "&rate_delivery';</script>";
        }
    }
}
?>
