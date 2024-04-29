<!doctype html>
<html lang="en">

<?php

include "../_servers/initialize.php";

if (isset($_SESSION['authorized'])) {
    header('Location: ./');
}

?>

<head>

    <meta charset="utf-8" />
    <title>Bitpips | Authentication</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Bitpips | Authentication" name="description" />
    <meta content="Bitpips " name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="./_vendors/images/favicon.ico">
    <!-- Bootstrap Css -->
    <link href="./_vendors/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="./_vendors/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="./_vendors/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
    <!-- Custom Css-->
    <link href="./_vendors/css/custom.css" id="custom-style" rel="stylesheet" type="text/css" />

</head>

<body>

    <div class="account-pages mb-5">
        <div class="container">
            <a href="../" class="center-img mt-n3 mt-md-0">
                <img src="./_vendors/images/favicon.ico" class="mx-1" alt="Logo" style="width: 30px;">
                <span>s̳w̳i̳f̳t̳p̳i̳p̳s̳t̳r̳a̳d̳e̳r̳s̳</span>
            </a>
            <div class="row justify-content-center mt-n3 mt-md-0">

                <?php include "./modules/_auth_source/registration.php" ?>

                <?php include "./modules/_auth_source/login.php" ?>

                <?php include "./modules/_auth_source/recovery.php" ?>

            </div>
        </div>
    </div>

    <!-- JAVASCRIPT -->
    <script src="./_vendors/libs/jquery/jquery.min.js"></script>
    <script src="./_vendors/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="./_vendors/libs/metismenu/metisMenu.min.js"></script>
    <script src="./_vendors/libs/simplebar/simplebar.min.js"></script>
    <script src="./_vendors/libs/node-waves/waves.min.js"></script>

    <!-- validation init -->
    <script src="./_vendors/js/pages/validation.init.js"></script>

    <!-- App js -->
    <script src="./_vendors/js/app.js"></script>

    <script>
        const authSections = ["registrationSection", "loginSection", "recoverySection"];
        let visibleSectionId = null;

        // Load initial visibility from local storage
        document.addEventListener("DOMContentLoaded", function() {
            const lastVisibleSection = localStorage.getItem("visibleSectionId");
            visibleSectionId = lastVisibleSection || "registrationSection";
            hideNonVisibleDivs();
        });

        function toggleVisibility(SectionId) {
            visibleSectionId = SectionId;
            hideNonVisibleDivs();
            // Store the currently visible section in local storage
            localStorage.setItem("visibleSectionId", visibleSectionId);
        }

        function hideNonVisibleDivs() {
            authSections.forEach(SectionId => {
                const authSection = document.getElementById(SectionId);
                authSection.style.display = SectionId === visibleSectionId ? "block" : "none";
            });
        }
    </script>

</body>

</html>