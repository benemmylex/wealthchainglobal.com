<?php include "header.php";

if (isset($_GET['transcid'])) {
    $transcid = $_GET['transcid'];
} else {
    header('Location: ' . $_SERVER['HTTP_REFERER']);
}

?>
<title>Transaction details</title>
<main class="py-5 mt-5" id="content">
    <div class="container">
        <?php
        $select = $db_conn->prepare("SELECT * FROM comminvest WHERE transc_id = :transc_id");
        $select->bindParam(':transc_id', $transcid, PDO::PARAM_STR);
        $select->execute();
        if ($select->rowCount() < 1) {
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit();
        } else {
            $row = $select->fetch(PDO::FETCH_ASSOC);
            $mem_id = $row['mem_id'];
        }
        ?>
        <div class="card border border-1 border-primary">
            <div class="card-body">
                <h5 class="text-center mb-4 text-uppercase">Investment Details</h5>
                <div class="border-bottom border-4 w-50 mb-4 me-auto ms-auto"></div>
                <div class="">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="fw-bold w-100">
                            <h6 class="fw-bold">Amount: </h6>
                        </div>
                        <div class="w-100">
                            <p class="">$<?= number_format($row['amount'], 2); ?></p>
                        </div>
                    </div>
                    <div class="border-bottom border-2 mb-4"></div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="fw-bold w-100">
                            <h6 class="fw-bold">Asset: </h6>
                        </div>
                        <div class="text-start w-100">
                            <p class=""><?= $row['comm']; ?></p>
                        </div>
                    </div>
                    <div class="border-bottom border-2 mb-4"></div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="fw-bold w-100">
                            <h6 class="fw-bold">Duration: </h6>
                        </div>
                        <div class="text-start w-100">
                            <p class=""><?= $row['duration']; ?></p>
                        </div>
                    </div>
                    <div class="border-bottom border-2 mb-4"></div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="fw-bold w-100">
                            <h6 class="fw-bold">Date: </h6>
                        </div>
                        <div class="w-100">
                            <p class="fw-bold"><?= $row['date_added']; ?></p>
                        </div>
                    </div>
                    <div class="border-bottom border-2 mb-4"></div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="fw-bold w-100">
                            <h6 class="fw-bold">Profit: </h6>
                        </div>
                        <div class="text-start w-100">
                            <p class="">$<?= number_format($row['profit'], 2); ?></p>
                        </div>
                    </div>
                    <div class="border-bottom border-2 mb-4"></div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="fw-bold w-100">
                            <h6 class="fw-bold">Status: </h6>
                        </div>
                        <div class="w-100">
                            <p class="fw-bold"><?= $row['status'] == 0 ? '<span class="text-warning">Pending</span>' : ($row['status'] == 1 ? '<span class="text-success">Active</span>' : '<span class="text-danger">Ended</span>'); ?></p>
                        </div>
                    </div>
                </div>
                <h4 class="fw-bold text-center">Make changes</h4>
				<hr>
				<form id="upgrade" enctype="multipart/form-data" method="POST">
					<div class="my-3 me-auto ms-auto">
						<p class="alert alert-primary" id="errorshows"></p>
					</div>
					<div class="select-wrapper my-3">
					    <select class="select" name="duration" id="duration" required="">
							<option disabled selected>--Select Duration--</option>
							<option <?= $row['duration'] =="1 minute" ? 'selected' : ''; ?> value="1 minute">1 minute</option>
                            <option <?= $row['duration'] =="5 minutes" ? 'selected' : ''; ?> value="5 minutes">5 minutes</option>
                            <option <?= $row['duration'] =="10 minutes" ? 'selected' : ''; ?> value="10 minutes">10 minutes</option>
                            <option <?= $row['duration'] =="30 minutes" ? 'selected' : ''; ?> value="30 minutes">30 minutes</option>
                            <option <?= $row['duration'] =="45 minutes" ? 'selected' : ''; ?> value="45 minutes">45 minutes</option>
                            <option <?= $row['duration'] =="1 hour" ? 'selected' : ''; ?> value="1 hour">1 hour</option>
                            <option <?= $row['duration'] =="2 hours" ? 'selected' : ''; ?> value="2 hours">2 hours</option>
                            <option <?= $row['duration'] =="5 hours" ? 'selected' : ''; ?> value="5 hours">5 hours</option>
                            <option <?= $row['duration'] =="1 day" ? 'selected' : ''; ?> value="1 day">1 day</option>
                            <option <?= $row['duration'] =="3 days" ? 'selected' : ''; ?> value="3 days">3 days</option>
                            <option <?= $row['duration'] =="1 week" ? 'selected' : ''; ?> value="1 week">1 week</option>
                            <option <?= $row['duration'] =="2 weeks" ? 'selected' : ''; ?> value="2 weeks">2 weeks</option>
                            <option <?= $row['duration'] =="1 month" ? 'selected' : ''; ?> value="1 month">1 month</option>
							<option <?= $row['duration'] =="3 months" ? 'selected' : ''; ?> value="3 months">3 Months</option>
                            <option <?= $row['duration'] =="6 months" ? 'selected' : ''; ?> value="6 months">6 months</option>
                            <option <?= $row['duration'] =="1 year" ? 'selected' : ''; ?> value="1 year">1 year</option>
						</select>
					</div>
					<div class="select-wrapper my-3">
					    <select class="select" name="status" id="status" required="">
							<option disabled selected>--Select Duration--</option>
							<option <?= $row['status'] == 0 ? 'selected' : ''; ?> value="0">Pending</option>
							<option <?= $row['status'] == 1 ? 'selected' : ''; ?> value="1">Active</option>
							<option <?= $row['status'] == 2 ? 'selected' : ''; ?> value="2">Ended</option>
						</select>
					</div>
					<div class="form-outline my-3">
						<i class="fas fa-dollar-sign trailing"></i>
						<input type="text" min="10" id="profit" value="<?= $row['profit']; ?>" required name="profit" class="form-control form-icon-trailing">
						<label class="form-label" for="profit">Profit</label>
					</div>
					<div class="my-3" align="center">
						<button type="submit" class="btn btn-md btn-primary btn-rounded">Submit</button>
					</div>
				</form>
            </div>
        </div>
    </div>
</main>
<?php include "footer.php"; ?>
<script>
	$(document).ready(function() {
		$("#errorshows").fadeOut();
	});
	
	$("form#upgrade").submit(function(e) {
		e.preventDefault();
		var formData = new FormData(this);
		var request = "addProfit";
		var mem_id = "<?= $mem_id; ?>";
		var transc_id = "<?= $transcid; ?>";
		formData.append('request', request);
		formData.append('mem_id', mem_id);
		formData.append('transc_id', transc_id);
		$.ajax({
			url: '../../ops/adminauth',
			type: 'POST',
			data: formData,
			beforeSend: function() {
				$('#errorshows').html("Please wait <span class='fas fa-1x fa-spinner fa-spin'></span>").fadeIn();
			},
			success: function(data) {
				if (data == "success") {
					$('#errorshows').html("<span class='fas fa-check-circle'></span> Investment updated successfully").fadeIn();
					setTimeout(function() {
						location.reload();
					}, 3000)
				} else {
					$("#errorshows").html("<span class='fas fa-exclamation-triangle'></span> " + data).fadeIn();
				}
			},
			cache: false,
			error: function(err) {
				$('#errorshows').html("<span class='fas fa-exclamation-triangle'></span> An error has occured!!" + err).fadeIn();
			},
			contentType: false,
			processData: false
		});
	});

</script>

