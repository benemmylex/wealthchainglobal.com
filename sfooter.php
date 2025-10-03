<!-- ===============>> scrollToTop start here <<================= -->
<a href="#" class="scrollToTop scrollToTop--style1"><i class="fa-solid fa-arrow-up-from-bracket"></i></a>
<!-- ===============>> scrollToTop ending here <<================= -->
<div class="gtranslate_wrapper"></div>

<!-- vendor plugins -->
<script src="assets/js/jquery-3.4.1.min.js"></script>
<script src="assets/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/all.min.js"></script>
<script src="assets/js/swiper-bundle.min.js"></script>
<script src="assets/js/aos.js"></script>
<script src="assets/js/toastr.js"></script>
<script src="assets/js/fslightbox.js"></script>
<script src="assets/js/purecounter_vanilla.js"></script>
<script src="https://www.cryptohopper.com/widgets/js/script"></script>
<script>
	window.gtranslateSettings = {
		"default_language": "en",
		"wrapper_selector": ".gtranslate_wrapper"
	}
</script>
<script src="https://cdn.gtranslate.net/widgets/v1.0.1/float.js" defer></script>
<script src="assets/js/custom.js"></script>

<script>
	const showpass = (pass, span) => {
		let password = document.getElementById(pass);
		if (password.type == 'password') {
			password.type = 'text';
			$('#' + span).html("<span class= 'fa-solid fa-eye-slash'></span>");
		} else {
			password.type = 'password';
			$('#' + span).html("<span class= 'fa-solid fa-eye'></span>");
		}
	}
</script>

<?= LIVE_CHAT; ?>

<!-- Smartsupp Live Chat script -->
<script type="text/javascript">
	var _smartsupp = _smartsupp || {};
	_smartsupp.key = '35d12ac95bc66d7c038e1699a204e5c21517fdb5';
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