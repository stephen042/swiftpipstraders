<form class="needs-validation" method="post" novalidate>
    <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="form-group col-12">
            <input type="hidden" name="account_id" value="<?php echo $investor_data["account_id"] ?>">
            <input type="hidden" name="market" value="Sell">
            <label class="form-label text-bold">Type:
                <i class="fa fa-question-circle" data-bs-placement="top" data-bs-toggle="tooltip" title="Choose your choice of market"></i>
            </label>
            <select class="form-control form-select select2 type" name="type" style="width: 100%;" data-bs-placeholder="Select">
                <option disabled selected>Select type</option>
                <option id="crypto" value="Crypto">Crypto</option>
                <option id="stocks" value="Stocks">Stocks</option>
                <option id="forex" value="Forex">Forex</option>
            </select>
        </div>
        <div class="cyt">
            <div class="form-group col-12">
                <label class="form-label text-bold">Asset: <i class="fa fa-question-circle" data-bs-placement="top" data-bs-toggle="tooltip" title="Pair to stake/trade on"></i></label>
                <select class="form-control form-select select2 cyt" name="asset" style="width: 100%;" data-bs-placeholder="Select">
                    <option value="XRP">Ripple XRP $0.00</option>
                    <option value="EVMOS">Evmos EVMOS $0.00</option>
                    <option value="LN">Link LN $0.00</option>
                    <option value="AURORA">Aurora AURORA $0.00</option>
                    <option value="BTC">Bitcoin BTC $0.00</option>
                    <option value="MANA">Decentraland MANA $0.00</option>
                    <option value="GT">Token GT $0.00</option>
                    <option value="ETH">Ethereum ETH $0.00</option>
                    <option value="TLOS">Telos TLOS $0.00</option>
                    <option value="ETC">Ethereum Classic ETC $0.00</option>
                    <option value="USDC">USD Coin USDC $0.00</option>
                    <option value="ZEC">Zcash ZEC $0.00</option>
                    <option value="BCH">Bitcoin Cash BCH $0.00</option>
                </select>
            </div>
        </div>
        <div class="stk">
            <div class="form-group col-12">
                <label class="form-label text-bold">Asset:</label>
                <select class="form-control form-select select2 stk" name="asset" style="width: 100%;" data-bs-placeholder="Select">
                    <option value="ASML">ASML ASML $0.00</option>
                    <option value="TSLA">Tesla TSLA $0.00</option>
                    <option value="COST">Costco COST $0.00</option>
                    <option value="CL">Colgate-Palmolive CL $0.00</option>
                    <option value="CCO">Clear Channel Outdoor CCO $0.00</option>
                    <option value="PG">Procter &amp; Gamble PG $0.00</option>
                    <option value="GM">General Motors GM $0.00</option>
                    <option value="BABA">Alibaba BABA $0.00</option>
                    <option value="MSI">Motorola MSI $0.00</option>
                    <option value="WFC">Wells Fargo WFC $0.00</option>
                    <option value="RKLB">Rocket Lab RKLB $0.00</option>
                    <option value="GOOGL">Google GOOGL $0.00</option>
                    <option value="RWLK">ReWalk Robotics RWLK $0.00</option>
                    <option value="NVS">Novartis NVS $0.00</option>
                    <option value="NVDA">Nvidia NVDA $0.00</option>
                    <option value="ADBE">Adobe ADBE $0.00</option>
                    <option value="AMD">AMD AMD $0.00</option>
                    <option value="FB">Meta Platforms Inc FB $0.00</option>
                    <option value="RL">Ralph Lauren RL $0.00</option>
                </select>
            </div>
        </div>
        <div class="fx">
            <div class="form-group col-12">
                <label class="form-label text-bold">Asset:</label>
                <select class="form-control form-select select2 fx" name="asset" style="width: 100%;" data-bs-placeholder="Select">
                    <option value="AUDCAD">AUD/CAD</option>
                    <option value="USDCHF">USD/CHF</option>
                    <option value="CHFJPY">CHF/JPY</option>
                    <option value="GBPUSD">GBP/USD</option>
                    <option value="EURAUD">EUR/AUD</option>
                    <option value="EURCHF">EUR/CHF</option>
                    <option value="AUDUSD">AUD/USD</option>
                    <option value="AUDNZD">AUD/NZD</option>
                    <option value="AUDJPY">AUD/JPY</option>
                    <option value="EURJPY">EUR/JPY</option>
                    <option value="GBPJPY">GBP/JPY</option>
                    <option value="EURUSD">EUR/USD</option>
                    <option value="NZDUSD">NZD/USD</option>
                    <option value="EURCAD">EUR/CAD</option>
                    <option value="EURGBP">EUR/GBP</option>
                    <option value="GBPCHF">GBP/CHF</option>
                </select>
            </div>
        </div>

        <div class="rdata">
            <div class="form-group col-12" id="amount">
                <label>Amount: <i class="fa fa-question-circle" data-bs-placement="top" data-bs-toggle="tooltip" title="staking amount in USD $"></i></label>
                <input style="border: 1px solid red;" type="number" name="amount" class="form-control amount" value="">
                <span class="input-group-text mt-1" id="validatedInputGroupPrepend">
                    <span class="">Current balance:</span>
                    <span class="text-success ms-1">
                        $ <?php echo number_format($investor_data['account_balance'], 2) ?>
                    </span>
                </span>
            </div>
            <div class="form-group col-12">
                <label class="form-label text-bold">Duration:
                    <i class="fa fa-question-circle" data-bs-placement="top" data-bs-toggle="tooltip" title="Your Trade will auto close at the chosen time"></i>
                </label>
                <select class="form-control form-select select2" name="duration" style="width: 100%;" data-bs-placeholder="Select">
                    <option value="2 minutes">2 minutes</option>
                    <option value="5 minutes">5 minutes</option>
                    <option value="10 minutes">10 minutes</option>
                    <option value="30 minutes">30 minutes</option>
                    <option value="1 hour">1 hour</option>
                    <option value="2 hours">2 hours</option>
                    <option value="4 hours">4 hours</option>
                    <option value="6 hours">6 hours</option>
                    <option value="8 hours">8 hours</option>
                    <option value="10 hours">10 hours</option>
                    <option value="20 hours">20 hours</option>
                    <option value="1 day">1 day</option>
                    <option value="2 days">2 days</option>
                    <option value="3 days">3 days</option>
                    <option value="4 days">4 days</option>
                    <option value="5 days">5 days</option>
                    <option value="6 days">6 days</option>
                    <option value="1 weeks">1 weeks</option>
                    <option value="2 weeks">2 weeks</option>
                </select>
            </div>
        </div>
    </div>
    <input name="by" value="Ai" type="hidden">
    <button class="btn btn-danger mt-4 mb-0 col-12 sbt" type="submit" name="sellTrade" disabled>Trade</button>
</form>