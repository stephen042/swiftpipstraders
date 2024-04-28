<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="text-capitalize"><span id="greeting">Good morning</span>, <?php echo $account_data["username"] ?>🏆</h4>
                <span>Here's a summary of the current status of <span class="text-primary"><?php echo $investor_data["full_names"] ?>'s</span> current trade.</span>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <button class="btn btn-primary btn-sm" onclick="window.location.href='./authT.php'"><i class="mdi mdi-arrow-left me-1"></i> back</button>
    <hr>

    <?php
    if (isset($_SESSION['feedback'])) {
        $feedback = $_SESSION['feedback'];
        unset($_SESSION['feedback']);
    ?>
        <div class="alert alert-warning alert-dismissible fade show mt-n3" role="alert">
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
            </div>
        </div>
    </div>

    <!-- start -->
    <div class="row">
        <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
            <div class="card" style="background-color: #132144;">
                <div class="card-header">
                    <h4 class="card-title">Edit Trade Details</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class=" col-md-8">
                            <form class="form-horizontal" method="POST" action="./authTEdit?trade_id=<?php echo $trade_id ?>">
                                <div class=" row mb-4">
                                    <label class="col-md-3 form-label">Trade By</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" value="<?php echo $row["trade_by"] ?>" disabled>
                                    </div>
                                </div>
                                <div class=" row mb-4">
                                    <label class="col-md-3 form-label">Type</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" value="<?php echo $row["type"] ?>" disabled>
                                    </div>
                                </div>
                                <div class=" row mb-4">
                                    <label class="col-md-3 form-label" for="example-email">Asset</label>
                                    <div class="col-md-9">
                                        <input type="text" id="example-email" class="form-control" value="<?php echo $row["asset"] ?>" disabled>
                                    </div>
                                </div>
                                <div class=" row mb-4">
                                    <label class="col-md-3 form-label">Stake Amount</label>
                                    <div class="col-md-9">
                                        <input type="text" name="stakeAmt" class="form-control" value="$ <?php echo $row["stakeAmt"] ?>" readonly >
                                    </div>
                                </div>
                                <div class=" row mb-4">
                                    <label class="col-md-3 form-label">Duration</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" value="<?php echo $row["duration"] ?>" disabled>
                                    </div>
                                </div>
                                <div class=" row mb-4">
                                    <label class="col-md-3 form-label">Market</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" value="<?php echo $row["market"] ?>" disabled>
                                    </div>
                                </div>
                                <div class=" row mb-4">
                                    <label class="col-md-3 form-label">status</label>
                                    <div class="col-md-9">
                                        <?php
                                        if ($row["status"] == 1) {
                                            echo '<span><h6 class="alert alert-warning">Pending..</h6></span>';
                                        } elseif ($row["status"] == 2) {
                                            echo '<span><h6 class="alert alert-success">Completed</h6></span>';
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <label class="col-md-3 form-label text-success">Choose Win or Loss</label>
                                    <div class="col-md-9">
                                        <select name="winLoss" class="form-control form-select select2" data-bs-placeholder="Select Country" required>
                                            <option <?php if ($row["winLoss"] == 1) echo "selected" ?> value="1">Trade on..</option>
                                            <option <?php if ($row["winLoss"] == 2) echo "selected" ?> value="2">+ Win</option>
                                            <option <?php if ($row["winLoss"] == 3) echo "selected" ?> value="3">- Loss</option>
                                        </select>
                                    </div>
                                </div>
                                <div class=" row mb-4 mb-0">
                                    <label class="col-md-3 form-label text-success">Profit or Loss Amount for the trade</label>
                                    <div class="col-md-9">
                                        <input class="form-control" type="number" name="profitLoss" required value="<?php echo $row["profitLoss"] ?>" placeholder="eg 100 or 200" required>
                                        <span class="text-danger">"At win Profit will be added to earnings_bal and loss will be minus from acct_bal"</span>
                                    </div>
                                </div>
                                <input type="hidden" name="account_id" value="<?php echo $investor_data["account_id"] ?>" >
                                <input type="hidden" name="trade_id" value="<?php echo $row["id"] ?>" >
                                <div class=" row mb-4">
                                    <label class="col-md-3 form-label">Proceed</label>
                                    <div class="col-md-9">
                                        <button class="btn btn-success" name="editTrade" type="submit">Submit</button>
                                        <button class="btn btn-primary float-end" type="reset">Reset</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END ROW -->
</div>