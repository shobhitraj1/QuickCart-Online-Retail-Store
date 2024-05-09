<?php
include ('../includes/connect.php');

// Check if the trigger already exists
$check_trigger_query = "SELECT * FROM information_schema.triggers WHERE trigger_name = 'before_insert_customer';";
$trigger_result = mysqli_query($con, $check_trigger_query);

if (mysqli_num_rows($trigger_result) == 0) {
    // Trigger doesn't exist, so create it
    $trigger_query = "
    CREATE TRIGGER before_insert_customer
    BEFORE INSERT ON Customer
    FOR EACH ROW
    BEGIN
        SET NEW.age = TIMESTAMPDIFF(YEAR, NEW.dob, CURDATE());
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
//     echo "Trigger already exists.";
// }
?>
