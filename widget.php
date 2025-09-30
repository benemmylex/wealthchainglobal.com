<?php 

if(!isset($_GET['tvwidgetsymbol'])){
	header("Location: ./");
}else{
	$mainPair = explode(":", $_GET['tvwidgetsymbol']);

        // print_r($mainPair);

	$newstr1 = $mainPair[0];
	$newstr2 = $mainPair[1];

	$page = $newstr2;


}
$currentPage = "widget";
include "header.php"; 

?>
<title><?= $newstr2; ?> - Best Trading Platform </title>
<?php include "pageheader.php"; ?>
<!-- Start About -->
<!-- Start About -->
<section class="section mb-5">
    <div class="container pt-5">
        <h3 class="text-center fw-bolder mb-4"><?= $newstr2; ?> Chart</h3>
        <div class="row">
        	<div class="col-md-12" data-aos="fade-up" data-aos-duration="1000">
				<!-- TradingView Widget BEGIN -->
            <div class="tradingview-widget-container">
            <div class="tradingview-widget-container__widget"></div>
            <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-symbol-overview.js" async>
            {
            "symbols": [
                [
                "<?= $newstr1; ?>:<?= $newstr2 ?>|1M"
                ]
            ],
            "chartOnly": false,
            "width": "100%",
            "height": 540,
            "locale": "en",
            "colorTheme": "dark",
            "autosize": false,
            "showVolume": true,
            "showMA": true,
            "hideDateRanges": false,
            "hideMarketStatus": false,
            "hideSymbolLogo": false,
            "scalePosition": "right",
            "scaleMode": "Normal",
            "fontFamily": "-apple-system, BlinkMacSystemFont, Trebuchet MS, Roboto, Ubuntu, sans-serif",
            "fontSize": "10",
            "noTimeScale": false,
            "valuesTracking": "1",
            "changeMode": "price-and-percent",
            "chartType": "area",
            "maLineColor": "#2962FF",
            "maLineWidth": 1,
            "maLength": 9,
            "lineWidth": 2,
            "lineType": 0,
            "dateRanges": [
                "1d|1",
                "1m|30",
                "3m|60",
                "12m|1D",
                "60m|1W",
                "all|1M"
            ],
            "lineColor": "rgba(51, 104, 248, 1)",
            "timeHoursFormat": "24-hours"
            }
            </script>
            </div>
            <!-- TradingView Widget END -->
			</div>
        </div>
    </div><!--end container-->
</section><!--end section-->
<!-- End About -->
<?php include "footer.php"; ?>
