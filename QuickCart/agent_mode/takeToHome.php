<!-- update the status of the agent to Available and redirect to available Home page -->

<?php
if (isset ($_GET['agent_id']) and isset($_GET['takeToHome'])) {
    $agent_id = $_GET['agent_id'];

    $update_agentStatus = "UPDATE deliveryAgent SET availabilityStatus = 'Available' WHERE agentID = '$agent_id';";
    $result_status = mysqli_query($con, $update_agentStatus);
    if ($result_status) {
        $alert_message = "Your status has been changed Available. Now, you will be assigned orders to deliver.";
        // Redirect to Available Home page
        echo "<script>alert('$alert_message'); window.location.href = 'index.php?agent_id=$agent_id&home';</script>";
        exit(); // Stop further execution
    }
}
?>

?>