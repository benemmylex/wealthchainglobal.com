<?php include "header.php"; ?>
<title>Sign in - <?= SITE_NAME; ?></title>
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
								<h2>Log in</h2>
								<p class="mb-0">Enter your details below to sign in</p>
							</div>
							<form id="loginForm" method="POST" class="account__form needs-validation" novalidate>
								<div class="row g-4">
									<div class="col-12">
										<div>
											<label for="username" class="form-label">Username/Email</label>
											<input type="text" class="form-control" id="username" name="username" placeholder="Enter your username or email"
											required>
										</div>
									</div>
									<div class="col-12">
										<div class="form-pass">
											<label for="password" class="form-label">Password</label>
											<input type="password" class="form-control showhide-pass" id="password" name="password" placeholder="Password" required>

											<button onclick="showpass('password', 'eyeIcon')" type="button" id="btnToggle" class="form-pass__toggle"><i id="eyeIcon" class="fa-solid fa-eye"></i></button>
										</div>
									</div>
								</div>

								<div class="account__check">

									<div class="account__check-remember">
										<input type="checkbox" class="form-check-input" value="" id="terms-check">
										<label for="terms-check" class="form-check-label">
											Remember me
										</label>
									</div>
									<div class="account__check-forgot">
										<a href="forgot-password">Forgot Password?</a>
									</div>
								</div>
								<p class="my-3 alert alert-success" id="errorshow1" role="alert"></p>
								<button type="submit" class="trk-btn trk-btn--border trk-btn--primary d-block mt-4">Sign in</button>
							</form>
							<div class="account__switch">
								<p>Don't have an account? <a href="signup">Sign up</a></p>
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

    $("form#loginForm").submit(function(e) {
        e.preventDefault();    
        var formData = new FormData(this);
        formData.append('request', 'login');
        $.ajax({
            url: './ops/users',
            type: 'POST',
            data: formData,
            beforeSend:function(){
                $('#errorshow1').html("logging in <span class='fas fa-1x fa-spinner fa-spin'></span>").show();
            },
            success: function (data) {
                let resp = $.parseJSON(data);
                if (resp.status == "success") {
                    $("#errorshow1").html(resp.message).show();
                    setTimeout(' window.location.href = "./app/account"; ', 3000);
                }else{
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
    });
</script>