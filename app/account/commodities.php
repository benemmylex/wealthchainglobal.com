<?php include "header.php"; ?>
<title>Commodities Data | <?= SITE_NAME; ?></title>
</header>
<main class="mt-5 pt-5" id="content">
	<div class="pt-5">
		<div class="container">
			<h4 class="fw-bold text-white">Commodities</h4>
		</div>
		<div id="gold" class="container">
			<div class="d-flex justify-content-between">
				<div class="w-100">
					<!-- TradingView Widget BEGIN -->
					<div class="tradingview-widget-container">
						<div class="tradingview-widget-container__widget"></div>
						<div class="tradingview-widget-copyright"><a role="button" rel="noopener"><span class="blue-text"></span></a></div>
						<script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-single-quote.js" async>
							{
								"symbol": "CAPITALCOM:GOLD",
								"width": "100%",
								"colorTheme": "dark",
								"isTransparent": false,
								"locale": "en",
								"largeChartUrl": "https://<?= SITE_ADDRESS; ?>/app/account/widget"
							}
						</script>
					</div>
					<!-- TradingView Widget END -->
				</div>
				<div class="pt-4 ps-2">
					<span class="text-white" style="display: flex; font-size: 10px; cursor: pointer;" onclick="displaychart('CAPITALCOM:GOLD', 'gold')"> <span class="fas fa-eye pe-1 pt-1"></span> View</span>
				</div>
			</div>
		</div>
		<div id="silver" class="container">
			<div class="d-flex justify-content-between">
				<div class="w-100">
					<!-- TradingView Widget BEGIN -->
					<div class="tradingview-widget-container">
						<div class="tradingview-widget-container__widget"></div>
						<div class="tradingview-widget-copyright"><a role="button" rel="noopener"><span class="blue-text"></span></a></div>
						<script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-single-quote.js" async>
							{
								"symbol": "CAPITALCOM:SILVER",
								"width": "100%",
								"colorTheme": "dark",
								"isTransparent": false,
								"locale": "en",
								"largeChartUrl": "https://<?= SITE_ADDRESS; ?>/app/account/widget"
							}
						</script>
					</div>
					<!-- TradingView Widget BEGIN -->
				</div>
				<div class="pt-4 ps-2">
					<span class="text-white" style="display: flex; font-size: 10px; cursor: pointer;" onclick="displaychart('CAPITALCOM:SILVER', 'silver')"> <span class="fas fa-eye pe-1 pt-1"></span> View</span>
				</div>
			</div>
		</div>
		<div id="aluminum" class="container">
			<div class="d-flex justify-content-between">
				<div class="w-100">
					<!-- TradingView Widget BEGIN -->
					<div class="tradingview-widget-container">
						<div class="tradingview-widget-container__widget"></div>
						<div class="tradingview-widget-copyright"><a role="button" rel="noopener"><span class="blue-text"></span></a></div>
						<script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-single-quote.js" async>
							{
								"symbol": "CAPITALCOM:ALUMINUM",
								"width": "100%",
								"colorTheme": "dark",
								"isTransparent": false,
								"locale": "en",
								"largeChartUrl": "https://<?= SITE_ADDRESS; ?>/app/account/widget"
							}
						</script>
					</div>
					<!-- TradingView Widget END -->
				</div>
				<div class="pt-4 ps-2">
					<span class="text-white" style="display: flex; font-size: 10px; cursor: pointer;" onclick="displaychart('CAPITALCOM:ALUMINUM', 'aluminum')"> <span class="fas fa-eye pe-1 pt-1"></span> View</span>
				</div>
			</div>
		</div>
		<div id="brentoil" class="container">
			<div class="d-flex justify-content-between">
				<div class="w-100">
					<!-- TradingView Widget BEGIN -->
					<div class="tradingview-widget-container">
						<div class="tradingview-widget-container__widget"></div>
						<div class="tradingview-widget-copyright"><a role="button" rel="noopener"><span class="blue-text"></span></a></div>
						<script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-single-quote.js" async>
							{
								"symbol": "CAPITALCOM:OIL_BRENT",
								"width": "100%",
								"colorTheme": "dark",
								"isTransparent": false,
								"locale": "en",
								"largeChartUrl": "https://<?= SITE_ADDRESS; ?>/app/account/widget"
							}
						</script>
					</div>
					<!-- TradingView Widget END -->
				</div>
				<div class="pt-4 ps-2">
					<span class="text-white" style="display: flex; font-size: 10px; cursor: pointer;" onclick="displaychart('CAPITALCOM:OIL_BRENT', 'brentoil')"> <span class="fas fa-eye pe-1 pt-1"></span> View</span>
				</div>
			</div>
		</div>
		<div id="crudeoil" class="container">
			<div class="d-flex justify-content-between">
				<div class="w-100">
					<!-- TradingView Widget BEGIN -->
					<div class="tradingview-widget-container">
						<div class="tradingview-widget-container__widget"></div>
						<div class="tradingview-widget-copyright"><a role="button" rel="noopener"><span class="blue-text"></span></a></div>
						<script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-single-quote.js" async>
							{
								"symbol": "CAPITALCOM:OIL_CRUDE",
								"width": "100%",
								"colorTheme": "dark",
								"isTransparent": false,
								"locale": "en",
								"largeChartUrl": "https://<?= SITE_ADDRESS; ?>/app/account/widget"
							}
						</script>
					</div>
					<!-- TradingView Widget END -->
				</div>
				<div class="pt-4 ps-2">
					<span class="text-white" style="display: flex; font-size: 10px; cursor: pointer;" onclick="displaychart('CAPITALCOM:OIL_CRUDE', 'crudeoil')"> <span class="fas fa-eye pe-1 pt-1"></span> View</span>
				</div>
			</div>
		</div>
		<div id="copper" class="container">
			<div class="d-flex justify-content-between">
				<div class="w-100">
					<!-- TradingView Widget BEGIN -->
					<div class="tradingview-widget-container">
						<div class="tradingview-widget-container__widget"></div>
						<div class="tradingview-widget-copyright"><a role="button" rel="noopener"><span class="blue-text"></span></a></div>
						<script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-single-quote.js" async>
							{
								"symbol": "CAPITALCOM:COPPER",
								"width": "100%",
								"colorTheme": "dark",
								"isTransparent": false,
								"locale": "en",
								"largeChartUrl": "https://<?= SITE_ADDRESS; ?>/app/account/widget"
							}
						</script>
					</div>
					<!-- TradingView Widget END -->
				</div>
				<div class="pt-4 ps-2">
					<span class="text-white" style="display: flex; font-size: 10px; cursor: pointer;" onclick="displaychart('CAPITALCOM:COPPER', 'copper')"> <span class="fas fa-eye pe-1 pt-1"></span> View</span>
				</div>
			</div>
		</div>
		<div id="naturalgas" class="container">
			<div class="d-flex justify-content-between">
				<div class="w-100">
					<!-- TradingView Widget BEGIN -->
					<div class="tradingview-widget-container">
						<div class="tradingview-widget-container__widget"></div>
						<div class="tradingview-widget-copyright"><a role="button" rel="noopener"><span class="blue-text"></span></a></div>
						<script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-single-quote.js" async>
							{
								"symbol": "CAPITALCOM:NATURALGAS",
								"width": "100%",
								"colorTheme": "dark",
								"isTransparent": false,
								"locale": "en",
								"largeChartUrl": "https://<?= SITE_ADDRESS; ?>/app/account/widget"
							}
						</script>
					</div>
					<!-- TradingView Widget END -->
				</div>
				<div class="pt-4 ps-2">
					<span class="text-white" style="display: flex; font-size: 10px; cursor: pointer;" onclick="displaychart('CAPITALCOM:NATURALGAS', 'naturalgas')"> <span class="fas fa-eye pe-1 pt-1"></span> View</span>
				</div>
			</div>
		</div>
		<div id="platinum" class="container">
			<div class="d-flex justify-content-between">
				<div class="w-100">
					<!-- TradingView Widget BEGIN -->
					<div class="tradingview-widget-container">
						<div class="tradingview-widget-container__widget"></div>
						<div class="tradingview-widget-copyright"><a role="button" rel="noopener"><span class="blue-text"></span></a></div>
						<script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-single-quote.js" async>
							{
								"symbol": "CAPITALCOM:PLATINUM",
								"width": "100%",
								"colorTheme": "dark",
								"isTransparent": false,
								"locale": "en",
								"largeChartUrl": "https://<?= SITE_ADDRESS; ?>/app/account/widget"
							}
						</script>
					</div>
					<!-- TradingView Widget END -->
				</div>
				<div class="pt-4 ps-2">
					<span class="text-white" style="display: flex; font-size: 10px; cursor: pointer;" onclick="displaychart('CAPITALCOM:PLATINUM', 'platinum')"> <span class="fas fa-eye pe-1 pt-1"></span> View</span>
				</div>
			</div>
		</div>
		<div id="cocoa" class="container">
			<div class="d-flex justify-content-between">
				<div class="w-100">
					<!-- TradingView Widget BEGIN -->
					<div class="tradingview-widget-container">
						<div class="tradingview-widget-container__widget"></div>
						<div class="tradingview-widget-copyright"><a role="button" rel="noopener"><span class="blue-text"></span></a></div>
						<script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-single-quote.js" async>
							{
								"symbol": "PEPPERSTONE:COCOA",
								"width": "100%",
								"colorTheme": "dark",
								"isTransparent": false,
								"locale": "en",
								"largeChartUrl": "https://<?= SITE_ADDRESS; ?>/app/account/widget"
							}
						</script>
					</div>
					<!-- TradingView Widget END -->
				</div>
				<div class="pt-4 ps-2">
					<span class="text-white" style="display: flex; font-size: 10px; cursor: pointer;" onclick="displaychart('PEPPERSTONE:COCOA', 'cocoa')"> <span class="fas fa-eye pe-1 pt-1"></span> View</span>
				</div>
			</div>
		</div>
		<div id="sugar" class="container">
			<div class="d-flex justify-content-between">
				<div class="w-100">
					<!-- TradingView Widget BEGIN -->
					<div class="tradingview-widget-container">
						<div class="tradingview-widget-container__widget"></div>
						<div class="tradingview-widget-copyright"><a role="button" rel="noopener"><span class="blue-text"></span></a></div>
						<script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-single-quote.js" async>
							{
								"symbol": "PEPPERSTONE:SUGAR",
								"width": "100%",
								"colorTheme": "dark",
								"isTransparent": false,
								"locale": "en",
								"largeChartUrl": "https://<?= SITE_ADDRESS; ?>/app/account/widget"
							}
						</script>
					</div>
					<!-- TradingView Widget END -->
				</div>
				<div class="pt-4 ps-2">
					<span class="text-white" style="display: flex; font-size: 10px; cursor: pointer;" onclick="displaychart('PEPPERSTONE:SUGAR', 'sugar')"> <span class="fas fa-eye pe-1 pt-1"></span> View</span>
				</div>
			</div>
		</div>
		<div id="cotton" class="container">
			<div class="d-flex justify-content-between">
				<div class="w-100">
					<!-- TradingView Widget BEGIN -->
					<div class="tradingview-widget-container">
						<div class="tradingview-widget-container__widget"></div>
						<div class="tradingview-widget-copyright"><a role="button" rel="noopener"><span class="blue-text"></span></a></div>
						<script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-single-quote.js" async>
							{
								"symbol": "PEPPERSTONE:COTTON",
								"width": "100%",
								"colorTheme": "dark",
								"isTransparent": false,
								"locale": "en",
								"largeChartUrl": "https://<?= SITE_ADDRESS; ?>/app/account/widget"
							}
						</script>
					</div>
					<!-- TradingView Widget END -->
				</div>
				<div class="pt-4 ps-2">
					<span class="text-white" style="display: flex; font-size: 10px; cursor: pointer;" onclick="displaychart('PEPPERSTONE:COTTON', 'cotton')"> <span class="fas fa-eye pe-1 pt-1"></span> View</span>
				</div>
			</div>
		</div>
		<div id="gasoline" class="container">
			<div class="d-flex justify-content-between">
				<div class="w-100">
					<!-- TradingView Widget BEGIN -->
					<div class="tradingview-widget-container">
						<div class="tradingview-widget-container__widget"></div>
						<div class="tradingview-widget-copyright"><a role="button" rel="noopener"><span class="blue-text"></span></a></div>
						<script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-single-quote.js" async>
							{
								"symbol": "PEPPERSTONE:GASOLINE",
								"width": "100%",
								"colorTheme": "dark",
								"isTransparent": false,
								"locale": "en",
								"largeChartUrl": "https://<?= SITE_ADDRESS; ?>/app/account/widget"
							}
						</script>
					</div>
					<!-- TradingView Widget END -->
				</div>
				<div class="pt-4 ps-2">
					<span class="text-white" style="display: flex; font-size: 10px; cursor: pointer;" onclick="displaychart('PEPPERSTONE:GASOLINE', 'gasoline')"> <span class="fas fa-eye pe-1 pt-1"></span> View</span>
				</div>
			</div>
		</div>
		<div id="coffee" class="container">
			<div class="d-flex justify-content-between">
				<div class="w-100">
					<!-- TradingView Widget BEGIN -->
					<div class="tradingview-widget-container">
						<div class="tradingview-widget-container__widget"></div>
						<div class="tradingview-widget-copyright"><a role="button" rel="noopener"><span class="blue-text"></span></a></div>
						<script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-single-quote.js" async>
							{
								"symbol": "PEPPERSTONE:COFFEE",
								"width": "100%",
								"colorTheme": "dark",
								"isTransparent": false,
								"locale": "en",
								"largeChartUrl": "https://<?= SITE_ADDRESS; ?>/app/account/widget"
							}
						</script>
					</div>
					<!-- TradingView Widget END -->
				</div>
				<div class="pt-4 ps-2">
					<span class="text-white" style="display: flex; font-size: 10px; cursor: pointer;" onclick="displaychart('PEPPERSTONE:COFFEE', 'coffee')"> <span class="fas fa-eye pe-1 pt-1"></span> View</span>
				</div>
			</div>
		</div>
		<div id="corn" class="container">
			<div class="d-flex justify-content-between">
				<div class="w-100">
					<!-- TradingView Widget BEGIN -->
					<div class="tradingview-widget-container">
						<div class="tradingview-widget-container__widget"></div>
						<div class="tradingview-widget-copyright"><a role="button" rel="noopener"><span class="blue-text"></span></a></div>
						<script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-single-quote.js" async>
							{
								"symbol": "PEPPERSTONE:CORN",
								"width": "100%",
								"colorTheme": "dark",
								"isTransparent": false,
								"locale": "en",
								"largeChartUrl": "https://<?= SITE_ADDRESS; ?>/app/account/widget"
							}
						</script>
					</div>
					<!-- TradingView Widget END -->
				</div>
				<div class="pt-4 ps-2">
					<span class="text-white" style="display: flex; font-size: 10px; cursor: pointer;" onclick="displaychart('PEPPERSTONE:CORN', 'corn')"> <span class="fas fa-eye pe-1 pt-1"></span> View</span>
				</div>
			</div>
		</div>
		</section>

		<?php include "footer.php"; ?>
		<script>
			function displaychart(symbol, id) {
				window.location.href = 'widget?tvwidgetsymbol=' + symbol + '&commodity=' + id;
			}
		</script>