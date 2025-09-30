<?php include "header.php";
if (isset($_GET['tid'])) {
	$trader_id = $_GET['tid'];
} else {
	header("Location: ./");
	exit();
}

$getTrader = $db_conn->prepare("SELECT * FROM traders WHERE trader_id = :trader_id");
$getTrader->bindParam(":trader_id", $trader_id, PDO::PARAM_STR);
$getTrader->execute();
$row = $getTrader->fetch(PDO::FETCH_ASSOC);

if ($getTrader->rowCount() < 1) {
	header("Location: ./");
	exit();
}
?>
<title>Edit Trader : <?= SITE_NAME; ?></title>
<main class="py-5 px-2" id="content">
	<div class="container text-start pt-5">
		<div class="card">
			<div class="card-body">
				<h3 class="font-weight-bold">Edit trader data</h3>
				<p class="">Fill details to edit trader. * All fields are required</p>
				<div class="col-md-12 me-auto ms-auto">
					<form class="md-form" id="edittrader" enctype="multipart/form-data">
						<h5>Basic Details</h5>
						<hr>
						<div class="row">
							<div class="col-md-12">
								<div class="form-outline mb-4">
									<i class="fas fa-user trailing"></i>
									<input type="text" id="t_name" value="<?= $row['t_name']; ?>" name="t_name" class="form-control form-icon-trailing">
									<label for="t_name" class="form-label">Trader Name (e.g. Samuel)</label>
								</div>
							</div>
							<div class="col-md-12">
								<div class="form-outline mb-4">
									<i class="fas fa-chart-line trailing"></i>
									<input type="text" id="t_win_rate" value="<?= $row['t_win_rate']; ?>" name="t_win_rate" class="form-control">
									<label for="t_win_rate" class="form-label">Win Rate</label>
								</div>
							</div>
							<div class="col-md-12">
								<div class="form-outline mb-4">
									<i class="far fa-chart-bar trailing"></i>
									<input type="text" id="t_profit_share" value="<?= $row['t_profit_share']; ?>" name="t_profit_share" class="form-control form-icon-trailing">
									<label for="t_profit_share" class="form-label">Profit Share</label>
								</div>
							</div>
							<div class="col-md-12">
								<div class="form-outline mb-4">
									<i class="far fa-chart-bar trailing"></i>
									<input type="text" id="t_minimum" value="<?= $row['t_minimum']; ?>" name="t_minimum" class="form-control form-icon-trailing">
									<label for="t_minimum" class="form-label">Minimum Deposit</label>
								</div>
							</div>
							<div class="col-md-12">
								<div class="form-outline mb-4">
									<input type="text" id="t_followers" placeholder="Followers (e.g 1000)" name="t_followers" value="<?= $row['t_followers']; ?>" class="form-control">
									<label for="t_followers" class="form-label">Followers</label>
								</div>
							</div>
							<div class="col-md-12">
								<div class="form-outline mb-4">
									<input type="text" id="t_total_win" placeholder="Total wins" name="t_total_win" value="<?= $row['t_total_win']; ?>" class="form-control">
									<label for="t_total_win" class="form-label">Total wins</label>
								</div>
							</div>
							<div class="col-md-12">
								<div class="form-outline mb-4">
									<input type="text" id="t_total_loss" placeholder="Total loss" name="t_total_loss" value="<?= $row['t_total_loss']; ?>" class="form-control">
									<label for="t_total_loss" class="form-label">Total loss</label>
								</div>
							</div>
							<div class="col-md-12">
								<div class="form-group mb-4">
									<label>Stars</label>
									<select required class="select" id="stars" name="stars">
										<option <?= $row['stars'] == 1 ? "selected" : ''; ?> value="1">1</option>
										<option <?= $row['stars'] == 2 ? "selected" : ''; ?> value="2">2</option>
										<option <?= $row['stars'] == 3 ? "selected" : ''; ?> value="3">3</option>
										<option <?= $row['stars'] == 4 ? "selected" : ''; ?> value="4">4</option>
										<option <?= $row['stars'] == 5 ? "selected" : ''; ?> value="5">5</option>
									</select>
								</div>
							</div>
						</div>
						<hr>
						<div class="md-form">
							<label class="form-label" for="photo"> Upload Image <span class="fas fa-cloud-upload-alt"></span></label>
							<input type="file" id="photo" class="form-control" name="photo">
						</div>
						<div class="form-group mt-3">
							<p class="alert alert-primary" id="errorshow"></p>
						</div>
						<center>
							<div class="col-md-5 ms-auto me-auto mb-3 mt-3">
								<button type="submit" id="btnEdit" class="btn btn-md btn-block btn-primary btn-rounded z-depth-1a">Edit Trader</button>
							</div>
						</center>
					</form>
				</div>
			</div>
		</div>
	</div>
</main>
</body>
<?php include "footer.php"; ?>
<script>
	$(document).ready(function() {
		$("#errorshow").hide();
	});

	$("form#edittrader").submit(function(e) {
		e.preventDefault();
		var formData = new FormData(this);
		var myphoto = "<?= $row['t_photo1']; ?>";
		var trader_id = "<?= $row['trader_id']; ?>";
		var request = "editTrader";
		formData.append("request", request);
		formData.append("myphoto", myphoto);
		formData.append("trader_id", trader_id);
		$.ajax({
			url: '../../ops/adminauth',
			type: 'POST',
			data: formData,
			beforeSend: function() {
				$('#errorshow').html("Updating trader details, please wait <span class='far fa-spinner fa-pulse'></span>").show();
			},
			success: function(data) {
				if (data == "success") {
					$("#errorshow").html("Details updated Successfully. <br> Redirecting <span class='far fa-spinner fa-spin'></span>").show();
					setTimeout(function() {
						window.close();
					}, 4000);
				} else {
					$("#errorshow").html(data).show();
				}
			},
			cache: false,
			error: function(err) {
				$('#errorshow').html("An error has occured!! " + err.statusText).show();
			},
			contentType: false,
			processData: false
		});
	});
</script>