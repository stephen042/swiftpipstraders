<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="text-capitalize"><span id="greeting">Good morning</span>, <?php echo $account_data["username"] ?>🏆</h4>
                <span>Here's a summary of the current status of your <a href="../" class="fw-bold" target="_blank">Bitpips</a> manager account.</span>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <?php
    if (isset($_SESSION['feedback'])) {
        $feedback = $_SESSION['feedback'];
        unset($_SESSION['feedback']);
    ?>
        <div class="alert alert-primary alert-dismissible fade show mt-n3" role="alert">
            <i class="mdi mdi-bullseye-arrow me-2"></i>
            <?php echo $feedback ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php
    }
    ?>

    <div class="row">
        <div class="col-xl-12">
            <div class="row">
                <div class="col-md-3">
                    <div class="card mini-stats-wid border-rounded-13 border-light-primary">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <p class="text-muted fw-medium"> Registered Users</p>
                                    <h6 class="mb-0 fw-bold"><?php echo $registered_users ?> Registered</h6>
                                </div>

                                <div class="flex-shrink-0 align-self-center">
                                    <div class="mini-stat-icon avatar-xs rounded bg-primary">
                                        <span class="avatar-title">
                                            <i class="bx bx-user-pin font-size-16"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card mini-stats-wid border-rounded-13 border-light-primary">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <p class="text-muted fw-medium">Pending Deposits</p>
                                    <h6 class="mb-0 fw-bold"><?php echo $pending_deposits ?> Pending</h6>
                                </div>

                                <div class="flex-shrink-0 align-self-center">
                                    <div class="mini-stat-icon avatar-xs rounded bg-primary">
                                        <span class="avatar-title">
                                            <i class="bx bx-money-withdraw font-size-16"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card mini-stats-wid border-rounded-13 border-light-primary">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <p class="text-muted fw-medium">Pending Withdrawals</p>
                                    <h6 class="mb-0 fw-bold"><?php echo $pending_withdrawals ?> Pending</h6>
                                </div>

                                <div class="flex-shrink-0 align-self-center">
                                    <div class="mini-stat-icon avatar-xs rounded bg-primary">
                                        <span class="avatar-title">
                                            <i class="bx bx-money-withdraw font-size-16"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card mini-stats-wid border-rounded-13 border-light-primary">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <p class="text-muted fw-medium">Active Investments</p>
                                    <h6 class="mb-0 fw-bold"><?php echo $active_investments ?> Active</h6>
                                </div>

                                <div class="flex-shrink-0 align-self-center">
                                    <div class="mini-stat-icon avatar-xs rounded bg-primary">
                                        <span class="avatar-title">
                                            <i class="bx bx-gift font-size-16"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="page-title-box mb-0 pb-3">
                        <h4 class="text-capitalize mb-0">Manage Registered Accounts</h4>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="card mini-stats-wid border-rounded-13 border-light-primary">
                        <div class="card-body">
                            <table class="table datatable table-striped dt-responsive nowrap w-100">
                                <thead>
                                    <tr class="text-uppercase">
                                        <th>Full Names</th>
                                        <th>Username</th>
                                        <th>Country</th>
                                        <th>Registered On</th>
                                        <th>Balance</th>
                                        <th>Earnings</th>
                                        <th>Ai Trade</th>
                                        <th>Manage User</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php

                                    $db_conn = connect_to_database();
                                    $account_role = "Investor";

                                    $stmt = $db_conn->prepare("SELECT * FROM `accounts` WHERE JSON_EXTRACT(`datasource`, '$.account_role') = ?");
                                    $stmt->bind_param("s", $account_role);
                                    $stmt->execute();
                                    $result = $stmt->get_result();

                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $investor_data = json_decode($row['datasource'], true);
                                    ?>
                                        <tr>

                                            <td><?php echo $investor_data["full_names"] ?></td>
                                            <td><?php echo $investor_data["username"] ?></td>
                                            <td><?php echo $investor_data["country"] ?></td>
                                            <td><?php echo $investor_data["registration_date"] ?></td>
                                            <td>$<?php echo number_format($investor_data["account_balance"], 2) ?></td>
                                            <td>$<?php echo number_format($investor_data["account_earnings"], 2) ?></td>
                                            <td><a href="./authAI?investor_id=<?php echo $investor_data["account_id"] ?>" class="btn btn-success btn-sm border-0 px-1 pt-1">AI Trade <i class='fas fa-robot'></i></a></td>
                                            <td>
                                                <form action="./" method="post">
                                                    <input type="hidden" name="account_id" value="<?php echo $investor_data["account_id"] ?>">
                                                    <button class="badge bg-danger p-2 my-1 border-0" onclick="return confirm('This process is irreversible! Click OK to continue.');" name="terminate_datasource" type="submit">
                                                        <i class='bx bx-trash'></i>
                                                    </button>
                                                </form>
                                                <a href="./authu?investor_id=<?php echo $investor_data["account_id"] ?>" class="badge bg-primary border-0 px-1 pt-1">Manage <i class='bx bx-edit'></i></a>
                                            </td>

                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
            <!-- end row -->

        </div>
    </div>
    <!-- end row -->
</div> <!-- container-fluid -->

<?php include "manager_modals.php" ?>