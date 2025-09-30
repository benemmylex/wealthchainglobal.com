<a class="floating mdark" id="switcher">
    <span id="sback" class="fas fa-moon"></span>
</a>
<footer class="mt-1 py-2 border-top" style="background: linear-gradient(179deg, #724fe5 6.25%);">
    <div class="pt-2 container px-3">
        <div class="text-center">
            <h6>&copy; <?= date('Y') - 10 . ' - ' . date('Y') . ' ' . SITE_NAME; ?></h6>
            <!-- <div class="text-center">
                <a href="./markets" class="active"><i class="fas fa-chart-bar"></i>
                </a>
            </div>
            <div class="text-center">
                <a href="./deposits" class="active"><i class="fas fa-clock"></i>
                </a>
            </div>
            <div class="text-center">
                <a href="./" class="active"><i class="fas fa-home"></i>
                </a>
            </div>
            <div class="text-center">
                <a href="./upgrade" class="active"><i class="fas fa-calendar-alt"></i>
                </a>
            </div>
            <div class="text-center">
                <a href="./account" class="active"><i class="fas fa-user"></i>
                </a>
            </div> -->
        </div>
    </div>
</footer>

<!-- Modal -->
<div class="modal fade" id="langmodal" tabindex="-1" aria-labelledby="langmodal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content text-center">
            <div class="modal-header justify-content-center">
                <h3 class=""><span class="fas fa-exclamation-circle"></span> information</h3>
                <button type='button' class='btn-close' data-mdb-dismiss='modal' aria-label='Close'></button>
            </div>
            <div class="modal-body py-4 my-3">
                <div class="gtranslate_wrapper"></div>
                <div id="message">
                    <div class="mt-2">
                        <button type='button' class='btn btn-md btn-outline-danger' data-mdb-dismiss='modal' aria-label='Close'>Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal: process-->
</body>
<!--<div id="google_translate_element" style="z-index: 1500; position: fixed; bottom:16px; left:15px;"></div>-->
<!--<script type="text/javascript">-->
<!--  function googleTranslateElementInit() {-->
<!--    new google.translate.TranslateElement({pageLanguage: 'en', autoDisplay: false}, 'google_translate_element');-->
<!--  }-->
<!--</script>-->
<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
<script src="../../assets/js/mdb.min.js"></script>
<script src="../../assets/js/switchtheme.js"></script>
<script src="../../assets/js/jquery-redirect.js"></script>
<script src="../../assets/js/tiny-slider.js"></script>
<script src="../../assets/js/toastr.js"></script>
<script>
    window.gtranslateSettings = {
        "default_language": "en",
        "wrapper_selector": ".gtranslate_wrapper"
    }
</script>
<script src="https://cdn.gtranslate.net/widgets/v1.0.1/dropdown.js" defer></script>

