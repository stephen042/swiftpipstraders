<!-- JAVASCRIPT -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="./_vendors/libs/jquery/jquery.min.js"></script>
<script src="./_vendors/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="./_vendors/libs/metismenu/metisMenu.min.js"></script>
<script src="./_vendors/libs/simplebar/simplebar.min.js"></script>
<script src="./_vendors/libs/node-waves/waves.min.js"></script>
<!-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>


<!-- validation init -->
<script src="./_vendors/js/pages/validation.init.js"></script>

<!-- Required datatable js -->
<script>
    new DataTable('#tradeTable');
</script>
<script src="./_vendors/libs/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="./_vendors/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
<!-- Buttons examples -->
<script src="./_vendors/libs/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
<script src="./_vendors/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
<script src="./_vendors/libs/jszip/jszip.min.js"></script>
<script src="./_vendors/libs/pdfmake/build/pdfmake.min.js"></script>
<script src="./_vendors/libs/pdfmake/build/vfs_fonts.js"></script>
<script src="./_vendors/libs/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="./_vendors/libs/datatables.net-buttons/js/buttons.print.min.js"></script>
<script src="./_vendors/libs/datatables.net-buttons/js/buttons.colVis.min.js"></script>

<!-- Responsive examples -->
<script src="./_vendors/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="./_vendors/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>

<!-- Datatable init js -->
<script src="./_vendors/js/pages/datatables.init.js"></script>

<!-- dashboard init -->
<script src="./_vendors/js/pages/dashboard.init.js"></script>

<script>
    const now = new Date();
    const hour = now.getHours();
    const greeting = hour >= 5 && hour < 12 ? "Good morning" : hour >= 12 && hour < 16 ? "Good afternoon" : "Good evening";
    document.getElementById('greeting').textContent = `${greeting}`;
</script>

<!-- App js -->
<script src="./_vendors/js/app.js"></script>

<script>
    document.querySelectorAll('.copy-button').forEach(function(button) {
        button.addEventListener('click', function() {
            var input = document.getElementById(this.dataset.copytarget);
            input.select();
            input.setSelectionRange(0, 99999);

            try {
                document.execCommand('copy');
            } catch (err) {
                console.log('Copy failed:', err);
            }
        });
    });
</script>

<!-- Start of tidio Embed Code -->
<script src="//code.tidio.co/ais6olazjjzosfnbfvqq0fpbelcr3vsw.js" async></script>
<!-- End of tidio Embed Code -->

<script>
    document.getElementById("walletSelect").addEventListener("change", function() {
        var selectedWallet = this.value;
        var walletDivs = document.querySelectorAll("[data-wallet]");

        walletDivs.forEach(function(walletDiv) {
            walletDiv.classList.toggle("d-none", walletDiv.dataset.wallet !== selectedWallet);
        });
    });
</script>

<script type="text/javascript">
    function googleTranslateElementInit() {
        new google.translate.TranslateElement({
            pageLanguage: 'en'
        }, 'google_translate_element');
    }
</script>

<script type="text/javascript" src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

<!-- script for BUY and SELL -->
<script>
    $(document).ready(function() {
        $(".stk").hide();
        $(".cyt").hide();
        $(".fx").hide();
        $(".rdata").hide();

        $(document).on("change", ".type", function() {
            var value = $(this).val();
            $(".stk").toggle(value === "Stocks").prop("disabled", value !== "Stocks");
            $(".cyt").toggle(value === "Crypto").prop("disabled", value !== "Crypto");
            $(".fx").toggle(value === "Forex").prop("disabled", value !== "Forex");
            $(".rdata").show();
        });

        $(document).on("keyup", ".amount", function() {
            var value = $(this).val();
            if (value != "" && value >= 10) {
                $(".amount").attr("style", "border: 1px solid green");
                $(".sbt").attr("disabled", false);
            }
        });
    });
</script>

