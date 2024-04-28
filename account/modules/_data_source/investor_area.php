<div class="container-fluid" style="height: auto;">
    <!-- TradingView Widget BEGIN -->
    <div class="tradingview-widget-container">
        <div class="tradingview-widget-container__widget"></div>
        <div class="tradingview-widget-copyright"></div>
        <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-ticker-tape.js" async>
            {
                "symbols": [{
                        "proName": "FOREXCOM:SPXUSD",
                        "title": "S&P 500"
                    },
                    {
                        "proName": "FOREXCOM:NSXUSD",
                        "title": "US 100"
                    },
                    {
                        "proName": "FX_IDC:EURUSD",
                        "title": "EUR/USD"
                    },
                    {
                        "proName": "BITSTAMP:BTCUSD",
                        "title": "Bitcoin"
                    },
                    {
                        "proName": "BITSTAMP:ETHUSD",
                        "title": "Ethereum"
                    }
                ],
                "showSymbolLogo": true,
                "colorTheme": "dark",
                "isTransparent": false,
                "displayMode": "adaptive",
                "locale": "en"
            }
        </script>
    </div>
    <!-- TradingView Widget END -->
    <!-- start page title -->
    <div class="row text-white">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="text-capitalize"><span id="greeting">Good morning</span>, <?php echo $account_data["username"] ?>🏆</h4>
                <span>Here's a summary of the current status of your <a href="../" class="fw-bold" target="_blank">Swiftpipstraders</a> trading account.</span>
            </div>
        </div>
    </div>
    <!-- end page title -->

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
                                    <h6 class="mb-0 fw-bold">$
                                        <span id="account_balance">
                                            <?php
                                            echo $account_data["account_balance"]
                                            ?>
                                        </span>

                                    </h6>
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
                                    <p class="text-muted fw-medium">My Earnings</p>
                                    <h6 class="mb-0 fw-bold">$
                                        <span id="account_earning">
                                            <?php echo $account_data["account_earnings"] ?>
                                        </span>
                                    </h6>
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
                                    <h6 class="mb-0 fw-bold"><?php echo $account_data["investment_plan"] ?></h6>
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
                                    <h6 class="mb-0 fw-bold">$
                                        <span id="account_invested">
                                            <?php echo $account_data["amount_invested"] ?>
                                        </span>
                                    </h6>
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

                <div class="col-md-3">
                    <div class="card mini-stats-wid border-rounded-13 border-light-primary">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <p class="text-muted fw-medium">Pending Deposits</p>
                                    <h6 class="mb-0 fw-bold">
                                        <span id="pending_deposits"><?php echo $pending_deposits ?></span>
                                        Pending
                                    </h6>
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
                                    <h6 class="mb-0 fw-bold">
                                        <span id="pending_withdrawals">
                                            <?php echo $pending_withdrawals ?>
                                        </span> Pending
                                    </h6>
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
                                    <p class="text-muted fw-medium"> Total Deposits</p>
                                    <h6 class="mb-0 fw-bold">$
                                        <span id="total_deposits">
                                            <?php echo $total_deposits ?>
                                        </span>
                                    </h6>
                                </div>

                                <div class="flex-shrink-0 align-self-center">
                                    <div class="mini-stat-icon avatar-xs rounded bg-primary">
                                        <span class="avatar-title">
                                            <i class="bx bx-receipt font-size-16"></i>
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
                                    <p class="text-muted fw-medium">Total Withdrawals</p>
                                    <h6 class="mb-0 fw-bold">$
                                        <span id="total_withdrawals">
                                            <?php echo $total_withdrawals ?>
                                        </span>
                                    </h6>
                                </div>

                                <div class="flex-shrink-0 align-self-center">
                                    <div class="mini-stat-icon avatar-xs rounded bg-primary">
                                        <span class="avatar-title">
                                            <i class="bx bx-receipt font-size-16"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="card mini-stats-wid border-rounded-13 border-light-primary" style="height: 550px;">
                        <div class="card-body">
                            <!-- TradingView Widget BEGIN -->
                            <div class="tradingview-widget-container" style="height:100%;width:100%">
                                <div id="analytics-platform-chart-demo" style="height:calc(100% - 32px);width:100%"></div>
                                <div class="tradingview-widget-copyright"><a href="https://www.tradingview.com/" rel="noopener nofollow" target="_blank"><span class="blue-text">Track all markets on TradingView</span></a></div>
                                <script type="text/javascript" src="https://s3.tradingview.com/tv.js"></script>
                                <script type="text/javascript">
                                    new TradingView.widget({
                                        "container_id": "analytics-platform-chart-demo",
                                        "width": "100%",
                                        "height": "100%",
                                        "autosize": true,
                                        "symbol": "EUR/USD",
                                        "interval": "D",
                                        "timezone": "exchange",
                                        "theme": "dark",
                                        "style": "0",
                                        "withdateranges": true,
                                        "allow_symbol_change": true,
                                        "save_image": false,
                                        "details": true,
                                        "hotlist": true,
                                        "calendar": true,
                                        "locale": "en"
                                    });
                                </script>
                            </div>
                            <!-- TradingView Widget END -->
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
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
                                            <li>
                                                <a style="color: #ADADAD;font-weight: bold;font-family:'Roboto', sans-serif;" href="#tab7" class="btn m-1 p-2 px-2" data-bs-toggle="tab">Convert
                                                </a>
                                            </li>
                                            <!-- <li><a href="#tab8" data-bs-toggle="tab">Tab 4</a></li> -->
                                        </ul>
                                    </div>
                                </div>
                                <div class="panel-body tabs-menu-body">
                                    <div class="tab-content">
                                        <div class="tab-pane active " id="tab5">
                                            <?php include('investor-buyform.php') ?>
                                        </div>
                                        <div class="tab-pane " id="tab6">
                                            <?php include('investor-sellform.php') ?>
                                        </div>
                                        <div class="tab-pane " id="tab7">
                                            <!-- Crypto Converter ⚡ Widget -->
                                            <crypto-converter-widget shadow symbol live background-color="#383a59" border-radius="0.87rem" fiat="united-states-dollar" crypto="bitcoin" amount="1" font-family="sans-serif" decimal-places="2"></crypto-converter-widget>
                                            <a href="#" target="_blank" rel="noopener">
                                            </a>
                                            <script async src="https://cdn.jsdelivr.net/gh/dejurin/crypto-converter-widget@1.5.2/dist/latest.min.js">
                                            </script>
                                            <!-- /Crypto Converter ⚡ Widget -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card mini-stats-wid border-rounded-13 border-light-primary" style="height:auto;">
                        <div class="card-header">
                            <h3 class="card-title">Latest Trade History </h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table datatable table-bordered text-nowrap text-light border-bottom w-100" id="tradeTable" style="border-radius: 5px;">
                                    <thead>
                                        <tr>
                                            <td class="wd-15p border-bottom-0">#</td>
                                            <td class="wd-15p border-bottom-0">Trade By</td>
                                            <td class="wd-15p border-bottom-0">Date</td>
                                            <td class="wd-15p border-bottom-0">Type</td>
                                            <td class="wd-15p border-bottom-0">Asset</td>
                                            <td class="wd-15p border-bottom-0">Cost</td>
                                            <td class="wd-15p border-bottom-0">Duration</td>
                                            <td class="wd-15p border-bottom-0">Market</td>
                                            <td class="wd-15p border-bottom-0">$ Profit/Loss</td>
                                            <td class="wd-15p border-bottom-0">Status</td>
                                            <td class="wd-15p border-bottom-0">Win/Loss Status</td>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php
                                        $db_conn = connect_to_database();
                                        $account_email = $account_data["email_address"];
                                        $row = 1;

                                        $stmt = $db_conn->prepare("SELECT * FROM `trades` WHERE userEmail = ? order by id desc limit 25");
                                        $stmt->bind_param("s", $account_email);
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
                </div>
            </div>
            <!-- end row -->

        </div>
    </div>
    <!-- end row -->
</div> <!-- container-fluid -->

<?php include "investor_modals.php" ?>