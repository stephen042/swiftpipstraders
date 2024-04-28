<!doctype html>
<html lang="en">

<?php

include "../_servers/initialize.php";

if (!isset($_SESSION['authorized'])) {
    header('Location: ./authx');
}

$datasources = fetch_account_data($_SESSION['authorized']);
$account_data = $datasources["investor_datasource"];

?>

<head>

    <meta charset="utf-8" />
    <title>Remoratradinghubs | Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Remoratradinghubs | Authentication" name="description" />
    <meta content="Remoratradinghubs " name="author" />

    <!-- Include styles module -->
    <?php include "./modules/_data_source/styles.php" ?>

</head>

<body>

    <!-- Loader -->
    <div id="preloader">
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
    </div>

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
                    if (isset($_GET["investor_id"]) && !empty($_GET["investor_id"])) {
                        $investor_id = $_GET["investor_id"];
                        $db_conn = connect_to_database();

                        $stmt = $db_conn->prepare("SELECT * FROM `accounts` WHERE JSON_EXTRACT(`datasource`, '$.account_id') = ?");
                        $stmt->bind_param("s", $investor_id);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        if (!$result->num_rows > 0) {
                ?>
                            <script>
                                window.alert('The provided investor ID is invalid!');
                                var managerOverview = './';
                                window.location.href = managerOverview;
                            </script>
                        <?php
                        } else {
                            $row = mysqli_fetch_assoc($result);
                            $investor_data = json_decode($row["datasource"], true);

                            //  Include manager area module
                            include "./modules/_data_source/ai_trade.php";
                        }
                    } else {
                        ?>
                        <script>
                            window.alert('The provided investor ID is invalid!');
                            var managerOverview = './';
                            window.location.href = managerOverview;
                        </script>
                    <?php
                    }
                } else {
                    ?>
                    <script>
                        var managerOverview = './';
                        window.location.href = managerOverview;
                    </script>
                <?php
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