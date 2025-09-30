<?php include "header.php"; ?>
<title>Send Mail - <?php echo SITE_NAME; ?></title>
<main class="py-5 px-2" id="content">
	<div class="container text-start pt-5">
		<h3 class="fw-bold ps-3"><i class="fas fa-tachometer-alt"></i> Hello, <?= $admusername; ?></h3>
		<p class="small mt-0 pt-0 ps-3">Send Mail</p>
		<div class="card shadow-3">
			<div class="card-body">
				<h3 class="fw-bold">Send Mail</h3>
				<p class="">Send an email now!</p>
				<form class="" id="sendmail" enctype="multipart/form-data">
					<div class="form-outline mb-5">
						<i class="far fa-user trailing"></i>
						<input type="text" aria-label="Name" class="form-control form-icon-trailing" name="name" id="name">
						<label class="form-label" for="name">Name</label>
					</div>
					<div class="form-outline mb-5">
						<i class="far fa-envelope trailing"></i>
						<input type="email" aria-label="Email Address" class="form-control form-icon-trailing" name="email" id="email">
						<label class="form-label" for="email">Email Address</label>
					</div>
					<div class="form-outline mb-5">
						<i class="far fa-book trailing"></i>
						<input type="text" aria-label="Subject" class="form-control form-icon-trailing" name="subject" id="subject">
						<label class="form-label" for="subject">Subject</label>
					</div>
					<div class="form-outline mb-5">
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

	$("form#sendmail").submit(function(e) {
		e.preventDefault();
		var formData = new FormData(this);
		var request = "sendmail";
		formData.append('request', request);
		$.ajax({
			url: '../../ops/adminauth',
			type: 'POST',
			data: formData,
			beforeSend: function() {
				$('#errorshow').html("Sending mail <span class='fas fa-spinner fa-spin'></span>").fadeIn();
			},
			success: function(data) {
				if (data == "success") {
					$('#errorshow').html("Mail sent successfully").fadeIn();
					setTimeout(() => {
						location.reload();
					}, 3000);
				} else {
					$("#errorshow").html(data).fadeIn();
				}
			},
			cache: false,
			error: function(err) {
				$('#errorshow').html("An error has occured!!" + err.statusText).fadeIn();
			},
			contentType: false,
			processData: false
		});
	});
</script>