<?php include "header.php";
if (isset($_GET['main_id'])) {
	$main_id = $_GET['main_id'];
} else {
	header("Location: ./");
	exit();
}

$getcrypto = $db_conn->prepare("SELECT * FROM crypto WHERE main_id = :main_id");
$getcrypto->bindParam(":main_id", $main_id, PDO::PARAM_STR);
$getcrypto->execute();
$row = $getcrypto->fetch(PDO::FETCH_ASSOC);
if ($getcrypto->rowCount() < 1) {
	header("Location: ./");
	exit();
}
?>
<title>Edit Wallet : <?= SITE_NAME; ?></title>
<main class="py-5 px-2" id="content">
	<div class="container text-start pt-5">
		<h3 class="fw-bold ps-3"><i class="fas fa-tachometer-alt"></i> Hello, <?= ucfirst($admusername); ?></h3>
		<p class="small mt-0 pt-0 ps-3">Edit Wallet</p>
		<div class="card shadow-3">
			<div class="card-body">
				<h3 class="fw-bold">Edit Wallet</h3>
				<p class="">Make changes to Wallet</p>
				<form class="" id="editwallet" enctype="multipart/form-data">
					<div class="form-outline mb-4">
						<i class="fab fa-ethereum trailing"></i>
						<input type="text" id="crypto_name" value="<?= $row['crypto_name']; ?>" name="crypto_name" class="form-control form-icon-trailing">
						<label for="crypto_name" class="form-label">Crypto Name (e.g. Ethereum)</label>
					</div>
					<div class="form-outline mb-4">
						<i class="far fa-wallet trailing"></i>
						<input type="text" id="wallet_addr" value="<?= $row['wallet_addr']; ?>" name="wallet_addr" class="form-control form-icon-trailing">
						<label for="wallet_addr" class="form-label">Wallet Address</label>
					</div>
					<div class="md-form">
						<label class="form-label" for="qrcode"> Upload Image <span class="far fa-qrcode"></span></label>
						<input type="file" id="qrcode" class="form-control" name="qrcode">
					</div>
					<div class="form-group mt-3" align="center">
						<p class="alert alert-primary" id="errorshow"></p>
					</div>
					<center>
						<div class="col-md-5 ms-auto me-auto mb-3 mt-3">
							<button type="submit" id="btnEdit" class="btn btn-md btn-block btn-primary btn-rounded z-depth-1a">Edit Crypto</button>
						</div>
					</center>
				</form>
			</div>
		</div>
	</div>
</main>
</body>
<?php include "footer.php"; ?>
<script>
	$(document).ready(function() {
		$("#errorshow").fadeOut();
	});

	$("form#editwallet").submit(function(e) {
		e.preventDefault();
		var formData = new FormData(this);
		var request = "editwallet";
		var main_id = "<?= $row['main_id']; ?>";
		var barcode = "<?= $row['barcode']; ?>";
		formData.append('request', request);
		formData.append('main_id', main_id);
		formData.append('barcode', barcode);
		$.ajax({
			url: '../../ops/adminauth',
			type: 'POST',
			data: formData,
			beforeSend: function() {
				$('#errorshow').html("Updating Wallet <span class='fas fa-spinner fa-pulse'></span>").fadeIn();
			},
			success: function(data) {
				if (data == "success") {
					$("#errorshow").html("Wallet Edited Successfully. <br> Redirecting <span class='fas fa-spinner fa-spin'></span>").fadeIn();
					setTimeout(function() {
						window.close();
					}, 4000);
				} else {
					$("#errorshow").html(data).fadeIn();
				}
			},
			cache: false,
			error: function(err) {
				$('#errorshow').html("An error has occured!! " + err.statusText).fadeIn();
			},
			contentType: false,
			processData: false
		});
	});
</script>