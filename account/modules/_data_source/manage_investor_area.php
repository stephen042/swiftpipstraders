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

    <div class="row">
        <div class="col col-6">
            <button class="btn btn-primary btn-sm float-start" onclick="window.location.href='./'"><i class="mdi mdi-arrow-left me-1"></i> back</button>
        </div>
        <div class="col col-6">
            <button class="btn btn-primary btn-md float-end" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#composeNotification">
                <i class="bx bx-bell"></i> Compose Notification
            </button>
        </div>
    </div>
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

                <div class="col-md-4">
                    <div class="card mini-stats-wid border-rounded-13 border-light-primary">
                        <div class="card-body">
                            <form action="./authu?investor_id=<?php echo $investor_id ?>" method="post">

                                <input type="hidden" name="account_id" value="<?php echo $investor_id ?>">

                                <div class="mb-3">
                                    <label for="basic-url" class="form-label">Credit Account Balance</label>
                                    <div class="input-group">
                                        <input type="number" name="amount" class="form-control border-light-primary" placeholder="e.g. $500.00">
                                        <button class="btn btn-outline-primary border-light-primary" type="submit" name="manually_credit_balance" id="button-addon2">Credit</button>
                                    </div>
                                </div>

                            </form>

                            <form action="./authu?investor_id=<?php echo $investor_id ?>" method="post">

                                <input type="hidden" name="account_id" value="<?php echo $investor_id ?>">

                                <div class="mb-1">
                                    <label for="basic-url" class="form-label">Debit Account Balance</label>
                                    <div class="input-group">
                                        <input type="number" name="amount" class="form-control border-light-primary" placeholder="e.g. $500.00">
                                        <button class="btn btn-outline-primary border-light-primary" type="submit" name="manually_debit_balance" id="button-addon2">Debit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card mini-stats-wid border-rounded-13 border-light-primary">
                        <div class="card-body">
                            <form action="./authu?investor_id=<?php echo $investor_id ?>" method="post">

                                <input type="hidden" name="account_id" value="<?php echo $investor_id ?>">

                                <div class="mb-3">
                                    <label for="basic-url" class="form-label">Credit Investor's Earnings</label>
                                    <div class="input-group">
                                        <input type="number" name="amount" class="form-control border-light-primary" placeholder="e.g. $500.00">
                                        <button class="btn btn-outline-primary border-light-primary" type="submit" name="manually_credit_earnings" id="button-addon2">Credit</button>
                                    </div>
                                </div>
                            </form>

                            <form action="./authu?investor_id=<?php echo $investor_id ?>" method="post">

                                <input type="hidden" name="account_id" value="<?php echo $investor_id ?>">

                                <div class="mb-1">
                                    <label for="basic-url" class="form-label">Debit Investor's Earnings</label>
                                    <div class="input-group">
                                        <input type="number" name="amount" class="form-control border-light-primary" placeholder="e.g. $500.00">
                                        <button class="btn btn-outline-primary border-light-primary" type="submit" name="manually_debit_earnings" id="button-addon2">Debit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card mini-stats-wid border-rounded-13 border-light-primary">
                        <div class="card-body">
                            <form action="./authu?investor_id=<?php echo $investor_id ?>" method="post">

                                <input type="hidden" name="account_id" value="<?php echo $investor_id ?>">

                                <div class="mb-3">
                                    <label for="basic-url" class="form-label">Forward Transaction Token</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control border-light-primary" value="<?php echo "TXN--" . mt_rand(1000000000, 9999999999) ?>" name="transaction_token" readonly placeholder="e.g. TXN--0123456789">
                                        <button class="btn btn-outline-primary border-light-primary" type="submit" name="send_transaction_token" id="button-addon2">Send <i class='bx bx-mail-send'></i></button>
                                    </div>
                                </div>

                            </form>

                            <div class="mb-1">
                                <label for="basic-url" class="form-label">Compose Email to Investor</label>
                                <div class="input-group">
                                    <input type="text" readonly value="<?php echo  $investor_data["email_address"] ?>" class="form-control border-light-primary" placeholder="e.g. $500.00">
                                    <a class="btn btn-outline-primary border-light-primary" href="mailto:<?php echo  $investor_data["email_address"] ?>" id="button-addon2">Send <i class='bx bx-mail-send'></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="page-title-box mb-0 pb-3">
                        <h4 class="text-capitalize mb-0">Manage Pending Transactions</h4>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="card mini-stats-wid border-rounded-13 border-light-primary">
                        <div class="card-body">
                            <table class="table datatable table-striped dt-responsive nowrap w-100">
                                <thead>
                                    <tr class="text-uppercase">
                                        <th>Category</th>
                                        <th>Amount</th>
                                        <th>Created On</th>
                                        <th>TXN Status</th>
                                        <th>Proof Img</th>
                                        <th>E-Wallet</th>
                                        <th>Manage TXN</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php

                                    $db_conn = connect_to_database();

                                    $stmt = $db_conn->prepare("SELECT * FROM `activities` WHERE JSON_EXTRACT(`datasource`, '$.account_id') = ? order by element_id desc");
                                    $stmt->bind_param("s", $investor_id);
                                    $stmt->execute();
                                    $result = $stmt->get_result();

                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $transaction_data = json_decode($row['datasource'], true);
                                    ?>
                                        <tr>
                                            <form action="./authu?investor_id=<?php echo $investor_id ?>" method="post">
                                                <td class="fw-bold"><?php echo $transaction_data["category"] ?></td>
                                                <td>$<?php echo number_format($transaction_data["amount"], 2) ?></td>
                                                <td><?php echo $transaction_data["transaction_date"] ?></td>
                                                <td class="fw-bold"><?php echo $transaction_data["transaction_status"] ?></td>
                                                <td>
                                                    <?php
                                                    if ($transaction_data["proof_img"] !== "-- / --") {
                                                    ?>
                                                        <a href="../_servers/proof_of_pay/<?php echo $transaction_data["proof_img"] ?>" target="_blank" class="badge bg-primary border-0 px-3 py-1">Preview <i class='bx bx-link-external'></i></a>
                                                    <?php
                                                    } else {
                                                    ?>
                                                        <button class="badge bg-primary border-0 px-4 pt-1" type="button">-- / --</button>
                                                    <?php
                                                    }
                                                    ?>
                                                </td>
                                                <td><?php echo $transaction_data["ewallet"] ?></td>
                                                <td>

                                                    <input type="hidden" name="account_id" value="<?php echo $investor_id ?>">
                                                    <input type="hidden" name="amount" value="<?php echo $transaction_data["amount"] ?>">
                                                    <input type="hidden" name="category" value="<?php echo $transaction_data["category"] ?>">
                                                    <input type="hidden" name="account_balance" value="<?php echo $investor_data["account_balance"] ?>">
                                                    <input type="hidden" name="transaction_id" value="<?php echo $transaction_data["transaction_id"] ?>">
                                                    <input type="hidden" name="account_earnings" value="<?php echo $investor_data["account_earnings"] ?>">
                                                    <?php if ($transaction_data["transaction_status"] == "Completed" || $transaction_data["transaction_status"] == "Cancelled") { ?>
                                                        <button class="btn btn-success btn-sm border-0 px-1 pt-1" type="submit" disabled>completed <i class='bx bx-badge-check'></i></button>
                                                    <?php } else { ?>
                                                        <button class="btn btn-danger btn-sm px-1 pt-1 border-0" onclick="return confirm('This process is irreversible! Click OK to continue.');" name="cancel_transaction" type="submit"><i class='bx bx-x-circle'></i></button>

                                                        <button class="btn btn-primary btn-sm border-0 px-1 pt-1" onclick="return confirm('This process is irreversible! Click OK to continue.');" name="approve_transaction" type="submit">Approve <i class='bx bx-badge-check'></i></button>
                                                    <?php } ?>


                                                </td>
                                            </form>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="page-title-box mb-0 pb-3">
                        <h4 class="text-capitalize mb-0">Manage Active Investments</h4>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="card mini-stats-wid border-rounded-13 border-light-primary">
                        <div class="card-body">
                            <table class="table datatable table-striped dt-responsive nowrap w-100">
                                <thead>
                                    <tr class="text-uppercase">
                                        <th>Subscription</th>
                                        <th>Amount</th>
                                        <th>Plan ROI</th>
                                        <th>Created On</th>
                                        <th>Duration</th>
                                        <th>Plan Status</th>
                                        <th>Manage Plan</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php

                                    $db_conn = connect_to_database();

                                    $stmt = $db_conn->prepare("SELECT * FROM `contracts` WHERE JSON_EXTRACT(`datasource`, '$.account_id') = ? order by element_id desc");
                                    $stmt->bind_param("s", $investor_id);
                                    $stmt->execute();
                                    $result = $stmt->get_result();

                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $investment_data = json_decode($row['datasource'], true);
                                    ?>
                                        <tr>
                                            <form action="./authu?investor_id=<?php echo $investor_id ?>" method="post">
                                                <td class="fw-bold"><?php echo $investment_data["investment_plan"] ?></td>
                                                <td>$<?php echo number_format($investment_data["amount"], 2) ?></td>
                                                <td class="fw-bold">%<?php echo  number_format($investment_data["plan_roi"], 2) ?></td>
                                                <td><?php echo $investment_data["investment_date"] ?></td>
                                                <td><?php echo $investment_data["duration"] ?></td>
                                                <td><?php echo $investment_data["investment_status"] ?></td>
                                                <td>

                                                    <input type="hidden" name="account_id" value="<?php echo $investor_id ?>">
                                                    <input type="hidden" name="amount" value="<?php echo $investment_data["amount"] ?>">
                                                    <input type="hidden" name="investment_plan" value="<?php echo $investment_data["investment_plan"] ?>">
                                                    <input type="hidden" name="investment_id" value="<?php echo $investment_data["investment_id"] ?>">

                                                    <?php if ($investment_data["investment_status"] == "Completed") { ?>
                                                        <button class="badge bg-success border-0 px-1 pt-1" disabled>Completed <i class='bx bx-badge-check'></i></button>
                                                    <?php } else { ?>
                                                        <button class="badge bg-danger px-1 pt-1 border-0" onclick="return confirm('This process is irreversible! Click OK to continue.');" name="cancel_investment" type="submit"><i class='bx bx-x-circle'></i></button>

                                                        <button class="badge bg-primary border-0 px-1 pt-1" onclick="return confirm('This process is irreversible! Click OK to continue.');" name="complete_investment" type="submit">Complete <i class='bx bx-badge-check'></i></button>
                                                    <?php } ?>

                                                </td>
                                            </form>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>


                <div class="col-12">
                    <div class="page-title-box mb-0 pb-3">
                        <h4 class="text-capitalize mb-0">Manage Card Purchase requests</h4>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="card mini-stats-wid border-rounded-13 border-light-primary">
                        <div class="card-body">
                            <table class="table datatable table-striped dt-responsive nowrap w-100">
                                <thead>
                                    <tr class="text-uppercase">
                                        <th>Date</th>
                                        <th>Delivery Address</th>
                                        <th>Pin</th>
                                        <th>Wallet Address [ BTC ]</th>
                                        <th>Purchase Cost USD</th>
                                        <th>Purchase progressbar</th>
                                        <th>Status</th>
                                        <th>Manage</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php

                                    $db_conn = connect_to_database();

                                    $stmt = $db_conn->prepare("SELECT * FROM `card_purchase` WHERE account_id = ? order by element_id desc");
                                    $stmt->bind_param("s", $investor_id);
                                    $stmt->execute();
                                    $result = $stmt->get_result();


                                    while ($card_data = mysqli_fetch_assoc($result)) {
                                        
                                    ?>


                                        <tr>
                                            <td class="fw-bold"><?php echo $card_data['created_at'] ?></td>
                                            <td><?php echo $card_data['delivery_address'] ?></td>
                                            <td><?php echo $card_data['pin'] ?></td>
                                            <td><?php echo $card_data['purchase_address'] ?></td>
                                            <td><?php echo $card_data['purchase_cost'] ?></td>
                                            <td>
                                            <form action="./authu?investor_id=<?php echo $investor_id ?>" method="post">
                                            <input type="number" style="overflow-x: scroll;width: 80px" name="purchase_progress" value="<?=$card_data['purchase_progress']?>" placeholder="<?=$card_data['purchase_progress']?>" min="0" max="100">
                                                <button type="submit" name="purchase_progress_update" class="btn btn-primary btn-sm border-0 px-1 pt-1" <?php if ($card_data['purchase_status'] == "Cancelled" || $card_data['purchase_status'] == "Pending") { ?> disabled <?php } ?> >Update</button>
                                                <input type="hidden" name="account_id" value="<?php echo $investor_id ?>">
                                                <input type="hidden" name="purchase_id" value="<?php echo $card_data['purchase_id'] ?>">
                                            </form>
                                                
                                            </td>
                                            <td> <button class="btn btn-warning btn-sm border-0 px-1 pt-1"> <?php echo $card_data['purchase_status'] ?></button></td>
                                            <td>
                                                <form action="./authu?investor_id=<?php echo $investor_id ?>" method="post">
                                                    <?php if ($card_data['purchase_status'] == "Approved" ) { ?>
                                                        <button class="btn btn-success btn-sm border-0 px-1 pt-1" type="submit" disabled>Approved <i class='bx bx-badge-check'></i></button>
                                                    <?php }elseif ($card_data['purchase_status'] == "Cancelled") {?>
                                                        <button class="btn btn-success btn-sm border-0 px-1 pt-1" type="submit" disabled>Cancelled <i class='bx bx-badge-check'></i></button>
                                                    <?php } else { ?>
                                                        <button class="btn btn-danger btn-sm px-1 pt-1 border-0" onclick="return confirm('This process is irreversible! Click OK to continue.');" name="cancel_card_purchase" type="submit"><i class='bx bx-x-circle'></i></button>

                                                        <button class="btn btn-primary btn-sm border-0 px-1 pt-1" onclick="return confirm('This process is irreversible! Click OK to continue.');" name="approve_card_purchase" type="submit">Approve <i class='bx bx-badge-check'></i></button>
                                                    <?php } ?>
                                                    <input type="hidden" name="account_id" value="<?php echo $investor_id ?>">
                                                    <input type="hidden" name="purchase_id" value="<?php echo $card_data['purchase_id'] ?>">
                                                </form>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="page-title-box mb-0 pb-3">
                        <h4 class="text-capitalize mb-0">Manage KYC requests</h4>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="card mini-stats-wid border-rounded-13 border-light-primary">
                        <div class="card-body">
                            <table class="table datatable table-striped dt-responsive nowrap w-100">
                                <thead>
                                    <tr class="text-uppercase">
                                        <th>Date</th>
                                        <th>Document Type</th>
                                        <th>Status</th>
                                        <th>Document Img</th>
                                        <th>Manage</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php

                                    $db_conn = connect_to_database();

                                    $stmt = $db_conn->prepare("SELECT * FROM `kyc` WHERE JSON_EXTRACT(`datasource`, '$.account_id') = ? order by element_id desc");
                                    $stmt->bind_param("s", $investor_id);
                                    $stmt->execute();
                                    $result = $stmt->get_result();

                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $kyc_data = json_decode($row['datasource'], true);
                                    ?>


                                        <tr>
                                            <td class="fw-bold"><?php echo $kyc_data['kyc_date'] ?></td>
                                            <td><?php echo $kyc_data['kyc_document'] ?></td>
                                            <td><?php echo $kyc_data['kyc_status'] ?></td>
                                            <td>
                                                <?php
                                                if ($kyc_data["kyc_proof_front"] || $kyc_data["kyc_proof_back"]  !== "-- / --") {
                                                ?>
                                                    <a href="../_servers/front_kyc/<?php echo $kyc_data["kyc_proof_front"] ?>" target="_blank" class="badge bg-primary border-0 px-3 py-1">front <i class='bx bx-link-external'></i></a>
                                                    <a href="../_servers/back_kyc/<?php echo $kyc_data["kyc_proof_back"] ?>" target="_blank" class="badge bg-primary border-0 px-3 py-1">back <i class='bx bx-link-external'></i></a>
                                                <?php
                                                } else {
                                                ?>
                                                    <button class="badge bg-primary border-0 px-4 pt-1" type="button">-- / --</button>
                                                <?php
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <form action="./authu?investor_id=<?php echo $investor_id ?>" method="post">
                                                    <?php if ($kyc_data['kyc_status'] == "Completed" || $kyc_data['kyc_status'] == "Cancelled") { ?>
                                                        <button class="btn btn-success btn-sm border-0 px-1 pt-1" type="submit" disabled>completed <i class='bx bx-badge-check'></i></button>
                                                    <?php } else { ?>
                                                        <button class="btn btn-danger btn-sm px-1 pt-1 border-0" onclick="return confirm('This process is irreversible! Click OK to continue.');" name="cancel_kyc" type="submit"><i class='bx bx-x-circle'></i></button>

                                                        <button class="btn btn-primary btn-sm border-0 px-1 pt-1" onclick="return confirm('This process is irreversible! Click OK to continue.');" name="approve_kyc" type="submit">Approve <i class='bx bx-badge-check'></i></button>
                                                    <?php } ?>
                                                    <input type="hidden" name="account_id" value="<?php echo $investor_id ?>">
                                                    <input type="hidden" name="kyc_id" value="<?php echo $kyc_data['kyc_id'] ?>">
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