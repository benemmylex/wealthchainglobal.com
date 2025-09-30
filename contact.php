<?php 
$currentPage = "contact";
include "header.php"; 

?>
<title>Contact - Best Trading Platform </title>
<?php include "pageheader.php"; ?>

<div class="contact padding-top padding-bottom">
	<div class="container">
		<div class="contact__wrapper">
			<div class="row g-5">
				<div class="col-md-5">
					<div class="contact__info" data-aos="fade-right" data-aos-duration="1000">
						<div class="contact__social">
							<h3>let’s <span>get in touch</span>
							with us</h3>
						</div>
						<div class="contact__details">
							<div class="contact__item" data-aos="fade-right" data-aos-duration="1000">
								<div class="contact__item-inner">
									<div class="contact__item-thumb">
										<span><img src="assets/images/contact/1.png" alt="contact-icon" class="dark"></span>
									</div>
									<div class="contact__item-content">
										<p>
											Phone
										</p>
										<p>
											<?= SITE_PHONE; ?>
										</p>
									</div>
								</div>
							</div>
							<div class="contact__item" data-aos="fade-right" data-aos-duration="1100">
								<div class="contact__item-inner">
									<div class="contact__item-thumb">
										<span><img src="assets/images/contact/2.png" alt="contact-icon" class="dark"></span>
									</div>
									<div class="contact__item-content">
										<p>
											Email Address
										</p>
										<p>
											<?= SITE_EMAIL; ?>
										</p>
									</div>
								</div>
							</div>
							<div class="contact__item" data-aos="fade-right" data-aos-duration="1200">
								<div class="contact__item-inner">
									<div class="contact__item-thumb">
										<span><img src="assets/images/contact/3.png" alt="contact-icon" class="dark"></span>
									</div>
									<div class="contact__item-content">
										<p>
											Address
										</p>
										<p>
											<?= ADDRESS; ?>
										</p>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-7">
					<div class="contact__form">
						<form id="contact" method="POST" data-aos="fade-left" data-aos-duration="1000">
							<div class="row g-4">
								<div class="col-12">
									<div>
										<label for="fullname" class="form-label">Name</label>
										<input class="form-control" name="fullname" type="text" id="fullname" placeholder="Full Name">
									</div>
								</div>
								<div class="col-12">
									<div>
										<label for="email" class="form-label">Email</label>
										<input class="form-control" type="email" name="email" id="email" placeholder="Email here">
									</div>
								</div>
								<div class="col-12">
									<div>
										<label for="subject" class="form-label">Subject</label>
										<input class="form-control" name="subject" type="text" id="subject" placeholder="Subject here">
									</div>
								</div>
								<div class="col-12">
									<div>
										<label for="textarea" class="form-label">Message</label>
										<textarea cols="30" rows="5" name="message" class="form-control" id="textarea"
										placeholder="Enter Your Message"></textarea>
									</div>
								</div>
							</div>
							<p class="my-3 alert alert-success" id="errorshow1" role="alert"></p>
							<button type="submit" class="trk-btn trk-btn--border trk-btn--primary mt-4 d-block">contact us
							now</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="contact__shape">
		<span class="contact__shape-item contact__shape-item--1"><img src="assets/images/contact/4.png"
			alt="shape-icon">
		</span>
		<span class="contact__shape-item contact__shape-item--2"> <span></span> </span>
	</div>
</div>
<?php include "footer.php"; ?>
<script>
    $(document).ready(function(){
        $("#errorshow1").hide();
    });
            
    $("form#contact").submit(function(e) {
        e.preventDefault();    
        var formData = new FormData(this);
        $.ajax({
            url: 'operation/contact',
            type: 'POST',
            data: formData,
            beforeSend:function(){
                $('#errorshow1').html("Sending Message <span class='fas fa-spinner fa-spin'></span>").show();
            },
            success: function (data) {
                if (data == "success") {
                    $("#errorshow1").html("Message has been sent successfully. <br> We will reply you as soon as possible").show();
                    setTimeout(' window.location.href = "./signin"; ', 3000);
                }else{
                    $("#errorshow1").html(data).show();
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