<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title" key="t-menu">Overview</li>

                <li>
                    <a href="./" class="waves-effect">
                        <i class="bx bx-home"></i>
                        <span key="t-dashboard">Dashboard</span>
                    </a>
                </li>

                <?php

                if ($account_data["account_role"] == "Manager") {
                ?>

                    <li class="menu-title" key="t-apps">Finances</li>

                    <li>
                        <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#eWallets" class="waves-effect">
                            <i class="bx bx-wallet"></i>
                            <span key="t-chat">My E-Wallets</span>
                        </a>
                    </li>

                    <li>
                        <a href="./authT" class="waves-effect">
                            <i class="bx bx-bar-chart-square"></i>
                            <span key="t-chat" class="text-light">View All Trades</span>
                        </a>
                    </li>

                <?php
                } else {
                ?>

                    <li class="menu-title" key="t-apps">Finances</li>

                    <li>
                        <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#viewAccountActivities" class="waves-effect">
                            <i class="bx bx-bar-chart-square"></i>
                            <span key="t-chat">View Activities</span>
                        </a>
                    </li>

                    <li>
                        <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#fundAccount" class="waves-effect">
                            <i class="bx bx-analyse"></i>
                            <span key="t-chat">Fund Account</span>
                        </a>
                    </li>

                    <li>
                        <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#accessAccountFunds" class="waves-effect">
                            <i class="bx bx-doughnut-chart"></i>
                            <span key="t-chat">Access Funds</span>
                        </a>
                    </li>

                    <li>
                        <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#eWallets" class="waves-effect">
                            <i class="bx bx-wallet"></i>
                            <span key="t-chat">My E-Wallets</span>
                        </a>
                    </li>

                    <li>
                        <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#activeToken" class="waves-effect">
                            <i class='bx bx-radar'></i>
                            <span key="t-chat">Active Token</span>
                        </a>
                    </li>

                    <li class="menu-title" key="t-apps">Portfolio</li>

                    <li>
                        <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#investmentPlans" class="waves-effect">
                            <i class="bx bx-gift"></i>
                            <span key="t-chat">Choose Plan</span>
                        </a>
                    </li>

                    <li>
                        <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#viewAllInvestments" class="waves-effect">
                            <i class="bx bx-receipt"></i>
                            <span key="t-chat">Investments</span>
                        </a>
                    </li>

                    <li class="menu-title" key="t-apps">Ai Overview</li>

                    <li>
                        <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#aiPlans" class="waves-effect">
                            <i class="fas fa-robot"></i>
                            <span key="t-chat">Choose Ai Plan</span>
                        </a>
                    </li>

                    <li>
                        <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#viewAllai" class="waves-effect">
                            <i class="fas fa-history"></i>
                            <span key="t-chat">Active -Ai Plans</span>
                        </a>
                    </li>

                    <li class="menu-title" key="t-apps">Utility Overview</li>

                    <li>
                        <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#orderModal" class="waves-effect">
                            <i class="fa fa-credit-card"></i>
                            <span key="t-chat">Card Order</span>
                        </a>
                    </li>

                    <li>
                        <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#KycVerification" class="waves-effect">
                            <i class="fa fa-id-card"></i>
                            <span key="t-chat">KYC verification</span>
                        </a>
                    </li>

                <?php
                }

                ?>

                <li class="menu-title" key="t-apps">Support</li>

                <li>
                    <a href="../" class="waves-effect">
                        <i class="bx bx-chat"></i>
                        <span key="t-chat">Contact Form</span>
                    </a>
                </li>

                <li>
                    <a href="../" class="waves-effect">
                        <i class="bx bx-help-circle"></i>
                        <span key="t-chat">FAQs Section</span>
                    </a>
                </li>

                <li>
                    <a href="mailto:support@Bitpips.online" class="waves-effect">
                        <i class="bx bx-mail-send"></i>
                        <span key="t-chat">Email Support</span>
                    </a>
                </li>

            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->