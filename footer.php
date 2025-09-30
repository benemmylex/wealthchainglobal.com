  <!-- ===============>> footer start here <<================= -->
  <footer class="footer ">
    <div class="container">
      <div class="footer__wrapper">
        <div class="footer__top footer__top--style1">
          <div class="row gy-5 gx-4">
            <div class="col-md-6">
              <div class="footer__about">
                <a href="index-2.html" class="footer__about-logo"><img src="assets/images/logo/logo-dark.png"
                    alt="Logo" style="height: 50px;"></a>
                <p class="footer__about-moto ">We help your money grow by putting it to work. Not just by words. Our experts ensure not only that your funds are at work, but are put in carefully planned and strategically diversified trading and investment portfolio for risk management.</p>
              </div>
            </div>
            <div class="col-md-2 col-sm-4 col-6">
              <div class="footer__links">
                <div class="footer__links-tittle">
                  <h6>Quick links</h6>
                </div>
                <div class="footer__links-content">
                  <ul class="footer__linklist">
                    <li class="footer__linklist-item"> <a href="./about">About Us</a>
                    </li>
                    <li class="footer__linklist-item"> <a href="./markets?market=forex">Forex Charts</a>
                    </li>
                    <li class="footer__linklist-item"> <a href="./markets?market=index">Index Charts</a> </li>
                    <li class="footer__linklist-item"> <a href="./markets?market=crypto">Crypto Charts</a>
                    </li>
                  </ul>
                </div>
              </div>

            </div>
            <div class="col-md-2 col-sm-4 col-6">
              <div class="footer__links">
                <div class="footer__links-tittle">
                  <h6>Support</h6>
                </div>
                <div class="footer__links-content">
                  <ul class="footer__linklist">
                    <li class="footer__linklist-item"> <a href="./terms">Terms & Conditions</a>
                    </li>
                    <li class="footer__linklist-item"> <a href="./privacy-policy">Privacy Policy</a>
                    </li>
                    <li class="footer__linklist-item"> <a href="./risk-disclosure">Risk Disclosure</a></li>
                    <li class="footer__linklist-item"> <a href="./contact">Support Center</a> </li>
                  </ul>
                </div>
              </div>

            </div>
            <div class="col-md-2 col-sm-4">
              <div class="footer__links">
                <div class="footer__links-tittle">
                  <h6>Company</h6>
                </div>
                <div class="footer__links-content">
                  <ul class="footer__linklist">
                    <li class="footer__linklist-item"> <a href="./copy-trading">Copy Trading</a>
                    </li>
                    <li class="footer__linklist-item"> <a href="./stock-trading">Stock Trading</a>
                    </li>
                    <li class="footer__linklist-item"> <a href="./forex-trading">Forex Trading</a> </li>
                    <li class="footer__linklist-item"> <a href="./crypto">Crypto Trading</a>
                    </li>
                  </ul>
                </div>
              </div>

            </div>
          </div>
        </div>
        <div class="footer__bottom">
          <div class="footer__end">
            <div class="footer__end-copyright">
              <p class=" mb-0">© <?= date("Y"); ?> All Rights Reserved By <?= SITE_NAME; ?> </p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="footer__shape">
      <span class="footer__shape-item footer__shape-item--1"><img src="assets/images/footer/1.png"
          alt="shape icon"></span>
      <span class="footer__shape-item footer__shape-item--2"> <span></span> </span>
    </div>
  </footer>
  <!-- ===============>> footer end here <<================= -->



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
<script src="https://cdnjs.cloudflare.com/ajax/libs/Faker/3.1.0/faker.min.js"></script>
<script src="assets/js/custom.js"></script>
<script>window.gtranslateSettings = {"default_language":"en","wrapper_selector":".gtranslate_wrapper"}</script>
<script src="https://cdn.gtranslate.net/widgets/v1.0.1/float.js" defer></script>
<script type="text/javascript">
    setInterval(function(){
        let _info = faker.helpers.createCard();
        let {name, email, address:{city,country,zipcode}} = _info; 
        var _amount = (Math.random()*10000).toFixed(2);
        var _label_message = name+" just invested the sum of $"+_amount;
        toastr["info"](_label_message);
        
     }, 30000);

    setInterval(function(){
        let info = faker.helpers.createCard();
        let {name, email, address:{city,country,zipcode}} = info; 
        var amount = (Math.random()*100000).toFixed(2);
        var label_message = "<font color='white'>"+name+" from "+city+", "+country+" withdrew the sum of $"+amount+".</font>";
        var header_message = "<font color='white'>Recent Withdrawal!</font>";
        toastr["success"](label_message, header_message);
    }, 20000);
</script>
<?= LIVE_CHAT; ?>

<!-- Smartsupp Live Chat script -->
<script type="text/javascript">
var _smartsupp = _smartsupp || {};
_smartsupp.key = '35d12ac95bc66d7c038e1699a204e5c21517fdb5';
window.smartsupp||(function(d) {
  var s,c,o=smartsupp=function(){ o._.push(arguments)};o._=[];
  s=d.getElementsByTagName('script')[0];c=d.createElement('script');
  c.type='text/javascript';c.charset='utf-8';c.async=true;
  c.src='https://www.smartsuppchat.com/loader.js?';s.parentNode.insertBefore(c,s);
})(document);
</script>

<noscript> Powered by <a href=“https://www.<?= SITE_ADDRESS; ?>” target=“_blank”><?= SITE_NAME ?></a></noscript>


</body>
</html>