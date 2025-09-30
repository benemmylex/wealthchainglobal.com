<?php include 'header.php'; ?>
<title>Settings | <?= SITE_NAME; ?></title>
<main class="py-5 px-2" id="content">
	<div class="container text-start pt-5">
		<div class="shadow-3">
			<!-- Pills navs -->
			<ul class="nav nav-pills nav-fill mb-3" id="ex1" role="tablist">
				<li class="nav-item" role="presentation">
					<a class="nav-link active text-nowrap" id="ex3-tab-1" data-mdb-toggle="pill" href="#ex3-pills-1" role="tab" aria-controls="ex3-pills-1" aria-selected="true"><i class="fas fa-lock fa-fw me-2"></i> Change Password</a>
				</li>
				<li class="nav-item" role="presentation">
					<a class="nav-link text-nowrap" id="ex3-tab-2" data-mdb-toggle="pill" href="#ex3-pills-2" role="tab" aria-controls="ex3-pills-2" aria-selected="false"><i class="fas fa-cogs fa-fw me-2"></i>Edit Profile</a>
				</li>
				<li class="nav-item" role="presentation">
					<a class="nav-link text-nowrap" id="ex3-tab-3" data-mdb-toggle="pill" href="#ex3-pills-3" role="tab" aria-controls="ex3-pills-3" aria-selected="false"><i class="fas fa-user fa-fw me-2"></i>Profile</a>
				</li>
			</ul>
			<!-- Pills navs -->
			<!-- Pills content -->
			<div class="tab-content card" id="ex2-content">
				<div class="tab-pane fade show active" id="ex3-pills-1" role="tabpanel" aria-labelledby="ex3-tab-1">
					<div class="card-body">
						<div class="col-md-6 me-auto ms-auto">
							<h2 class="text-left fw-bold mb-1 text-primary">Change Password</h2>
							<p class="text-start mt-1">Fill form to change your password </p>
							<form class="" method="POST" enctype="multipart/form-data" id="passForm">
								<div class="form-outline mt-3 mb-4">
									<i onclick="showpass('password', 'showpass')" id="showpass" style="cursor: pointer; right: 10px; top: 8px; position: absolute; z-index: 1000;">
										<span class="fas fa-eye"></span>
									</i>
									<input type="password" aria-label="Password" class="form-control form-icon-trailing" name="password" id="password">
									<label class="form-label" for="password">Old Password</label>
								</div>
								<div class="form-outline mt-3 mb-4">
									<i onclick="showpass('newpassword', 'showpass1')" id="showpass1" style="cursor: pointer; right: 10px; top: 8px; position: absolute; z-index: 1000;">
										<span class="fas fa-eye"></span>
									</i>
									<input type="password" aria-label="Password" class="form-control form-icon-trailing" name="newpassword" id="newpassword">
									<label class="form-label" for="newpassword">New Password</label>
								</div>
								<div class="form-outline mt-3 mb-2">
									<i onclick="showpass('conpassword', 'showpass2')" id="showpass2" style="cursor: pointer; right: 10px; top: 8px; position: absolute; z-index: 1000;">
										<span class="fas fa-eye"></span>
									</i>
									<input type="password" aria-label="Password" class="form-control form-icon-trailing" name="conpassword" id="conpassword">
									<label class="form-label" for="conpassword">Confirm Password</label>
								</div>
								<p class="alert alert-primary" id="errorpass"></p>
								<div class="text-center col-md-6 me-auto ms-auto mb-3">
									<button type="submit" id="chgPass" class="mt-4 btn-block btn btn-md btn-primary btn-rounded">Change Password</button>
								</div>
							</form>
						</div>
					</div>
				</div>
				<div class="tab-pane fade" id="ex3-pills-2" role="tabpanel" aria-labelledby="ex3-tab-2">
					<div class="card-body">
						<div class="col-md-6 me-auto ms-auto">
							<h2 class="text-start fw-bold mb-1 text-primary">Edit Profile</h2>
							<p class="text-start mt-1">Fill the form to edit your profile </p>
							<form class="" id="editprofile" enctype="multipart/form-data">
								<div class="form-outline mb-5">
									<i class="fas text-primary fa-user trailing"></i>
									<input type="text" value="<?= $_SESSION['admusername']; ?>" id="username" required="" name="username" class="form-control form-icon-trailing">
									<label for="username" class="form-label">Full name</label>
								</div>
								<div class="form-outline mb-5">
									<i class="fas text-primary fa-envelope trailing"></i>
									<input type="email" value="<?= $_SESSION['admemail']; ?>" id="email" required="" name="email" class="form-control form-icon-trailing">
									<label for="email" class="form-label">Email Address</label>
								</div>
								<div class="form-outline mb-3">
									<i class="fas text-primary fa-phone-square trailing"></i>
									<input type="text" id="phone" required="" value="<?= $_SESSION['admphone']; ?>" name="phone" class="form-control form-icon-trailing">
									<label for="phone" class="form-label">Phone Number</label>
								</div>
								<div class="form-group mb-3">
                                    <label class="form-label mb-2" for="actpart">Enforce Kyc</label>
                                    <select class="form-control browser-default" readonly data-mdb-select-initialized="true" required id="actpart" name="actpart">
                                        <option value="1" <?= $_SESSION['actpart'] == 1 ? 'selected' : '' ; ?>>Active</option>
                                        <option value="0" <?= $_SESSION['actpart'] == 0 ? 'selected' : '' ; ?>>Inactive</option>
                                    </select>
                                </div>
								<p class="alert alert-primary" id="erroredit"></p>
								<div class="text-center col-md-6 me-auto ms-auto mb-3">
									<button type="submit" id="btnEdit" class="btn btn-md btn-block btn-primary btn-rounded z-depth-1a">Update Details</button>
								</div>
							</form>
						</div>
					</div>
				</div> 
				<div class="tab-pane fade" id="ex3-pills-3" role="tabpanel" aria-labelledby="ex3-tab-3">
					<div class="card-body">
						<div class="col-md-6 me-auto ms-auto">
							<h2 class="text-left font-weight-bold mb-1 text-primary">My Profile</h2>
							<hr>
							<div class="d-flex mt-4 mb-5">
								<div class="justify-content-start me-auto"><span class="font-weight-bold mb-2" style="line-height:1.8;">Admin ID</span></div>
								<div class="justify-content-end ps-5"><span class="mb-2" style="line-height:1.8; font-size: .88rem;">#<?= $_SESSION['admin_id']; ?></span></div>
							</div>
							<div class="d-flex mt-4 mb-5">
								<div class="justify-content-start me-auto"><span class="font-weight-bold mb-2" style="line-height:1.8;">Name</span></div>
								<div class="justify-content-end ps-5"><span class="mb-2" style="line-height:1.8; font-size: .88rem;"><?= $_SESSION['admusername']; ?></span></div>
							</div>
							<div class="d-flex mt-4 mb-5">
								<div class="justify-content-start me-auto"><span class="font-weight-bold mb-2" style="line-height:1.8;">Email</span></div>
								<div class="justify-content-end ps-5"><span class="mb-2" style="line-height:1.8; font-size: .88rem;"><?= $_SESSION['admemail']; ?></span></div>
							</div>
							<div class="d-flex mt-4 mb-5">
								<div class="justify-content-start me-auto"><span class="font-weight-bold mb-2" style="line-height:1.8;">Phone number</span></div>
								<div class="justify-content-end ps-5"><span class="mb-2" style="line-height:1.8; font-size: .88rem;"><?= $_SESSION['admphone']; ?></span></div>
							</div>
							<div class="d-flex mt-4 mb-5">
								<div class="justify-content-start me-auto"><span class="font-weight-bold mb-2" style="line-height:1.8;">Role</span></div>
								<div class="justify-content-end ps-5"><span class="mb-2" style="line-height:1.8; font-size: .88rem;"><?= $_SESSION['level']; ?></span></div>
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
		$("#errorpass").fadeOut();
		$("#erroredit").fadeOut();
	});

	const showpass = (pass, span) => {
		let password = document.getElementById(pass);
		if (password.type == 'password') {
			password.type = 'text';
			$('#' + span).html("<span class= 'fas fa-eye-slash'></span>");
		} else {
			password.type = 'password';
			$('#' + span).html("<span class= 'fas fa-eye'></span>");
		}
	}

	$("form#passForm").submit(function(e) {
		e.preventDefault();
		var formData = new FormData(this);
		var request = "changepassword";
		formData.append('request', request);
		$.ajax({
			url: '../../ops/adminauth',
			type: 'POST',
			data: formData,
			beforeSend: function() {
				$("#errorpass").html("Saving new password <span class='fas fa-spinner fa-pulse'></span>").fadeIn();
			},
			success: function(data) {
				setTimeout(function() {
					if (data == 'success') {
						$("#errorpass").html("Password was changed successfully").fadeIn();
						setTimeout(function() {
							location.reload();
						}, 4000);
					} else {
						$("#errorpass").html(data).fadeIn();
					}
				}, 1000);
			},
			cache: false,
			error: function(err) {
				setTimeout(function() {
					$("#errorpass").html("An error occured " + err.statusText).fadeIn();
				}, 1000);
			},
			contentType: false,
			processData: false
		});
	});


	$("form#editprofile").submit(function(e) {
		e.preventDefault();
		var formData = new FormData(this);
		var request = "editprofile";
		formData.append('request', request);
		$.ajax({
			url: '../../ops/adminauth',
			type: 'POST',
			data: formData,
			beforeSend: function() {
				$("#erroredit").html("Saving changes <span class='fas fa-spinner fa-pulse'></span>").fadeIn();
			},
			success: function(data) {
				setTimeout(function() {
					if (data == 'success') {
						$("#erroredit").html("Changes saved successfully").fadeIn();
						setTimeout(function() {
							location.reload();
						}, 4000);
					} else {
						$("#erroredit").html(data).fadeIn();
					}
				}, 1000);
			},
			cache: false,
			error: function(err) {
				setTimeout(function() {
					$("#erroredit").html("An error occured " + err.statusText).fadeIn();
				}, 1000);
			},
			contentType: false,
			processData: false
		});
	});
</script>