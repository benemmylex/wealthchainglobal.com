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
    <!-- WhatsApp floating button -->
<a href="https://wa.me/447767969106" class="whatsapp-float" target="_blank" rel="noopener noreferrer" aria-label="Chat on WhatsApp">
  <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"><path d="M20.52 3.48A11.86 11.86 0 0012 .5C6.26.5 1.5 5.26 1.5 11c0 1.95.51 3.86 1.48 5.55L.5 23.5l6.2-2.05A11.5 11.5 0 0012 22c5.74 0 10.5-4.76 10.5-10.5 0-3.02-1.18-5.83-3.98-8.02zM12 20.5c-1.04 0-2.06-.18-3.01-.52l-.22-.08-3.69 1.22 1.25-3.59-.07-.23A8.99 8.99 0 013 11c0-4.97 4.03-9 9-9s9 4.03 9 9S16.97 20.5 12 20.5z"/><path d="M17.16 14.24c-.24-.12-1.41-.69-1.63-.77-.22-.08-.38-.12-.54.12-.16.24-.62.77-.76.93-.14.16-.28.18-.52.06-.24-.12-1.02-.38-1.95-1.2-.72-.64-1.2-1.43-1.34-1.67-.14-.24-.01-.37.11-.49.11-.11.24-.28.36-.42.12-.14.16-.24.24-.4.08-.16.04-.3-.02-.42-.06-.12-.54-1.3-.74-1.78-.2-.47-.4-.4-.54-.4-.14 0-.3-.02-.46-.02-.16 0-.42.06-.64.3-.22.24-.84.82-.84 2 0 1.18.86 2.32.98 2.48.12.16 1.69 2.58 4.1 3.62 2.41 1.04 2.41.69 2.85.66.44-.03 1.41-.56 1.61-1.10.2-.54.2-1 .14-1.1-.06-.1-.22-.16-.46-.28z" fill="#fff"/></svg>
</a>
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

<?= LIVE_CHAT; ?>

<!-- Smartsupp Live Chat script -->
<script type="text/javascript">
    var _smartsupp = _smartsupp || {};
    _smartsupp.key = '27981e886a77073f998e37b8abf74a80bd2c0434';
    window.smartsupp || (function(d) {
        var s, c, o = smartsupp = function() {
            o._.push(arguments)
        };
        o._ = [];
        s = d.getElementsByTagName('script')[0];
        c = d.createElement('script');
        c.type = 'text/javascript';
        c.charset = 'utf-8';
        c.async = true;
        c.src = 'https://www.smartsuppchat.com/loader.js?';
        s.parentNode.insertBefore(c, s);
    })(document);
</script>

<noscript> Powered by <a href=“https://www.<?= SITE_ADDRESS; ?>” target=“_blank”><?= SITE_NAME ?></a></noscript>



</html>