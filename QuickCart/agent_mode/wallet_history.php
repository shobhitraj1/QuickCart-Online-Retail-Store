<?php
$get_data = "SELECT * FROM delivery_agent_wallet WHERE agentID = $agent_id;";
$result_get = mysqli_query($con, $get_data);
$row_data = mysqli_fetch_assoc($result_get);
$earning_balance = $row_data["earning_balance"];
$earning_paid = $row_data["earning_paid"];
$earning_total = $row_data["earning_total"];
$transaction_history = $row_data["Transaction_history"];
$upiID = $row_data["upiID"];

// Split the transaction history string into individual transactions
$transactions = explode("|", $transaction_history);

$increase_symbol = "🠕";
$increase = "<span style='color: green; font-size: 24px;'>$increase_symbol</span>";
$decrease_symbol = "🠗";
$decrease = "<span style='color: red; font-size: 24px;'>$decrease_symbol</span>";

?>



<div class="container mt-3">

    <h2 class="text-center">Wallet History</h2>
    <h5 class="w-50 m-auto my-3">Current Balance:
        <?php echo "₹$earning_balance"; ?>
    </h5>
    <h5 class="w-50 m-auto my-3">Amount Withdrawn:
        <?php echo "₹$earning_paid"; ?>
    </h5>
    <h5 class="w-50 m-auto my-3">Total Earning:
        <?php echo "₹$earning_total"; ?>
    </h5>

    <table class='table table-bordered mt-4'>
        <thead class='table-info text-center text-white'>
            <tr>

                <th>Transaction Date</th>
                <th>Transaction Detail</th>
                <th>Wallet Balance</th>
                <th>Total Amount Withdrawn</th>
                <th>Total Earning</th>
            </tr>
        </thead>
        <tbody class="table-secondary text-white">
            <?php
            // Iterate through each transaction
            foreach (array_reverse($transactions) as $transaction) {
                // Split each transaction into components
                $components = explode("^", $transaction);
                if ($components[1][6] == 'a') {
                    $components[2] = $components[2] . " " . $increase;
                    $components[4] = $components[4] . " " . $increase;
                } else if ($components[1][6] == 'e') {
                    $components[2] = $components[2] . " " . $increase;
                    $components[4] = $components[4] . " " . $increase;
                } else if ($components[1][6] == 'i') {
                    $components[2] = $components[2] . " " . $decrease;
                    $components[3] = $components[3] . " " . $increase;
                }

                echo "<tr class='text-center align-middle'>";
                foreach ($components as $component) {
                    // Print each component in a table cell
                    echo "<td>$component</td>";
                }
                echo "</tr>";
            }
            echo "</tbody>";
            echo "</table>";
            ?>


</div>