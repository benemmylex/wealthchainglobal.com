<?php
include "header.php";
if (isset($_GET['main_id'])) {
	$main_id = $_GET['main_id'];
} else {
	header("Location: ./");
	exit();
}

$getTest = $db_conn->prepare("SELECT * FROM testimonials WHERE main_id = :main_id");
$getTest->bindParam(":main_id", $main_id, PDO::PARAM_STR);
$getTest->execute();
$row = $getTest->fetch(PDO::FETCH_ASSOC);
if ($getTest->rowCount() < 1) {
	header("Location: ./");
	exit();
}
?>
<title>Edit Testimonial : <?= SITE_NAME; ?></title>
<main class="mb-5" id="content">
	<div class="container-fluid text-start pt-5 justify-content-center">
		<div class="main shadow-3 col-md-8 mt-3 py-2 me-auto ms-auto">
			<div class="">
				<div class="py-4 card mt-3 me-auto ms-auto mb-5 z-depth-2">
					<div class="card-body pb-4">
						<h4 class="font-weight-bold">Edit Testimonial</h4>
						<p class="">Make changes to Testimonial</p>
						<form class="container mt-4" id="editwallet" enctype="multipart/form-data">
							<div class="form-outline mb-4">
								<input type="text" id="fullname" value="<?= $row['fullname']; ?>" name="fullname" class="form-control">
								<label for="fullname" class="form-label">Fullname</label>
							</div>
							<div class="form-outline mb-4">
								<input type="text" id="role" value="<?= $row['role']; ?>" name="role" class="form-control">
								<label for="role" class="form-label">Role</label>
							</div>
							<div class="form-outline mb-4">
								<textarea type="text" rows="5" aria-label="Comment..." class="form-control" name="comment" id="comment"><?= $row['message']; ?></textarea>
								<label class="form-label" for="Comment">Comment...</label>
							</div>
							<div class="form-group mt-3" align="center">
								<p class="alert alert-primary" id="errorshow"></p>
							</div>
							<center>
								<div class="form-group group-button justify-content-center">
									<button type="submit" id="btnEdit" class="submit btn-primary btn btn-rounded">Save</button>
								</div>
							</center>
						</form>
					</div>
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

	$("form#editwallet").submit(function(e) {
		e.preventDefault();
		var formData = new FormData(this);
		var request = "edittest";
		var main_id = "<?= $row['main_id']; ?>";
		formData.append('request', request);
		formData.append('main_id', main_id);
		$.ajax({
			url: '../../ops/adminauth',
			type: 'POST',
			data: formData,
			beforeSend: function() {
				$('#errorshow').html("Updating <span class='fas fa-spinner fa-pulse'></span>").show();
			},
			success: function(data) {
				let response = $.parseJSON(data);
				if (response.status == "success") {
					$("#errorshow").html(response.message).show();
					setTimeout(function() {
						window.close();
					}, 4000);
				} else {
					$("#errorshow").html(response.message).show();
				}
			},
			cache: false,
			error: function(err) {
				$('#errorshow').html(err.statusText).show();
			},
			contentType: false,
			processData: false
		});
	});
</script>