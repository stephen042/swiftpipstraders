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
    <title>Bitpips | Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Bitpips | Authentication" name="description" />
    <meta content="Bitpips " name="author" />

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
                <?php include "./modules/_data_source/manager_view_trades.php" ?>
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