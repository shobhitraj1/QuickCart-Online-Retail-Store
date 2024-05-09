<?php
include('../includes/connect.php');

// Check if the trigger already exists
$check_trigger_query = "SELECT * FROM information_schema.triggers WHERE trigger_name = 'after_insert_orders';";
$trigger_result = mysqli_query($con, $check_trigger_query);

if (!$trigger_result) {
    echo "Error checking trigger existence: " . mysqli_error($con);
    exit; 
}

if (mysqli_num_rows($trigger_result) == 0) {
    // Trigger doesn't exist, so create it
    $trigger_query = "
    CREATE TRIGGER after_insert_orders
    AFTER INSERT ON `order`
    FOR EACH ROW
    BEGIN
        -- Update deliveryAgent availabilityStatus to 'Busy' for the agent assigned to the new order
        UPDATE deliveryAgent 
        SET availabilityStatus = 'Busy' 
        WHERE agentID = NEW.agentID; -- Used NEW.agentID to refer to the newly inserted order's agentID
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
