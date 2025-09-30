<?php include "header.php"; 

if (!isset($_GET['nftid'])) {
	header("Location: ./nfts");
}else{
	$nftid = $_GET['nftid'];

	$getnft = $db_conn->prepare("SELECT * FROM nfts WHERE nftid = :nftid");
	$getnft->bindParam(":nftid", $nftid, PDO::PARAM_STR);
	$getnft->execute();
	if ($getnft->rowCount() < 1) {
		header("Location: ./nfts");
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
					<button onclick="$('#formbuy').toggle()" class="btn btn-outline-white">Buy now</button>
				</div>
				<div id="formbuy" class="my-3">
				    <form id="deposit" enctype="multipart/form-data" method="POST">
                        <p>To complete this purchase, pay the sum of <?= $_SESSION['symbol'].number_format($row['nftprice'], 2); ?> and upload a corresponding payment proof.</p>
                        <div class="form-group my-3">
                            <label class="form-label mb-2" for="type">Select option</label>
                            <select class="form-control browser-default" data-mdb-select-initialized="true" required id="type" name="type">
                                <option class="" disabled selected>--Select method--</option>
                                <?php $sql = $db_conn->prepare("SELECT * FROM crypto");
                                $sql->execute();
                                while ($rows = $sql->fetch(PDO::FETCH_ASSOC)) :
                                ?>
                                    <option value="<?php echo $rows['crypto_name']; ?>"><?php echo $rows['crypto_name']; ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="input-group form-outline mt-4 mb-3">
                            <input type="text" class="form-control" readonly placeholder="Wallet address" id="address" name="address" aria-label="address" />
                            <button class="btn btn-primary" id="copyBtn" type="button" data-mdb-ripple-init aria-expanded="false">
                                Copy
                            </button>
                        </div>
                        <a href="javascript:void(0)" onclick="$('#barcodeModal').modal('show');" class="d-flex mb-2 fw-semibold justify-content-end mb-3">
                            Or tap here to reveal Qr Code
                        </a>
                        <div>
                            <label class="form-label mb-0" for="proof">Payment Proof</label>
                            <div class="form-outline my-3">
                                <i class="fas fa-image trailing text-muted"></i>
                                <input type="file" id="proof" required name="proof" class="form-control form-icon-trailing">
                                <!--  -->
                            </div>
                        </div>
                        <div class="form-group text-center">
                            <div class="alert alert-primary" id="errorshow"></div>
                        </div>
                        <div class="my-3" align="center">
                            <button type="submit" class="btn btn-md btn-primary">Proceed</button>
                        </div>
                    </form>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="barcodeModal" tabindex="-1" aria-labelledby="barcodeModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
            <div class="modal-content text-center">
                <div class="modal-header justify-content-center">
                    <h3 class="fw-bold"><span class="fas fa-exclamation-circle"></span> Pay with <span id="paywith"></span></h3>
                    <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-3">
                    <div class="input-group form-outline mt-4 mb-3">
                        <input type="text" class="form-control" readonly placeholder="Wallet address" id="address2" name="address2" aria-label="address2" />
                        <button class="btn btn-primary" id="copyBtns" type="button" data-mdb-ripple-init aria-expanded="false">
                            Copy
                        </button>
                        <label class="form-label" for="address">Wallet address</label>
                    </div>
                    <p class="h6 text-start lh-base">Kindly copy and make your payment of $<?= $_SESSION['symbol'].number_format($row['nftprice'], 2); ?> worth of <span id="crypto"></span> into the provided address and proceed. Or scan the QR Code below to complete payment.</p>
                    <div>
                        <img src="" id="barcode" class="img-fluid" />
                    </div>
                </div>
                <div class="modal-footer">
                    <span class="badge badge-danger p-3">
                        <a type="button" onclick="$('#barcodeModal').modal('hide');" class="link">Close</a>
                    </span>
                </div>
            </div>
        </div>
    </div>
</main>
<?php include "footer.php"; ?>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    $(document).ready(() => {
        $("#errorshow").fadeOut();
        $("#formbuy").fadeOut();
    });

    $("#type").change(() => {
        let val = $('#type').val();
        let amount = "<?= $row['nftprice']; ?>";
        let request = "getcoin";

        $.ajax({
            url: '../../ops/users',
            type: 'POST',
            data: {
                request: request,
                type: val
            },
            success: function(data) {
                var response = $.parseJSON(data);
                $('#address').val(response.wallet);
                $('#address2').val(response.wallet);
                $('#crypAmount').html(amount);
                $('#crypto').html($('#type').val());
                $('#paywith').html($('#type').val());
                $('#barcode').attr('src', `../../assets/images/wallets/${response.qrcode}`);
            },
            cache: false,
            error: function(err) {
                $('#errorshow').html(err).fadeIn();
                setTimeout(() => {
                    $('#errorshow').fadeOut();
                }, 5000)
            }
        });
    });

    $("#copyBtn").click(function() {
        var text = document.getElementById("address");
        text.select();
        document.execCommand('copy');
        toastr.info('Address Copied', 'Info');
    });

    $("#copyBtns").click(function() {
        var text = document.getElementById("address2");
        text.select();
        document.execCommand('copy');
        toastr.info('Address Copied', 'Info');
    });

    $("form#deposit").submit(function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        let request = "buyNft";
        let amount = "<?= $row['nftprice']; ?>";
        let nft = "<?= $row['nftid']; ?>";
        formData.append('request', request);
        formData.append('amount', amount);
        formData.append('nft', nft);
        if ($("#type").val() == null) {
            $('#errorshow').html("<span class='fas fa-exclamation-triangle'></span> Select a cryptocurrency to pay with").fadeIn();
        } else {
            $.ajax({
                url: '../../ops/users',
                type: 'POST',
                data: formData,
                beforeSend: function() {
                    $('#errorshow').html("Processing payment, Please wait <span class='fas fa-spinner fa-spin'></span>").fadeIn();
                },
                success: function(data) {
                    var response = $.parseJSON(data);
                    if (response.status == "success") {
                        $("#errorshow").html(response.message).fadeIn();
                    } else {
                        $("#errorshow").html(response.message);
                    }
                },
                cache: false,
                error: function(err) {
                    $('#errorshow').html("An error has occured! " + err.statusText).fadeIn();
                },
                contentType: false,
                processData: false
            });
        }
    });
    
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