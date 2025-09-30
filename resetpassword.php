<?php 

include "header.php"; 
$mem_id = $_GET['mem_id'];
if (isset($_GET['mem_id']) AND isset($_GET['token'])) {
	$mem_id = $_GET['mem_id'];
	$hash = $_GET['token'];
	$getuser = $db_conn->prepare("SELECT password FROM members WHERE mem_id = :mem_id AND password_hash = :hash");
	$getuser->bindParam(":mem_id", $mem_id, PDO::PARAM_INT);
	$getuser->bindParam(":hash", $hash, PDO::PARAM_STR);
	$getuser->execute();
	if ($getuser->rowCount() < 1) {
		header("Location: ./signin");
	}
}else{
	header("Location: ./signin");
}

?>
<title>Reset Password - <?= SITE_NAME; ?></title>
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
								<h2>Reset Password</h2>
								<p class="mb-0">Enter your new password below</p>
							</div>
							<form id="recover" method="POST" class="account__form needs-validation" novalidate>
								<div class="row g-4">
									<div class="col-12">
										<div class="form-pass">
											<label for="password" class="form-label">Password</label>
											<input type="password" class="form-control showhide-pass" id="password" name="password" placeholder="Password" required>

											<button onclick="showpass('password', 'eyeIcon')" type="button" id="btnToggle" class="form-pass__toggle"><i id="eyeIcon" class="fa-solid fa-eye"></i></button>
										</div>
									</div>
									<div class="col-12">
										<div class="form-pass">
											<label for="compass" class="form-label">Re-type Password</label>
											<input type="password" class="form-control showhide-pass" id="compass" name="compass" placeholder="Password" required>

											<button onclick="showpass('compass', 'eyeIcon1')" type="button" id="btnToggle" class="form-pass__toggle"><i id="eyeIcon1" class="fa-solid fa-eye"></i></button>
										</div>
									</div>
								</div>
								<div class="account__check">
									<div class="account__check-forgot">
										<a href="./signin">Sign in</a>
									</div>
								</div>
								<p class="my-3 alert alert-success" id="errorshow1" role="alert"></p>
								<button type="submit" class="trk-btn trk-btn--border trk-btn--primary d-block mt-4">Reset Password</button>
							</form>
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
        formData.append('request', 'resetpassword');
        formData.append('mem_id', '<?= $mem_id; ?>');
        $.ajax({
            type:'POST',
            url:'./ops/users',
            data:formData,
            beforeSend:function(){
                $('#errorshow1').html("Please wait <span class='fas fa-spinner fa-pulse'></span> ").show();
            },
            success:function(data){
                let resp = $.parseJSON(data);
                if (resp.status == "success") {
                    $("#errorshow1").html(resp.message).show();
                    setTimeout(() => {
                    	window.href.location('./signin');
                    }, 3000);
                }else{
                    $("#errorshow1").html(resp.message).show();
                    setTimeout(function(){
                        $("#errorshow1").hide();
                    }, 10000);
                }
            },
            error:function(){
                $("#errorshow1").html("<p>There was an error! <br> Please try again!!</p>").show();
                setTimeout(function(){
                    $("#errorshow1").hide();
               	}, 10000);
            },
            contentType: false,
            processData: false
        });
    });
</script>