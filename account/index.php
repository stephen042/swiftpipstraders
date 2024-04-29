<!doctype html>
<html lang="en">

<?php

include "../_servers/initialize.php";

if (!isset($_SESSION['authorized'])) {
    header('Location: ./authx');
}

$datasources = fetch_account_data($_SESSION['authorized']);
$account_data = $datasources["investor_datasource"];
$manager_data = $datasources["manager_datasource"];

$db_conn = connect_to_database();

$stmt = $db_conn->prepare("SELECT * FROM `kyc` WHERE JSON_EXTRACT(`datasource`, '$.account_id') = ?");
$stmt->bind_param("s", $account_data["account_id"]);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $datasource_kyc = json_decode($row['datasource'], true);
} else {
    $datasource_kyc = [];
}

?>

<head>

    <meta charset="utf-8" />
    <title>Bitpips | Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Bitpips | Authentication" name="description" />
    <meta content="Bitpips " name="author" />

    <!-- Include styles module -->
    <?php include "./modules/_data_source/styles.php" ?>

</head>

<body>

    <!-- Loader -->
    <!-- <div id="preloader">
        <div id="status">
            <div class="spinner-chase">
                <div class="chase-dot"></div>
                <div class="chase-dot"></div>
                <div class="chase-dot"></div>
                <div class="chase-dot"></div>
                <div class="chase-dot"></div>
                <div class="chase-dot"></div>
            </div>
        </div>
    </div> -->

    <!-- Begin page -->
    <div id="layout-wrapper">

        <!-- Include header module -->
        <?php include "./modules/_data_source/header.php" ?>

        <!-- Include sidebar module -->
        <?php include "./modules/_data_source/sidebar.php" ?>

        <div class="main-content">

            <div class="page-content">

                <?php

                $db_conn = connect_to_database();

                if ($account_data["account_role"] == "Manager") {
                    $account_role = "Investor";

                    $transaction_status = [
                        "pending" => "Pending",
                        "completed" => "Completed",
                    ];

                    $categories = [
                        "credit" => "Credit TXN",
                        "debit" => "Debit TXN",
                    ];

                    $stmt = $db_conn->prepare("SELECT * FROM `accounts` WHERE JSON_EXTRACT(`datasource`, '$.account_role') = ?");
                    $stmt->bind_param("s", $account_role);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        $registered_users = $result->num_rows;
                    } else {
                        $registered_users = 0;
                    }

                    $stmt = $db_conn->prepare("SELECT * FROM `activities` WHERE JSON_EXTRACT(`datasource`, '$.transaction_status') = ? AND JSON_EXTRACT(`datasource`, '$.category') = ?");
                    $stmt->bind_param("ss", $transaction_status["pending"], $categories["credit"]);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        $pending_deposits = $result->num_rows;
                    } else {
                        $pending_deposits = 0;
                    }

                    $stmt = $db_conn->prepare("SELECT * FROM `activities` WHERE JSON_EXTRACT(`datasource`, '$.transaction_status') = ? AND JSON_EXTRACT(`datasource`, '$.category') = ?");
                    $stmt->bind_param("ss", $transaction_status["pending"], $categories["debit"]);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        $pending_withdrawals = $result->num_rows;
                    } else {
                        $pending_withdrawals = 0;
                    }

                    $investment_status = "Active";

                    $stmt = $db_conn->prepare("SELECT * FROM `contracts` WHERE JSON_EXTRACT(`datasource`, '$.investment_status') = ?");
                    $stmt->bind_param("s", $investment_status);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        $active_investments = $result->num_rows;
                    } else {
                        $active_investments = 0;
                    }

                    //  Include manager area module
                    include "./modules/_data_source/manager_area.php";
                } else {
                    $transaction_status = [
                        "pending" => "Pending",
                        "completed" => "Completed",
                    ];

                    $categories = [
                        "credit" => "Credit TXN",
                        "debit" => "Debit TXN",
                    ];

                    $stmt = $db_conn->prepare("SELECT * FROM `activities` WHERE JSON_EXTRACT(`datasource`, '$.account_id') = ? AND JSON_EXTRACT(`datasource`, '$.transaction_status') = ? AND JSON_EXTRACT(`datasource`, '$.category') = ?");
                    $stmt->bind_param("sss", $account_data["account_id"], $transaction_status["pending"], $categories["credit"]);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        $pending_deposits = $result->num_rows;
                    } else {
                        $pending_deposits = 0;
                    }

                    $stmt = $db_conn->prepare("SELECT * FROM `activities` WHERE JSON_EXTRACT(`datasource`, '$.account_id') = ? AND JSON_EXTRACT(`datasource`, '$.transaction_status') = ? AND JSON_EXTRACT(`datasource`, '$.category') = ?");
                    $stmt->bind_param("sss", $account_data["account_id"], $transaction_status["pending"], $categories["debit"]);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        $pending_withdrawals = $result->num_rows;
                    } else {
                        $pending_withdrawals = 0;
                    }

                    $stmt = $db_conn->prepare("SELECT JSON_EXTRACT(`datasource`, '$.amount') AS `deposit_amount` FROM `activities` WHERE JSON_EXTRACT(`datasource`, '$.account_id') = ? AND JSON_EXTRACT(`datasource`, '$.category') = ? AND JSON_EXTRACT(`datasource`, '$.transaction_status') = ?");
                    $stmt->bind_param("sss", $account_data["account_id"], $categories["credit"], $transaction_status["completed"]);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    $total_deposits = 0;

                    while ($row = $result->fetch_assoc()) {
                        $deposit_amount = json_decode($row['deposit_amount'], true);
                        $total_deposits += $deposit_amount;
                    }

                    $stmt = $db_conn->prepare("SELECT JSON_EXTRACT(`datasource`, '$.amount') AS `withdrawal_amount` FROM `activities` WHERE JSON_EXTRACT(`datasource`, '$.account_id') = ? AND JSON_EXTRACT(`datasource`, '$.category') = ? AND JSON_EXTRACT(`datasource`, '$.transaction_status') = ?");
                    $stmt->bind_param("sss", $account_data["account_id"], $categories["debit"], $transaction_status["completed"]);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    $total_withdrawals = 0;

                    while ($row = $result->fetch_assoc()) {
                        $withdrawal_amount = json_decode($row['withdrawal_amount'], true);
                        $total_withdrawals += $withdrawal_amount;
                    }
                    //  Include investor area module
                    include "./modules/_data_source/investor_area.php";
                }

                ?>
            </div>
            <!-- End Page-content -->

            <!-- Include footer module -->
            <?php include "./modules/_data_source/footer.php" ?>

        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->

    <!-- Include scripts module -->
    <?php include "./modules/_data_source/scripts.php" ?>

</body>

</html>