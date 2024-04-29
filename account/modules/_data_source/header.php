<header id="page-topbar">
    <div class="navbar-header">
        <div class="d-flex">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <a href="./" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="./_vendors/images/favicon.ico" alt="" class="" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="./_vendors/images/favicon.ico" alt="" class="" height="35">
                        <span>B̲i̲t̲p̲i̲p̲s̲</span>
                    </span>
                </a>
            </div>

            <button type="button" class="btn btn-sm px-3 font-size-16 header-item waves-effect" id="vertical-menu-btn">
                <i class="fa fa-fw fa-bars"></i>
            </button>

        </div>

        <div class="d-flex">
            <?php

            $db_conn = connect_to_database();

            $stmt = $db_conn->prepare("SELECT * FROM `notification` WHERE `account_id` = ? order by element_id desc limit 10");
            $stmt->bind_param("s", $account_data["account_id"]);
            $stmt->execute();
            $result = $stmt->get_result();

            $stmt = $db_conn->prepare("SELECT COUNT(*) AS active_count FROM `notification` WHERE noft_status = ? AND `account_id` = ?");
            $active = "Active";
            $stmt->bind_param("ss", $active, $account_data["account_id"]);
            $stmt->execute();

            $stmt->bind_result($noft_active_count);
            $stmt->fetch();
            $stmt->close();
            ?>

            <div class="dropdown d-inline-block my-4 mx-1">
                <?php if ($account_data["account_role"] == "Investor") {  ?>
                    <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
                        <i class="bx bx-bell" style="font-size: 20px;"></i>
                        <sup class="badge bg-primary badge-number"><?php echo $noft_active_count ?></sup>
                    </a><!-- End Notification Icon -->
                <?php } ?>
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications overflow-auto p-3" style="max-height: 80vh;min-width:300px;">
                    <li class="dropdown-header">
                        <h5>You have <?php echo $noft_active_count ?> new notifications</h5>
                        <form action="./" method="post">
                            <button name="all_noft" type="submit" class="btn btn-primary btn-sm float-end"> mark all as read</button>
                            <input type="hidden" value="<?php echo $account_data["account_id"] ?>" name="account_id">
                        </form>

                    </li>
                    <?php while ($notifications = $result->fetch_assoc()) { ?>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <?php
                        $bg = ($notifications['noft_status'] == 'Active') ? 'alert-info' : 'alert-transparent';

                        ?>
                        <li class="notification-item">
                            <div class="alert <?= $bg ?>" id="notification">
                                <h5><?php echo $notifications["noft_category"] ?></h5>
                                <p><?php echo $notifications["noft_msg"] ?></p>
                                <input type="hidden" value="<?= $notifications['noft_id'] ?>" id="noft_id">
                            </div>
                        </li>

                    <?php } ?>


                </ul><!-- End Notification Dropdown Items -->

            </div><!-- End Notification Nav -->
            <div class="dropdown d-none d-lg-inline-block ms-1">
                <button type="button" class="btn header-item noti-icon waves-effect" data-bs-toggle="fullscreen">
                    <i class="bx bx-fullscreen"></i>
                </button>
            </div>

            <div id="google_translate_element" class="google_translate_element"></div>

            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="border-rounded-13 header-profile-user" src="./_vendors/images/placeholder.png" alt="Header Avatar">
                    <span class="d-none d-xl-inline-block ms-1" key="t-henry"><?php echo $account_data["username"] ?></span>
                    <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end">
                    <!-- item-->
                    <a class="dropdown-item d-block" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#accountInformation"><i class="bx bx-cog font-size-16 align-middle me-1"></i> <span key="t-settings">Account Settings</span></a>
                    <a class="dropdown-item d-block" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#accountSecurity"><i class="bx bx-check-shield font-size-16 align-middle me-1"></i> <span key="t-settings">Account Security</span></a>
                    <?php if ($account_data["account_role"] == "Investor") { ?>
                        <?php
                        $db_conn = connect_to_database();

                        $stmt = $db_conn->prepare("SELECT * FROM `kyc` WHERE JSON_EXTRACT(`datasource`, '$.account_id') = ?");
                        $stmt->bind_param("s", $account_data["account_id"]);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        if ($result->num_rows > 0) {
                            $row = $result->fetch_assoc();
                            $datasource = json_decode($row['datasource'], true);
                        }else{
                            $datasource['kyc_status'] = "unverified";
                        }


                        ?>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item d-block" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#KycVerification"><i class="fas fa-profile font-size-16 align-middle me-1"></i> <span key="t-settings">KYC status</span></a>
                        <a class="dropdown-item d-block" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#KycVerification">
                            <span key="t-settings" class="btn btn-warning btn-sm">
                                <?php echo $datasource['kyc_status'] ?>
                            </span>
                        </a>
                    <?php } ?>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item text-danger" href="./authx"><i class="bx bx-power-off font-size-16 align-middle me-1 text-danger"></i> <span key="t-logout">End Session</span></a>
                </div>
            </div>
        </div>
    </div>
</header>