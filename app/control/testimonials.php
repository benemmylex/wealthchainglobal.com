<?php

include 'header.php';

?>
<title>Add/View Testimonials | <?= SITE_NAME; ?></title>
<main class="my-5 pt-3" id="content">
	<div class="container text-start py-3 justify-content-center">
		<div class="card shadow-3 me-auto ms-auto">
			<div class="card-body">
				<!-- Pills navs -->
				<ul class="nav nav-pills nav-fill mb-3" id="ex1" role="tablist">
					<li class="nav-item" role="presentation">
						<a class="nav-link active text-nowrap" id="ex3-tab-1" data-mdb-toggle="pill" href="#acrypto" role="tab" aria-controls="acrypto" aria-selected="true"><i class="fas fa-user-secret fa-fw me-2"></i> Testimonials</a>
					</li>
					<li class="nav-item" role="presentation">
						<a class="nav-link text-nowrap" id="ex3-tab-2" data-mdb-toggle="pill" href="#addadmin" role="tab" aria-controls="addadmin" aria-selected="false"><i class="fas fa-edit fa-fw me-2"></i>Add New</a>
					</li>
				</ul>
				<!-- Pills navs -->
				<!-- Pills content -->
				<div class="tab-content" id="ex2-content">
					<div class="tab-pane fade show active" id="acrypto" role="tabpanel" aria-labelledby="ex3-tab-1">
						<div class="mt-4">
							<div class="col-md-6 me-auto ms-auto" align="center">
								<p class="alert" id="errorshow1"></p>
							</div>
							<div class="table-wrapper table-responsive">
								<table class="table table-striped table-hover" id="allcrypto" style="color: var(--text);">
									<thead>
										<tr class="text-nowrap">
											<th scope="col-sm">S/N</th>
											<th scope="col">Name</th>
											<th scope="col">Role</th>
											<th scope="col">Edit</th>
											<th scope="col">Delete</th>
										</tr>
									</thead>
									<?php
									$sql = $db_conn->prepare("SELECT * FROM testimonials ORDER BY main_id DESC");
									$sql->execute();
									$b = 1;
									?>
									<tbody>
										<div class="text-center" align="center">
											<?php if ($sql->rowCount() < 1) {
												echo "<td class='text-center' colspan='6'>No data available</td>";
											} else {
												while ($row = $sql->fetch(PDO::FETCH_ASSOC)) : ?></div>
										<tr class="text-nowrap">
											<td scope="row"><?= $b; ?></td>
											<td class="text-left"><?= $row['fullname']; ?></td>
											<td class="text-left"><?= $row['role']; ?></td>
											<td class="text-left"><a class="btn btn-sm btn-rounded btn-primary" href="edittest?main_id=<?= $row['main_id']; ?>" target="_blank">Edit</a></td>
											<td class="text-left"><button style="cursor: pointer;" class='btn btn-danger btn-rounded btn-sm' id='btnDel_<?= $row["main_id"]; ?>'> Delete</button></td>
											<script>
												function dele_<?= $row['main_id']; ?>() {
													var main_id = "<?= $row['main_id']; ?>";
													$.ajax({
														type: 'POST',
														url: '../../ops/adminauth.php',
														data: {
															request: 'deletetest',
															'main_id': main_id
														},
														beforeSend: function() {
															$('#errorshow1').html("Deleting <span class='far fa-spinner fa-spin'></span>").show();
														},
														success: function(data) {
															let response = $.parseJSON(data);
															if (response.status == "success") {
																$("#errorshow1").html(response.message).show();
																setTimeout(() => {
																	location.reload();
																}, 3000);
															} else {
																$("#errorshow1").html(response.message).show();
															}
														},
														error: function(err) {
															$("#errorshow1").html(err.statusText).show();
														}
													});
												}

												$('#btnDel_<?= $row['main_id']; ?>').click(function() {
													dele_<?= $row['main_id']; ?>();
												});
												//End Revoke
											</script>
									<?php $b++;
												endwhile;
											} ?>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
					<div class="tab-pane fade" id="addadmin" role="tabpanel" aria-labelledby="ex3-tab-2">
						<div class="mt-4">
							<div class="main narrower mb-4 mr-auto ml-auto">
								<div class="card-body col-md-8 me-auto ms-auto card-body-cascade px-1">
									<h5 class="font-weight-bold">Add Testmonials</h5>
									<p>Fill the form below to add a new testimonial </p>
									<form class="container mt-3" id="addamin" enctype="multipart/form-data">
										<div class="form-outline mb-4">
											<input type="text" id="fullname" name="fullname" class="form-control">
											<label for="fullname" class="form-label">Full name</label>
										</div>
										<div class="form-outline mb-4">
											<input type="text" id="role" name="role" class="form-control">
											<label for="role" class="form-label">Role</label>
										</div>
										<div class="form-outline mb-4">
											<textarea type="text" rows="5" aria-label="Comment..." class="form-control" name="comment" id="comment"></textarea>
											<label class="form-label" for="Comment">Comment...</label>
										</div>
										<div class="form-group mt-3" align="center">
											<p class="alert alert-primary" id="errorshow2"></p>
										</div>
										<center>
											<div class="text-center">
												<button type="submit" id="btnAdd" class="btn btn-md btn-primary">Add</button>
											</div>
										</center>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</main>
</body>
<?php include 'footer.php'; ?>
<script>
	$(document).ready(function() {
		$("#errorshow1").hide();
		$("#errorshow2").hide();

		var one = $('#allcrypto').DataTable({
			"pagingType": 'simple_numbers',
			"lengthChange": true,
			"pageLength": 6,
			dom: 'Bfrtip'
		});
	});

	$("form#addamin").submit(function(e) {
		e.preventDefault();
		var formData = new FormData(this);
		var request = "addtest";
		formData.append('request', request);
		$.ajax({
			url: '../../ops/adminauth',
			type: 'POST',
			data: formData,
			beforeSend: function() {
				$('#errorshow2').html("Adding Testimonial <span class='fas fa-spinner fa-pulse'></span>").show();
			},
			success: function(data) {
				let response = $.parseJSON(data);
				if (response.status == "success") {
					$("#errorshow2").html(response.message).show();
					setTimeout(() => {
						location.reload();
					}, 3000);
				} else {
					$("#errorshow2").html(response.message).show();
				}
			},
			cache: false,
			error: function(err) {
				$('#errorshow2').html(err.statusText).show();
			},
			contentType: false,
			processData: false
		});
	});
</script>