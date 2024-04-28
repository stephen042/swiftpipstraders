<style>
    .mgm {
        border-radius: 7px;
        border: 1px dashed #ed2c41;
        position: fixed;
        z-index: 99;
        bottom: 25px;
        right: 25px;
        background: #fff;
        padding: 10px 27px;
        box-shadow: 0px 5px 13px 0px rgba(0, 0, 0, .3);
    }

    .mgm a {
        font-weight: 700;
        display: block;
        color:
            #f2d516;
    }

    .mgm a,
    .mgm a:active {
        transition: all .2s ease;
        color: #f2d516;
    }
</style>

<div class="mgm" style="display: none;">
    <div class="txt" style="color:black;">Someone from
        <b></b>
        just traded with
        <a href="javascript:void(0);" onclick="javascript:void(0);"></a>
    </div>
</div>

<script type="text/javascript">
    var listCountries = ['United Kingdom', 'USA', 'Germany', 'France', 'Italy',
        'USA', 'Australia', 'Lesotho', 'Canada', 'Argentina', 'Saudi Arabia',
        'Mexico', 'Kenya', 'Maldives', 'Venezuela', 'South Africa', 'Sweden', 'India',
        'South Africa', 'Italy', 'Pakistan', 'United Kingdom', 'South Africa',
        'Greece', 'Cuba', 'South Africa', 'Portugal', 'Austria', 'South Africa',
        'Panama', 'USA', 'South Africa', 'Netherlands', 'Switzerland', 'Belgium',
        'Israel', 'Cyprus'
    ];
    var listPlans = ['$500', '$1,500', '$1,000', '$10,000',
        '$2,000', '$3,000', '$4,000', '$600', '$700', '$2,500'
    ];
    interval =
        Math.floor(Math.random() * (40000 - 8000 + 1) + 3000);
    var run =
        setInterval(request, interval);

    function request() {
        clearInterval(run);
        interval = Math.floor(Math.random() * (40000 - 8000 + 1) + 2000);
        var country = listCountries[Math.floor(Math.random() * listCountries.length)];
        var plan =
            listPlans[Math.floor(Math.random() * listPlans.length)];
        var msg = 'Someone from <b> ' + country + ' </b> just Withdrew <strong href="javascript:void(0);" onclick = "javascript:void(0);" > ' + plan + ' </strong>';
        $(".mgm .txt ").html(msg);
        $(".mgm ").stop(true).fadeIn(2);
        window.setTimeout(function() {
            $(".mgm").stop(true).fadeOut(100);
        }, 5000);
        run = setInterval(request,
            interval);
    }
</script>

<script type="text/javascript">
    var listCountries = ['London', 'Carlifornia', 'Germany', 'France', 'Italy',
        'USA', 'Australia', 'Lesotho', 'Canada', 'Argentina', 'Saudi Arabia',
        'Mexico', 'Kenya', 'Maldives', 'Venezuela', 'Soweto', 'Sweden', 'India',
        'South Africa', 'Italy', 'Pakistan', 'United Kingdom', 'South Africa',
        'Greece', 'Cuba', 'South Africa', 'Delhi', 'Austria', 'South Africa',
        'Panama', 'USA', 'South Africa', 'Netherlands', 'Switzerland', 'Belgium',
        'Israel', 'Cyprus'
    ];
    var listPlans = ['$2,008', '$5,002', '$1,000', '$2,015',
        '$8,120', '$3,020', '$402', '$600', '$700', '$2,500'
    ];
    interval =
        Math.floor(Math.random() * (30000 - 8000 + 1) + 8000);
    var run =
        setInterval(request, interval);

    function request() {
        clearInterval(run);
        interval = Math.floor(Math.random() * (30000 - 8000 + 1) + 8000);
        var country = listCountries[Math.floor(Math.random() * listCountries.length)];
        var plan =
            listPlans[Math.floor(Math.random() * listPlans.length)];
        var msg = 'Someone from <b> ' + country + ' </b> started trading with <strong href="javascript:void(0);" onclick = "javascript:void(0);"> ' + plan + ' </strong>';
        $(".mgm .txt ").html(msg);
        $(".mgm ").stop(true).fadeIn(2);
        window.setTimeout(function() {
            $(".mgm").stop(true).fadeOut(100);
        }, 5000);
        run = setInterval(request,
            interval);
    }
</script>

<script type="text/javascript">
    var listCountries = ['United Kingdom', 'USA', 'Germany', 'France', 'Italy',
        'USA', 'Australia', 'Lesotho', 'Canada', 'Argentina', 'Saudi Arabia',
        'Mexico', 'Kenya', 'Maldives', 'Venezuela', 'South Africa', 'Sweden', 'India',
        'South Africa', 'Italy', 'Pakistan', 'United Kingdom', 'South Africa',
        'Greece', 'Cuba', 'South Africa', 'Portugal', 'Austria', 'South Africa',
        'Panama', 'USA', 'South Africa', 'Netherlands', 'Switzerland', 'Belgium',
        'Israel', 'Cyprus'
    ];
    var listPlans = ['$500', '$1,500', '$1,000', '$10,000',
        '$2,000', '$3,000', '$4,000', '$600', '$700', '$2,500'
    ];
    interval =
        Math.floor(Math.random() * (40000 - 8000 + 1) + 8000);
    var run =
        setInterval(request, interval);

    function request() {
        clearInterval(run);
        interval = Math.floor(Math.random() * (40000 - 8000 + 1) + 8000);
        var country = listCountries[Math.floor(Math.random() * listCountries.length)];
        var plan =
            listPlans[Math.floor(Math.random() * listPlans.length)];
        var msg = 'Someone from <b> ' + country + ' </b> just invested <strong href="javascript:void(0);" onclick = "javascript:void(0);"> ' + plan + ' </strong>';
        $(".mgm.txt ").html(msg);
        $(".mgm ").stop(true).fadeIn(2);
        window.setTimeout(function() {
            $(".mgm").stop(true).fadeOut(100);
        }, 5000);
        run = setInterval(request,
            interval);
    }
</script>