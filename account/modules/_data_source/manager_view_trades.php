<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="text-capitalize"><span>All Live Trades</span></h4>
                <span>Here's a summary of the current status of all live trades.</span>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <button class="btn btn-primary btn-sm" onclick="window.location.href='./'"><i class="mdi mdi-arrow-left me-1"></i> back</button>
    <hr>

    <div class="col-md-12">
        <div class="card mini-stats-wid border-rounded-13 border-light-primary">
            <div class="card-body">
                <table class="table datatable  table-hover dt-responsive nowrap w-100 text-white">
                    <thead>
                        <tr class="text-uppercase">
                            <th>Email</th>
                            <th>Trade By</th>
                            <th>Date</th>
                            <th>Type</th>
                            <th>Asset</th>
                            <th>Cost</th>
                            <th>Duration</th>
                            <th>Market</th>
                            <th>Profit/Loss $</th>
                            <th>Status</th>
                            <th>Profit/Loss status</th>
                            <th>Manage User Trade</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $db_conn = connect_to_database();
                        $account_email = $account_data["email_address"];
                        $row = 1;

                        $stmt = $db_conn->prepare("SELECT * FROM `trades` ");
                        $stmt->execute();
                        $result = $stmt->get_result();

                        while ($rows = mysqli_fetch_array($result)) {

                        ?>
                            <tr>
                                <form action="./" method="post">
                                    <td>
                                        <?php echo $rows["userEmail"] ?>
                                    </td>
                                    <td>
                                        <?php echo $rows["trade_by"] ?>
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
                                            echo '<span><h6 class="alert alert-warning">Pending..</h6></span>';
                                        } elseif ($rows["status"] == 2) {
                                            echo '<span ><h6 class="alert alert-success">Completed</h6></span>';
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        if ($rows["winLoss"] == 1) {
                                            echo '<span><h6 class="alert alert-info">Trade on..</h6></span>';
                                        } elseif ($rows["winLoss"] == 2) {
                                            echo '<span ><h6 class="badge badge-soft-success">+ Win</h6></span>';
                                        }elseif($rows["winLoss"] == 3){
                                            echo '<span class="badge badge-soft-danger"><h6>- Loss</h6></span>';
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <a href="./authTEdit?trade_id=<?=$rows["id"]?>" class="badge bg-primary border-0 px-1 pt-1">Manage <i class='bx bx-edit'></i></a>
                                    </td>
                                </form>
                            </tr>

                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>



</div>