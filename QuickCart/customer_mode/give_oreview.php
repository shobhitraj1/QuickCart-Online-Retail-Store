<?php
if (isset ($_GET['give_oreview']) and isset ($_GET['customer_id']) and isset ($_GET['order_id'])) {
    $cust_id = $_GET['customer_id'];
    $order_id = $_GET['order_id'];
}
?>

<div class="container mt-3">
    <h2 class="text-center">Give Order Review</h2>
    <form action="" method="post">
        <div class="form-outline mb-4 w-50 m-auto">
            <label for="comment" class="form-label">Comment</label>
            <input type="text" name="comment" id="comment" class="form-control"
                placeholder="Enter Comment about the Order" autocomplete="off" required="required">
        </div>
        <div class="form-outline mb-4 w-50 m-auto">
            <label for="rating" class="form-label">Rating (1-5)</label>
            <select id="rating" class="form-select" required="required" name="rating">
                <option value="" disabled selected>Rate the Order</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
            </select>
        </div>
        <div class="form-outline mb-4 w-50 m-auto">
            <input type="submit" name="submit_review1" class="btn btn-info mb-3 px-3" value="Submit Review">
        </div>
        <!-- made submit_review1, because same post on submit button on previous page, so this is set when come to this page. -->
    </form>
</div>

<!-- updating review's details in the database -->
<?php
if (isset ($_POST['submit_review1'])) { 
    $comment = $_POST['comment'];
    $rating = $_POST['rating'];

    $get_preview = "SELECT * FROM ProductReview;";
    $result_get = mysqli_query($con, $get_preview);
    $no_of_reviews = mysqli_num_rows($result_get);
    $review_id = $no_of_reviews + 1;
    
    $insert_review = "INSERT INTO ProductReview (productReviewID, orderID, customerID, comment, rating) VALUES
    ('$review_id', '$order_id', '$cust_id', '$comment', '$rating');";
    $result_insert = mysqli_query($con, $insert_review);
    if ($result_insert) {
        echo "<script>alert('Thank you for the review. We will try to improve based on your valuable feedback.'); window.location.href = 'profile_page.php?customer_id=" . $cust_id . "&rate_order';</script>";
    }
}
?>