<!-- script for auto count -->
<script>
    // for account count
    document.addEventListener("DOMContentLoaded", () => {
        const count = document.querySelector("#account_balance");

        const maxNumber = parseFloat(count.innerHTML);

        let countNo = 0;
        const interval = setInterval(() => {
            if (countNo >= maxNumber) {
                clearInterval(interval);
            } else {
                countNo += 10;
                count.innerHTML = countNo.toLocaleString();
            }
        }, 5);
    });

    // for earning count
    document.addEventListener("DOMContentLoaded", () => {
        const count = document.querySelector("#account_earning");

        const maxNumber = parseFloat(count.innerHTML);

        let countNo = 0;
        const interval = setInterval(() => {
            if (countNo >= maxNumber) {
                clearInterval(interval);
            } else {
                countNo += 10;
                count.innerHTML = countNo.toLocaleString();
            }
        }, 10);
    });

    // for invested amount
    document.addEventListener("DOMContentLoaded", () => {
        const count = document.querySelector("#account_invested");

        const maxNumber = parseFloat(count.innerHTML);

        let countNo = 0;
        const interval = setInterval(() => {
            if (countNo >= maxNumber) {
                clearInterval(interval);
            } else {
                countNo += 10;
                count.innerHTML = countNo.toLocaleString();
            }
        }, 10);
    });


    // for pending_withdrawals 
    document.addEventListener("DOMContentLoaded", () => {
        const count = document.querySelector("#pending_withdrawals");

        const maxNumber = parseFloat(count.innerHTML);

        let countNo = 0;
        const interval = setInterval(() => {

            if (countNo >= maxNumber) {
                clearInterval(interval);
            } else {
                countNo += 10;
                count.innerHTML = countNo.toLocaleString();
            }

        }, 10);
    });

    // for pending_deposits
    document.addEventListener("DOMContentLoaded", () => {
        const count = document.querySelector("#pending_deposits");

        const maxNumber = parseFloat(count.innerHTML);

        let countNo = 0;
        const interval = setInterval(() => {

            if (countNo >= maxNumber) {
                clearInterval(interval);
            } else {
                countNo += 10;
                count.innerHTML = countNo.toLocaleString();
            }

        }, 10);
    });

    // for total_deposits 
    document.addEventListener("DOMContentLoaded", () => {
        const count = document.querySelector("#total_deposits");

        const maxNumber = parseFloat(count.innerHTML);

        let countNo = 0;
        const interval = setInterval(() => {
            if (countNo >= maxNumber) {
                clearInterval(interval);
            } else {
                countNo += 10;
                count.innerHTML = countNo.toLocaleString();
            }
        }, 10);
    });

    // for total_withdrawals 
    document.addEventListener("DOMContentLoaded", () => {
        const count = document.querySelector("#total_withdrawals");

        const maxNumber = parseFloat(count.innerHTML);

        let countNo = 0;
        const interval = setInterval(() => {
            if (countNo >= maxNumber) {
                clearInterval(interval);
            } else {
                countNo += 10;
                count.innerHTML = countNo.toLocaleString();
            }
        }, 10);
    });
</script>

<!-- for read notification -->
<script>
    $(document).ready(function() {
        // $('#readButton').click(function() {
        //     // Perform AJAX request
        //     let noft_id = $('#noft_id').val();
        //     // console.log(noft_id);
        //     $.ajax({
        //         url: '../_servers/initialize.php',
        //         method: 'POST',
        //         dataType: 'json',
        //         data: {
        //             action: 'read',
        //             noft_id: noft_id,
        //         },
        //         success: function(response) {
        //             // Request was successful
        //             $("#readButton").css("display", "none");
        //             $("#notification").css("background-color", "transparent");
        //             console.log(response);
        //         },
        //         error: function(xhr, status, error) {
        //             // Request failed
        //             console.error('Request failed. Status: ' + status + ', Error: ' + error);
        //         }
        //     });
        // });

        // checking card pin length
        $("#card_pin").keyup(function() {
            if ($(this).val().length !== 4) {
                $("#card_pin_error").text("Card pin must be 4 digits");
                $("#card_pin").css("border", "1px solid red");
                return false
            }
            $("#card_pin").css("border", "1px solid green");
            $("#card_pin_error").text(" ");
            return true
        })
    });
</script>