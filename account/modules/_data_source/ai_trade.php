<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="text-capitalize"><span id="greeting">Good morning</span>, <?php echo $account_data["username"] ?>🏆</h4>
                <span>Here's a summary of the current status of <span class="text-primary"><?php echo $investor_data["full_names"] ?>'s</span> account.</span>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <button class="btn btn-primary btn-sm" onclick="window.location.href='./'"><i class="mdi mdi-arrow-left me-1"></i> back</button>
    <hr>

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
                                    <p class="text-muted fw-medium">Account Balance</p>
                                    <h6 class="mb-0 fw-bold">$<?php echo number_format($investor_data["account_balance"], 2) ?></h6>
                                </div>

                                <div class="flex-shrink-0 align-self-center">
                                    <div class="mini-stat-icon avatar-xs rounded bg-primary">
                                        <span class="avatar-title">
                                            <i class="bx bx-dollar font-size-16"></i>
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
                                    <p class="text-muted fw-medium">Current Earnings</p>
                                    <h6 class="mb-0 fw-bold">$<?php echo number_format($investor_data["account_earnings"], 2) ?></h6>
                                </div>

                                <div class="flex-shrink-0 align-self-center">
                                    <div class="mini-stat-icon avatar-xs rounded bg-primary">
                                        <span class="avatar-title">
                                            <i class="bx bx-candles font-size-16"></i>
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
                                    <p class="text-muted fw-medium">Investment Plan</p>
                                    <h6 class="mb-0 fw-bold"><?php echo $investor_data["investment_plan"] ?></h6>
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

                <div class="col-md-3">
                    <div class="card mini-stats-wid border-rounded-13 border-light-primary">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <p class="text-muted fw-medium">Amount Invested</p>
                                    <h6 class="mb-0 fw-bold">$<?php echo number_format($investor_data["amount_invested"], 2) ?></h6>
                                </div>

                                <div class="flex-shrink-0 align-self-center">
                                    <div class="mini-stat-icon avatar-xs rounded bg-primary">
                                        <span class="avatar-title">
                                            <i class="bx bx-scatter-chart font-size-16"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card mini-stats-wid border-rounded-13 border-light-primary" style="height:auto">
                        <div class="card-body p-1">
                            <div class="panel panel-primary">
                                <div class=" tab-menu-heading ">
                                    <div class="">
                                        <!-- Tabs -->
                                        <ul class="nav panel-tabs ps-2 pe-2 flex justify-content-around" style="background-color: #161616;border-radius: 10px">
                                            <li>
                                                <a style="color: #ADADAD;font-weight: bold;font-family:'Roboto', sans-serif;" href="#tab5" class="active btn m-1 p-2 px-3" id="tab-5" data-bs-toggle="tab">Buy
                                                </a>
                                            </li>
                                            <li>
                                                <a style="color: #ADADAD;font-weight: bold;font-family:'Roboto', sans-serif;" href="#tab6" class="btn m-1 p-2 px-3" data-bs-toggle="tab">Sell

                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="panel-body tabs-menu-body">
                                    <div class="tab-content">
                                        <div class="tab-pane active " id="tab5">
                                            <?php include('ai_buyTrade.php') ?>
                                        </div>
                                        <div class="tab-pane " id="tab6">
                                            <?php include('ai_sellTrade.php') ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="page-title-box mb-0 pb-3">
                        <h4 class="text-capitalize mb-0">ALL Ai trades for current customer</h4>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="card mini-stats-wid border-rounded-13 border-light-primary">
                        <div class="card-body">
                            <table class="table datatable table-striped dt-responsive nowrap w-100">
                                <thead>
                                    <tr class="text-uppercase">
                                        <td>#</td>
                                        <td>Trade By</td>
                                        <td>Date</td>
                                        <td>Type</td>
                                        <td>Asset</td>
                                        <td>Cost</td>
                                        <td>Duration</td>
                                        <td>Market</td>
                                        <td>$ Profit/Loss</td>
                                        <td>Status</td>
                                        <td>Win/Loss Status</td>
                                    </tr>
                                </thead>

                                <tbody>

                                    <?php
                                    $db_conn = connect_to_database();
                                    $account_email = $investor_data["email_address"];
                                    $row = 1;
                                    $ai = "Ai";

                                    $stmt = $db_conn->prepare("SELECT * FROM `trades` WHERE userEmail = ? and trade_by = ? order by id desc");
                                    $stmt->bind_param("ss", $account_email, $ai);
                                    $stmt->execute();
                                    $result = $stmt->get_result();

                                    while ($rows = mysqli_fetch_array($result)) {

                                    ?>
                                        <tr>
                                            <td>
                                                <?php echo $row++ ?>
                                            </td>
                                            <td>
                                                <?php echo $rows['trade_by'] ?>
                                            </td>
                                            <td>
                                                <?php echo date("Y/M/d h:i a", strtotime($rows["tradeSet"])) ?>
                                            </td>
                                            <td>
                                                <?php echo $rows["type"] ?>
                                            </td>
                                            <td>
                                                <?php echo $rows["asset"] ?>
                                            </td>
                                            <td>
                                                $<?php echo $rows["stakeAmt"] ?>
                                            </td>
                                            <td>
                                                <?php echo $rows["duration"] ?>
                                            </td>
                                            <td>
                                                <?php echo $rows["market"] ?>
                                            </td>
                                            <td>
                                                $ <?php echo $rows["profitLoss"] ?>
                                            </td>
                                            <td>
                                                <?php
                                                if ($rows["status"] == 1) {
                                                    echo '<span><h6 class="text-warning">Pending..</h6></span>';
                                                } elseif ($rows["status"] == 2) {
                                                    echo '<span ><h6 class="text-success">Completed</h6></span>';
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                if ($rows["winLoss"] == 1) {
                                                    echo '<span><h6 class="text-info">Trade on..</h6></span>';
                                                } elseif ($rows["winLoss"] == 2) {
                                                    echo '<span ><h6 class="text-success">+ Win</h6></span>';
                                                } elseif ($rows["winLoss"] == 3) {
                                                    echo '<span class="text-danger"><h6>- Loss</h6></span>';
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                    <?php } ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <hr style="border: 3px solid grey;">
                <div class="col-12">
                    <div class="page-title-box mb-0 pb-3">
                        <h4 class="text-capitalize mb-0">Manage Pending Ai Plans Request</h4>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="card mini-stats-wid border-rounded-13 border-light-primary">
                        <div class="card-body">
                            <table class="table datatable table-striped dt-responsive nowrap w-100">
                                <thead>
                                    <tr class="text-uppercase">
                                        <th>Delete</th>
                                        <th>AI Plan</th>
                                        <th>Amount</th>
                                        <th>Win Rate</th>
                                        <th>Created On</th>
                                        <th>Duration</th>
                                        <th>Plan Status</th>
                                        <th>Manage Ai Subscription </th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                    $db_conn = connect_to_database();

                                    $stmt = $db_conn->prepare("SELECT * FROM `ai_investments` WHERE account_id = ? order by id desc ");
                                    $stmt->bind_param("s", $investor_data["account_id"]);
                                    $stmt->execute();
                                    $result = $stmt->get_result();

                                    while ($rows = mysqli_fetch_array($result)) {
                                    ?>
                                        <tr>
                                            <td>
                                                <form method="post" action="./authAI?investor_id=<?php echo $investor_id ?>">
                                                    <input type="hidden" name="id" value="<?php echo $rows['id'] ?>">
                                                    <input type="hidden" name="status" value="<?php echo $rows['status'] ?>">
                                                    <button class="btn btn-danger btn-sm px-1 pt-1 border-0" name="ai_delete" type="submit" onclick="return confirm('This process is irreversible! Click OK to continue.');">Delete<i class='bx bx-trash'></i></button>
                                                </form>
                                            </td>

                                            <td><?php echo $rows['ai_plan'] ?></td>
                                            <td>$<?php echo number_format($rows["amount"], 2) ?></td>
                                            <td><?php echo $rows['winRate'] ?> / 100 </td>
                                            <td><?php echo date("Y/M/d h:i a", strtotime($rows['created_at'])) ?></td>
                                            <td><?php echo $rows['duration'] ?></td>
                                            <td class="fw-bold">
                                                <?php

                                                if ($rows["status"] == 2) {
                                                ?>
                                                    <button class="btn btn-soft-success border-0 btn-sm" style="padding: 3px 7px;" type="button">
                                                        Completed
                                                    </button>
                                                <?php
                                                } else if ($rows["status"] == 1) {
                                                ?>
                                                    <button class="btn btn-soft-warning border-0 btn-sm" style="padding: 3px 16px;" type="button">
                                                        Active
                                                    </button>
                                                <?php
                                                } else if ($rows["status"] == 3) {
                                                ?>
                                                    <button class="btn btn-soft-danger border-0 btn-sm" style="padding: 3px 11px;" type="button">
                                                        Cancelled
                                                    </button>
                                                <?php
                                                } else {
                                                ?>
                                                    <button class="btn btn-soft-primary border-0 btn-sm" style="padding: 3px 11px;" type="button">-- / --</button>
                                                <?php
                                                }

                                                ?>
                                            </td>
                                            <td class="d-flex justify-content-around">
                                                <form method="post" action="./authAI?investor_id=<?php echo $investor_id ?>">
                                                    <input type="hidden" name="id" value="<?php echo $rows['id'] ?>">
                                                    <input type="hidden" name="status" value="<?php echo $rows['status'] ?>">
                                                    <input type="submit" class="btn btn-success btn-sm" name="ai_complete" value="Complete" onclick="return confirm('This process is irreversible! Click OK to continue.');"><i class="fa fa-check-square-o" aria-hidden="true"></i>
                                                </form>
                                                <form method="post" action="./authAI?investor_id=<?php echo $investor_id ?>">
                                                    <input type="hidden" name="id" value="<?php echo $rows['id'] ?>">
                                                    <input type="hidden" name="status" value="<?php echo $rows['status'] ?>">
                                                    <button class="btn btn-danger btn-sm px-1 pt-1 border-0" name="ai_cancel" type="submit" onclick="return confirm('This process is irreversible! Click OK to continue.');">cancel <i class="fa fa-ban" aria-hidden="true"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php } ?>
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