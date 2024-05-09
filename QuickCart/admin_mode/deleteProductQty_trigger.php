<?php
include('../includes/connect.php');

// Check if the trigger already exists
$check_trigger_query = "SELECT * FROM information_schema.triggers WHERE trigger_name = 'after_delete_product';";
$trigger_result = mysqli_query($con, $check_trigger_query);

if (!$trigger_result) {
    echo "Error checking trigger existence: " . mysqli_error($con);
    exit; 
}

if (mysqli_num_rows($trigger_result) == 0) {
    // Trigger doesn't exist, so create it
    $trigger_query = "
    CREATE TRIGGER after_delete_product
    AFTER DELETE ON product
    FOR EACH ROW
    BEGIN
    -- Reducing the no of products in category table
    UPDATE productCategory 
    SET noOfProducts = noOfProducts - OLD.stock
    WHERE categoryID = OLD.categoryID; -- Used OLD to refer to the deleted product
    END;
    ";

    if (mysqli_query($con, $trigger_query)) {
        // echo "Trigger created successfully.";
        echo "<script>alert('Trigger created successfully.')</script>";
    } else {
        echo "Error creating trigger: " . mysqli_error($con);
    }
} 

// else {
//     echo "<h2> Trigger already exists! </h2>";
// }

?>
