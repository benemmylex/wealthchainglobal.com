<?php include "header.php";
?>
<title>Add new trader : <?= SITE_NAME; ?></title>
<main class="py-5 px-2" id="content">
	<div class="container text-start pt-5">
		<h3 class="font-weight-bold black-text ps-3"><i class="fas fa-tachometer-alt"></i> Hello, <?= $admusername; ?></h3>
		<p class="small mt-0 pt-0 ps-3">Add Trader</p>
		<div class="card shadow-3 mt-3">
			<div class="card-body">
				<h3 class="font-weight-bold">Add new trader</h3>
				<p class="black-text">Fill details to add a new trader All fields are required</p>
				<form id="addtrader" enctype="multipart/form-data" method="POST">
					<div class="form-outline mb-4">
						<input type="text" id="t_name" name="t_name" placeholder="John Doe" class="form-control">
						<label for="t_name" class="form-label">Trader Name (e.g. Samuel)</label>
					</div>
					<div class="form-outline mb-4">
						<input type="text" id="t_win_rate" placeholder="99.9" name="t_win_rate" class="form-control">
						<label for="t_win_rate" class="form-label">Win Rate</label>
					</div>
					<div class="form-outline mb-4">
						<input type="text" id="t_profit_share" placeholder="10" name="t_profit_share" class="form-control">
						<label for="t_profit_share" class="form-label">Profit Share</label>
					</div>
					<div class="form-outline mb-4">
						<input type="text" id="t_minimum" placeholder="10" name="t_minimum" value="0" class="form-control">
						<label for="t_minimum" class="form-label">Minimum Deposit</label>
					</div>
					<div class="form-outline mb-4">
						<input type="text" id="t_followers" placeholder="Followers (e.g 1000)" name="t_followers" class="form-control">
						<label for="t_followers" class="form-label">Followers</label>
					</div>
					<div class="form-outline mb-4">
						<input type="text" id="t_total_win" placeholder="Total wins" name="t_total_win" class="form-control">
						<label for="t_total_win" class="form-label">Total wins</label>
					</div>
					<div class="form-outline mb-4">
						<input type="text" id="t_total_loss" placeholder="Total loss" name="t_total_loss" class="form-control">
						<label for="t_total_loss" class="form-label">Total loss</label>
					</div>
					<div class="form-group mb-4">
						<label>Stars</label>
						<select required class="select" id="stars" name="stars">
							<option value="1">1</option>
							<option value="2">2</option>
							<option value="3">3</option>
							<option value="4">4</option>
							<option value="5">5</option>
						</select>
					</div>
					<div class="form-group">
						<label class="form-label" for="photo"> Upload Image <span class="fas fa-cloud-upload-alt"></span></label>
						<input type="file" id="photo" class="form-control" name="photo">
					</div>
					<div class="form-group my-3" align="center">
						<p class="alert alert-primary" id="errorshow"></p>
					</div>
					<div class="col-md-6 me-auto ms-auto">
						<button type="submit" id="btnEdit" class="btn btn-md btn-block btn-primary btn-rounded z-depth-1a">Add</button>
					</div>
				</form>
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

	$("form#addtrader").submit(function(e) {
		e.preventDefault();
		var formData = new FormData(this);
		var request = "addTrader";
		formData.append("request", request);
		$.ajax({
			url: '../../ops/adminauth',
			type: 'POST',
			data: formData,
			beforeSend: function() {
				$('#errorshow').html("Adding new trader, please wait <span class='far fa-spinner fa-pulse'></span>").show();
			},
			success: function(data) {
				if (data == "success") {
					$("#errorshow").html("New Trader Added Successfully. <br> Redirecting <span class='far fa-spinner fa-spin'></span>").show();
					setTimeout(function() {
						location.reload();
					}, 4000);
				} else {
					$("#errorshow").html("<span class='far fa-exclamation-triangle'></span> " + data).show();
				}
			},
			cache: false,
			error: function(err) {
				$('#errorshow').html("<span class='far fa-exclamation-triangle'></span> An error has occured!! " + err).show();
			},
			contentType: false,
			processData: false
		});
	});
</script>