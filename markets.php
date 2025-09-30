<?php 

$title = "";

if(!isset($_GET['market'])){
	header("Location: ./");
}else{
	switch ($_GET['market']){
		case 'crypto':
		$title = "Crypto";
		$currentPage = "c-market";
		break;
		case 'forex':
		$title = "Forex";
		$currentPage = "f-market";
		break;
		case 'index':
		$title = "Indices";
		$currentPage = "i-market";
		break;
		default:
		$title = "Crypto";
		$currentPage = "c-market";
		break;
	}
}
include "header.php"; 

?>
<title><?= $title; ?> Chart - Best Trading Platform </title>
<?php include "pageheader.php"; ?>
<!-- Start About -->
<!-- Start About -->
<section class="section">
	<div class="container pt-5">
		<h2 class="text-center pt-3 fw-bolder mb-4"><?= $title; ?> Chart</h2>
		<div class="row">
			<div class="col-md-12">
				<?php
				switch($_GET['market']){
					case 'crypto':
					?>
					<!-- TradingView Widget BEGIN -->
					<div class="tradingview-widget-container">
						<div class="tradingview-widget-container__widget"></div>
						<script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-screener.js" async>
							{
								"width": "100%",
								"height": "540",
								"defaultColumn": "overview",
								"screener_type": "crypto_mkt",
								"displayCurrency": "USD",
								"colorTheme": "dark",
								"locale": "en",
								"largeChartUrl": "http://localhost/newbroker/widget"
							}
						</script>
					</div>
					<!-- TradingView Widget END -->
					<?php
					break;
					case 'forex':
					?>
					<!-- TradingView Widget BEGIN -->
					<div class="tradingview-widget-container">
						<div class="tradingview-widget-container__widget"></div><script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-screener.js" async>
							{
								"width": "100%",
								"height": "540",
								"defaultColumn": "overview",
								"defaultScreen": "general",
								"market": "forex",
								"showToolbar": false,
								"colorTheme": "dark",
								"locale": "en",
								"largeChartUrl": "http://<?= SITE_URL; ?>/widget"
							}
						</script>
					</div>
					<!-- TradingView Widget END -->
					<?php
					break;
					case 'index':
					?>
					<!-- TradingView Widget BEGIN -->
					<div class="tradingview-widget-container">
						<div class="tradingview-widget-container__widget"></div>
						<script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-market-overview.js" async>
							{
								"colorTheme": "dark",
								"dateRange": "12M",
								"showChart": true,
								"locale": "en",
								"width": "100%",
								"height": "600",
								"largeChartUrl": "http://<?= SITE_URL; ?>/widget",
								"isTransparent": false,
								"showSymbolLogo": true,
								"showFloatingTooltip": false,
								"plotLineColorGrowing": "rgba(41, 98, 255, 1)",
								"plotLineColorFalling": "rgba(41, 98, 255, 1)",
								"gridLineColor": "rgba(240, 243, 250, 0)",
								"scaleFontColor": "rgba(106, 109, 120, 1)",
								"belowLineFillColorGrowing": "rgba(41, 98, 255, 0.12)",
								"belowLineFillColorFalling": "rgba(41, 98, 255, 0.12)",
								"belowLineFillColorGrowingBottom": "rgba(41, 98, 255, 0)",
								"belowLineFillColorFallingBottom": "rgba(41, 98, 255, 0)",
								"symbolActiveColor": "rgba(41, 98, 255, 0.12)",
								"tabs": [
								{
									"title": "Indices",
									"symbols": [
									{
										"s": "FOREXCOM:SPXUSD",
										"d": "S&P 500"
									},
									{
										"s": "FOREXCOM:NSXUSD",
										"d": "US 100"
									},
									{
										"s": "FOREXCOM:DJI",
										"d": "Dow 30"
									},
									{
										"s": "INDEX:NKY",
										"d": "Nikkei 225"
									},
									{
										"s": "INDEX:DEU40",
										"d": "DAX Index"
									},
									{
										"s": "FOREXCOM:UKXGBP",
										"d": "UK 100"
									},
									{
										"s": "NASDAQ:TSLA"
									},
									{
										"s": "NASDAQ:AAPL",
										"d": "Apple"
									},
									{
										"s": "NASDAQ:AMZN",
										"d": "Amazon"
									},
									{
										"s": "OANDA:SPX500USD",
										"d": "SPX"
									},
									{
										"s": "OANDA:US30USD",
										"d": "US 30"
									}
									],
									"originalTitle": "Indices"
								},
								{
									"title": "Futures",
									"symbols": [
									{
										"s": "CME_MINI:ES1!",
										"d": "S&P 500"
									},
									{
										"s": "CME:6E1!",
										"d": "Euro"
									},
									{
										"s": "COMEX:GC1!",
										"d": "Gold"
									},
									{
										"s": "NYMEX:CL1!",
										"d": "Crude Oil"
									},
									{
										"s": "NYMEX:NG1!",
										"d": "Natural Gas"
									},
									{
										"s": "CBOT:ZC1!",
										"d": "Corn"
									},
									{
										"s": "CME_MINI:ES1!",
										"d": "Es"
									},
									{
										"s": "NSE:BANKNIFTY1!",
										"d": "Banknifty"
									}
									],
									"originalTitle": "Futures"
								},
								{
									"title": "Bonds",
									"symbols": [
									{
										"s": "CME:GE1!",
										"d": "Eurodollar"
									},
									{
										"s": "CBOT:ZB1!",
										"d": "T-Bond"
									},
									{
										"s": "CBOT:UB1!",
										"d": "Ultra T-Bond"
									},
									{
										"s": "EUREX:FGBL1!",
										"d": "Euro Bund"
									},
									{
										"s": "EUREX:FBTP1!",
										"d": "Euro BTP"
									},
									{
										"s": "EUREX:FGBM1!",
										"d": "Euro BOBL"
									},
									{
										"s": "TVC:US10Y",
										"d": "US 10"
									}
									],
									"originalTitle": "Bonds"
								},
								{
									"title": "Forex",
									"symbols": [
									{
										"s": "FX:EURUSD",
										"d": "EUR/USD"
									},
									{
										"s": "FX:GBPUSD",
										"d": "GBP/USD"
									},
									{
										"s": "FX:USDJPY",
										"d": "USD/JPY"
									},
									{
										"s": "FX:USDCHF",
										"d": "USD/CHF"
									},
									{
										"s": "FX:AUDUSD",
										"d": "AUD/USD"
									},
									{
										"s": "FX:USDCAD",
										"d": "USD/CAD"
									}
									],
									"originalTitle": "Forex"
								}
								]
							}
						</script>
					</div>
					<!-- TradingView Widget END -->

					<?php
				}
				?>
			</div>
		</div>
	</div><!--end container-->
</section><!--end section-->
<?php include "footer.php"; ?>
