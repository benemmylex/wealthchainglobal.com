<?php include "header.php";

if (isset($_GET['user'])) {
	$mem_id = $_GET['user'];
	$getUser = $db_conn->prepare("SELECT * FROM members WHERE mem_id = :user");
	$getUser->bindParam(":user", $mem_id, PDO::PARAM_STR);
	$getUser->execute();
	if ($getUser->rowCount() < 1) {
		header("Location: ./");
		exit();
	}
} else {
	header("Location: ./");
	exit();
}

?>
<title>Send Popup Message - <?php echo SITE_NAME; ?></title>
<main class="py-5 px-2" id="content">
	<div class="container text-start pt-5">
		<h3 class="fw-bold ps-3"><i class="fas fa-tachometer-alt"></i> Hello, <?= $admusername; ?></h3>
		<p class="small mt-0 pt-0 ps-3">Send Popup Messages</p>
		<div class="card shadow-3">
			<div class="card-body">
				<h3 class="font-weight-bold">Send Message</h3>
				<p class="">Send a popup message to user like notifications</p>
				<form class="" id="popup" enctype="multipart/form-data">
					<div class="form-outline mt-5 mb-5">
						<i class="far fa-book text-primary trailing"></i>
						<input type="text" aria-label="Subject" class="form-control form-icon-trailing" name="subject" id="subject">
						<label class="form-label" for="subject">Subject</label>
					</div>
					<div class="form-outline mt-5 mb-5">
						<i class="far fa-envelope-open orange-text trailing"></i>
						<textarea type="text" rows="5" aria-label="Message..." class="form-control form-icon-trailing" name="message" id="message"></textarea>
						<label class="form-label" for="message">Message...</label>
					</div>
					<div class="form-group" align="center">
						<p class="alert alert-primary" id="errorshow"></p>
					</div>
					<center>
						<div class="text-center align-items-center ms-auto me-auto mb-2 col-md-5">
							<button type="submit" id="btnSend" class="btn btn-md btn-primary btn-block btn-rounded">Send Message</button>
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

	$("form#popup").submit(function(e) {
		e.preventDefault();
		var formData = new FormData(this);
		var request = "sendpopup";
		var mem_id = "<?= $mem_id; ?>";
		formData.append('request', request);
		formData.append('mem_id', mem_id);
		$.ajax({
			url: '../../ops/adminauth',
			type: 'POST',
			data: formData,
			beforeSend: function() {
				$('#errorshow').html("Sending message <span class='far fa-1x fa-spinner fa-spin'></span>").fadeIn();
			},
			success: function(data) {
				if (data == "success") {
					$('#errorshow').html("<span class='far fa-check-circle'></span> Popup Message Sent Successfully!!").fadeIn();
					setTimeout(' window.location.href = "./users"; ', 3000);
				} else {
					$("#errorshow").html(data).fadeIn();
				}
			},
			cache: false,
			error: function(err) {
				$('#errorshow').html("<span class='far fa-exclamation-triangle'></span> An error has occured!!" + err).fadeIn();
			},
			contentType: false,
			processData: false
		});
	});
</script>