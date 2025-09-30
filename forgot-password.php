<?php include "header.php"; ?>
<title>Forgot Password - <?= SITE_NAME; ?></title>

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
								<h2>Reset password</h2>
								<p class="mb-0">Hey there! Forgot your password? No worries! Just click on "Reset password" and follow the steps.</p>
							</div>
							<form method="POST" enctype="multipart/form-data" id="recover" class="account__form needs-validation" novalidate>
								<div class="row g-4">
									<div class="col-12">
										<div>
											<label for="email" class="form-label">Email</label>
											<input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
										</div>
									</div>
								</div>
								<p class="my-3 alert alert-success" id="errorshow1" role="alert"></p>
								<button type="submit" class="trk-btn trk-btn--border trk-btn--primary d-block mt-4">Reset password</button>
							</form>
							<div class="account__switch">
								<p><a href="signin" class="style2"><i class="fa-solid fa-arrow-left-long"></i> Back to <span>Login</span></a></p>
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

    $("form#recover").submit(function(e) {
        e.preventDefault();    
        var formData = new FormData(this);
        formData.append('request', 'forgot-password');
        var email = document.getElementById("email").value;
        $.ajax({
            type:'POST',
            url:'./ops/users',
            data:formData,
            beforeSend:function(){
                $('#errorshow1').html("Sending Mail <span class='fas fa-spinner fa-pulse'></span> ").show();
            },
            success:function(data){
                let resp = $.parseJSON(data);
                if (resp.status == "success") {
                    $("#errorshow1").html(resp.message).show();
                }else{
                    $("#errorshow1").html(resp.message).show();
                    setTimeout(function(){
                        $("#errorshow1").hide();
                    }, 8000);
                }
            },
            error:function(){
                $("#errorshow1").html("<p>There was an error! <br> Please try again!!</p>").show();
                setTimeout(function(){
                    $("#errorshow1").hide();
               	}, 8000);
            },
            contentType: false,
            processData: false
        });
    });
</script> 