<script>
    //Initialize it with JS to make it instantly visible
    const slimInstance = new mdb.Sidenav(document.getElementById('sidenav-1'));

    slimInstance.hide();

    const showpass = (pass, span) => {
        let password = document.getElementById(pass);
        if (password.type == 'password') {
            password.type = 'text';
            $('#' + span).html("<span class= 'fas fa-eye-slash'></span>");
        } else {
            password.type = 'password';
            $('#' + span).html("<span class= 'fas fa-eye'></span>");
        }
    }

    $("#switcher").click(function() {
        const ttt = localStorage.getItem('theme') === 'dark' ? 'light' : 'dark';
        setTheme(ttt);
    });

    if (localStorage.getItem("hidebal") == "shown" || !localStorage.getItem("hidebal")) {
        $('#showBal11').hide();
        $('#showBal13').hide();
        $('#showBal131').hide();
        $('#slashOnes').hide();
        $('#slashTwos').hide();
        $('#slashTwose').hide();
        $('#showBal21').hide();
        $('#showBal23').hide();
        $('#showBal25').hide();

        $('#showBal1').show();
        $('#showBal12').show();
        $('#slashOne').show();
        $('#slashTwo').show();
        $('#slashTwoe').show();
        $('#showBal2').show();
        $('#showBal22').show();
        $('#showBal24').show();
    } else {
        if (localStorage.getItem("hidebal") == "hidden") {
            $('#showBal11').show();
            $('#showBal13').show();
            $('#showBal131').show();
            $('#slashOne').show();
            $('#slashTwo').show();
            $('#slashTwoe').show();
            $('#showBal21').show();
            $('#showBal23').show();
            $('#showBal25').show();

            $('#showBal1').hide();
            $('#showBal12').hide();
            $('#showBal121').hide();
            $('#slashOnes').hide();
            $('#slashTwos').hide();
            $('#slashTwose').hide();
            $('#showBal2').hide();
            $('#showBal22').hide();
            $('#showBal24').hide();
        }
    }

    function hideBal() {
        localStorage.setItem("hidebal", "hidden");
        $('#showBal11').show();
        $('#showBal13').show();
        $('#showBal131').show();
        $('#slashOne').show();
        $('#slashTwo').show();
        $('#slashTwoe').show();
        $('#showBal21').show();
        $('#showBal23').show();
        $('#showBal25').show();

        $('#showBal1').hide();
        $('#showBal12').hide();
        $('#showBal121').hide();
        $('#slashOnes').hide();
        $('#slashTwos').hide();
        $('#slashTwose').hide();
        $('#showBal2').hide();
        $('#showBal22').hide();
        $('#showBal24').hide();
    }

    function showBal() {
        localStorage.setItem("hidebal", "shown");
        $('#showBal11').hide();
        $('#showBal13').hide();
        $('#showBal131').hide();
        $('#slashOne').hide();
        $('#slashTwo').hide();
        $('#slashTwoe').hide();
        $('#showBal21').hide();
        $('#showBal23').hide();
        $('#showBal25').hide();

        $('#showBal1').show();
        $('#showBal12').show();
        $('#showBal121').show();
        $('#slashOnes').show();
        $('#slashTwos').show();
        $('#slashTwose').show();
        $('#showBal2').show();
        $('#showBal22').show();
        $('#showBal24').show();
    }

    $('#switchBtn').click(() => {
        let request = "changeType";
        let accts = 'demo';
        $.ajax({
            url: '../../ops/users',
            type: 'POST',
            data: {
                request,
                'account': accts
            },
            success: function(data) {
                let response = $.parseJSON(data);
                if (response.status == "success") {
                    toastr.info(response.message);
                    setTimeout('window.location.href = "./demo";', 2000);
                } else {
                    toastr.info(response.message);
                }
            },
            cache: false,
            error: function() {
                toastr.info("An error has occured!!");
            }
        });
    });

    function redir(link, params) {
        $.redirect(link, params);
    }

    $(document).ready(function() {
        if (window.innerWidth <= 700) {
            slimInstance.hide();
            $("#sidenav-1").attr("data-mdb-mode", "over");
        } else if (window.innerWidth > 700) {
            slimInstance.show();
            $("#sidenav-1").attr("data-mdb-mode", "side");
            $("#sidenav-1").attr("data-mdb-close-on-esc", "false");
        }

    });

    window.addEventListener('resize', () => {
        // Toggle on mobile
        if (window.innerWidth <= 700) {
            slimInstance.hide();
            $("#sidenav-1").attr("data-mdb-mode", "over");
        } else if (window.innerWidth > 700) {
            slimInstance.show();
            $("#sidenav-1").attr("data-mdb-mode", "side");
            $("#sidenav-1").attr("data-mdb-close-on-esc", "false");
        }
    });
</script>
<!-- Smartsupp Live Chat script -->

<noscript> Powered by <a href=“https://<?= SITE_ADDRESS; ?>” target=“_blank”><?= SITE_NAME; ?></a></noscript>
<!-- End Smartsupp Live Chat script -->

</html>