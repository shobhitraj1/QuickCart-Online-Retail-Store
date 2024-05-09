<!-- update the status of the agent to Offline and redirect to offline Home page -->

<?php
if (isset ($_GET['agent_id']) and isset ($_GET['takeToOffline'])) {
    $agent_id = $_GET['agent_id'];
    // echo "Check1";

    $update_agentStatus = "UPDATE deliveryAgent SET availabilityStatus = 'Offline' WHERE agentID = '$agent_id';";
    $result_status = mysqli_query($con, $update_agentStatus);
    // echo "Check2";
    if ($result_status) {
        // dont add ' in wont, just like in Text description of product while Inserting Product
        $alert_message = "Your status has been changed Offline. Now, you won\'t be assigned any orders to deliver.";
        // Redirect to Offline Home page
        echo "<script>alert('$alert_message'); window.location.href = 'index.php?agent_id=$agent_id&offlineHome';</script>";
        exit(); // Stop further execution
    }
}
?>
