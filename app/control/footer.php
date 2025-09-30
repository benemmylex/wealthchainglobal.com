<a class="floating mdark" id="switcher">
    <span id="sback" class="fas fa-moon"></span>
</a>
<footer class="footer bg-gradient py-2 border-top" style="background-color: #070a18;">
    <div class="pt-3">
        <div align="center">
            <p class="text-center text-light">&copy; <?php echo date("Y"); ?> <?= SITE_NAME; ?></p>
        </div>
    </div>
</footer>
</body>
<script src="../../assets/js/mdb.min.js"></script>
<script src="../../assets/js/datatables.min.js"></script>
<script src="../../assets/js/switchtheme.js"></script>
<!-- <script src="https://www.cryptohopper.com/widgets/js/script"></script> -->
<script>
    //Initialize it with JS to make it instantly visible
    const slimInstance = new mdb.Sidenav(document.getElementById('sidenav-1'));
    // slimInstance.show();
    
    $("#switcher").click(function(){
        const ttt = localStorage.getItem('theme') === 'dark' ? 'light' : 'dark';
        setTheme(ttt);
    });
</script>
<!--<script src="https://static.elfsight.com/platform/platform.js" data-use-service-core defer></script>-->
<!--<div class="elfsight-app-ebbda17a-d754-4e89-819c-49df89a486cf" data-elfsight-app-lazy></div>-->
</html>