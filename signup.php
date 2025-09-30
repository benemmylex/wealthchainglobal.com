<?php include "header.php"; ?>
<title>Sign up - <?= SITE_NAME; ?></title>
<section class="account padding-top padding-bottom sec-bg-color2">
	<div class="container">
		<div class="account__wrapper" data-aos="fade-up" data-aos-duration="800">
			<div class="account__inner">
				<div class="row align-items-center">
					<div class="col-lg-6">
						<div class="account__thumb">
							<img src="assets/images/account/1.png" alt="account-image" class="dark">
						</div>
					</div>
					<div class="col-lg-6">
						<div class="account__content account__content--style2">
							<div class="account__header">
								<h2>Register</h2>
								<p class="mb-0">Fill the form below to join this awesome platform</p>
							</div>
							<form id="register" method="POST" class="account__form needs-validation" novalidate>
								<div class="row g-3">
									<div class="col-12 col-md-6">
										<div>
											<label for="fullname" class="form-label">Full name</label>
											<input class="form-control" type="text" name="fullname" id="fullname" placeholder="Ex. John Doe">
										</div>
									</div>
									<div class="col-12 col-md-6">
										<div>
											<label for="username" class="form-label">Username</label>
											<input class="form-control" name="username" type="text" id="username" placeholder="Ex. Johnny">
										</div>
									</div>
									<div class="col-12">
										<div>
											<label for="email" class="form-label">Email Address</label>
											<input type="email" class="form-control" name="email" id="email" placeholder="Enter your email"
											required>
										</div>
									</div>
									<div class="col-12 col-md-6">
										<div class="selectr-container">
											<label for="country" class="form-label">Country</label>
											<select class="form-control py-3" name="country" id="country">
												<option disabled selected="">Select a Country</option>
												<?php $sql = $db_conn->prepare("SELECT * FROM countries");
												$sql->execute();
												while($rows = $sql->fetch(PDO::FETCH_ASSOC)):
													?>
													<option data-tokens="<?= $rows['country_name']; ?>" value="<?= $rows['country_name']; ?>"><?= $rows['country_name']; ?></option>
												<?php endwhile; ?>
											</select>
										</div>
									</div>
									<div class="col-12 col-md-6">
										<div class="selectr-container">
											<label for="currency" class="form-label">Currency</label>
											<select class="form-control py-3" name="currency" id="currency">
												<option disabled selected="">Select Currency</option>
												<option value="EUR">Euro</option>
												<option value="USD">US Dollar</option>
												<option value="GBP">Pounds</option>
											</select>
										</div>
									</div>
									<div class="col-12 col-md-12">
										<div>
											<label for="phone" class="form-label">Phone number</label>
											<input type="text" class="form-control" name="phone" id="phone" placeholder="Enter your phone number"
											required>
										</div>
									</div>
									<div class="col-12">
										<div class="form-pass">
											<label for="password" class="form-label">Password</label>
											<input type="password" name="password" class="form-control showhide-pass" id="password" placeholder="Password" required>
											<button onclick="showpass('password', 'eyeIcon1')" type="button" id="btnToggle1" class="form-pass__toggle"><i id="eyeIcon1" class="fa-solid fa-eye"></i>
											</button>
										</div>
									</div>
									<div class="col-12">
										<div class="form-pass">
											<label for="confirmpassword" class="form-label">Confirm Password</label>
											<input type="password" class="form-control showhide-pass" id="confirmpassword" name="confirmpassword" 
											placeholder="Re-type password" required>

											<button onclick="showpass('confirmpassword', 'eyeIcon')" type="button" id="btnToggle" class="form-pass__toggle"><i id="eyeIcon" class="fa-solid fa-eye"></i></button>
										</div>
									</div>
								</div>
								<div class="account__check">
									<div class="account__check-remember">
										<input type="checkbox" class="form-check-input" value="accepted" id="terms" name="terms">
										<label for="terms-check" class="form-check-label">
											Accept our <a href="./terms">terms and conditions</a>
										</label>
									</div>
								</div>
								<p class="my-3 alert alert-success" id="errorshow1" role="alert"></p>
								<button type="submit" class="trk-btn trk-btn--border trk-btn--primary d-block mt-4">Sign Up</button>
							</form>
							<div class="account__switch">
								<p>Don’t have an account yet? <a href="signin">Login</a></p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>


<?php include "sfooter.php"; ?>
<script>
	$(document).ready(function(){
		$("#errorshow1").hide();
	});

		$("form#register").submit(function(e) {
			e.preventDefault();  
			var formData = new FormData(this);
			formData.append('request', 'signup');
			if ($("#country").val() == null) {
				$("#errorshow1").html("Select a country").show();
				setTimeout(function(){
					$("#errorshow1").hide();
				}, 10000);
			}else{
				$.ajax({
					url: './ops/users',
					type: 'POST',
					data: formData,
					beforeSend:function(){
						$('#errorshow1').html("Creating account <span class='fas fa-spinner fa-spin'></span>").show();
					},
					success: function (data) {
					    let resp = $.parseJSON(data);
						if (resp.status == "success") {
				// 			document.getElementById("errorshow1").scrollIntoView(true);
							$("#errorshow1").html(resp.message).show();
							setTimeout(' window.location.href = "./signin"; ', 10000);
						}else{
				// 			document.getElementById("errorshow1").scrollIntoView(true);
							$("#errorshow1").html(resp.message).show();
							setTimeout(function(){
								$("#errorshow1").hide();
							}, 10000);
						}   
					},
					cache: false,
					error:function(){
						$('#errorshow1').html("An error has occured!!").show();
						setTimeout(function(){
							$("#errorshow1").hide();
						}, 10000);
					},
					contentType: false,
					processData: false
				});
			}
		});
</script>