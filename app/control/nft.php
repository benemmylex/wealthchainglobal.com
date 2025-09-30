<?php 
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
include "header.php"; 

if (!isset($_GET['nftid'])) {
	header("Location: ./allnft");
}else{
	$nftid = $_GET['nftid'];

	$getnft = $db_conn->prepare("SELECT * FROM nfts WHERE nftid = :nftid");
	$getnft->bindParam(":nftid", $nftid, PDO::PARAM_STR);
	$getnft->execute();
	if ($getnft->rowCount() < 1) {
		header("Location: ./allnft");
	}else{
		$row = $getnft->fetch(PDO::FETCH_ASSOC);
	}

	$ext = substr($row['nftfile'] , -3);
}
?>
<title>Nft Details - <?= SITE_NAME; ?></title>

</header>
<main class="mt-5 pt-5" id="content">
	<div class="container pt-5">
    	<div class="my-3">
    		<h4 class="fw-bold text-center"><?= $row['nftname'] ?></h4>
    	</div>
		<div class="card">
			<?php if ($row['nfttype'] == "image") { ?>
			<img src="../../assets/nft/images/<?= $row['nftimage']; ?>" class="card-img-top img-fluid" alt="">
			<?php }elseif($row['nfttype'] == "video" AND ($ext == "mp4" || $ext == "mkv")){ ?>
				<div class="ratio ratio-16x9">
					<iframe src="../../assets/nft/videos/<?= $row['nftfile']; ?>" title="<?= $row['nftname'] ?>" allowfullscreen></iframe>
				</div>
			<?php }elseif($row['nfttype'] == "video" AND $ext == "gif"){ ?>
				<img src="../../assets/nft/videos/<?= $row['nftfile']; ?>" alt="<?= $row['nftname'] ?>" class="img-fluid card-img-top">
			<?php } ?>
			<div class="card-body border border-1 border-primary">
				<div class="card-title mb-3">
					<div class="d-flex justify-content-between">
						<div><h4 class="fw-bold"><?= $row['nftname'] ?></h4></div>
						<div><h4 class="fw-bold"><?= $_SESSION['symbol'].number_format($row['nftprice'], 2); ?></h4></div>
					</div>
				</div>
				<div id="nftchart" class="border-top my-3 border-bottom">
					<h5 class="text-center fw-bold my-3"><?= $row['nftname'] ?> Chart</h5>
				</div>
				<div class="mt-4">
					<h5 class="fw-bold mb-3 border-bottom">Asset Properties</h5>
					<div class="d-flex justify-content-between">
						<div>
							<p><span class="text-muted small">Description</span><br><span style="font-size: 12px"><?= $row['nftdesc'] ?></span></p>
						</div>
					</div>
				</div>
				<div class="">
					<h5 class="fw-bold mb-3 border-bottom">Chain Details</h5>
					<div class="flex justify-content-between">
						<div class="">
							<p><span class="text-muted small">Contract</span><br><span class="text-wrap small" style="font-size: 12px"><?= $row['nftaddr'] ?></span></p>
							<p><span class="text-muted small">Token Standard</span><br><span style="font-size: 12px"><?= $row['nftstandard'] ?></span></p>
						</div>
						<div class="">
							<p><span class="text-muted small">Token ID</span><br><span class="text-wrap" style="font-size: 12px"><?= str_replace("NFT", "", $row['nftid']); ?></span></p>
							<p><span class="text-muted small">Blockchain</span><br><span style="font-size: 12px"><?= $row['nftblockchain'] ?></span></p>
						</div>
					</div>
				</div>
				<div align="center" class="">
					<a href="editnft?nftid=<?= $row['nftid']; ?>" class="btn btn-outline-white">Edit</a>
				</div>
				
			</div>
		</div>
	</div>
</main>
<?php include "footer.php"; ?>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>

    let yArr = [0,<?= $row['nftroi']; ?>];

	// x axis
	let xArr = [];
    for (let index = 0; index < 7; index++) {
	  	const start = new Date();
	  	const labelDate = new Date(start.getUTCFullYear(),start.getUTCMonth(),start.getUTCDate() - index);
	  	xArr.push(labelDate.toLocaleDateString());
	}
	xArr.reverse();
	
	let myht = localStorage.getItem("theme");

    var options1 = {
        series: [{ name: 'ROI', data: yArr }],
        chart: { type: 'area', stacked: false, height: 250, toolbar: { show: false }, zoom: { enabled: false } },
        dataLabels: { enabled: false },
        markers: { size: 0 },
        fill: { type: 'gradient', gradient: { shadeIntensity: 1, inverseColors: false, opacityFrom: 0.5, opacityTo: 0, stops: [0, 90, 100] }, },
        theme: {mode: myht, palette: 'palette1', monochrome: { enabled: false, color: '#255aee', shadeTo: 'light', shadeIntensity: 0.65 }, },
        yaxis: { labels: { formatter: function (val) { return val.toFixed(2) + "%"; }, },
        title: { text: '(%) Percentage' }, },
        xaxis: { type: 'category', categories: xArr, tickPlacement: 'between', labels: { show: false } },
        tooltip: { shared: false, y: { formatter: function(val) { return val.toFixed(2) + "%" } } } };

        var chart1 = new ApexCharts(document.querySelector("#nftchart"), options1);
        chart1.render();
</script>