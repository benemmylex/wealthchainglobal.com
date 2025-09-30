<?php 
$currentPage = "verify-email";
include "header.php";

if (!isset($_GET["mem_id"]) || !isset($_GET['token'])) {
	header("Location: ./signin");
}else{
	$mem_id = filter_var(htmlentities($_GET['mem_id']),FILTER_UNSAFE_RAW);
	$token = filter_var(htmlentities($_GET['token']),FILTER_UNSAFE_RAW);

	$getuser = $db_conn->prepare("SELECT password_hash FROM members WHERE mem_id = :mem_id AND password_hash = :token");
	$getuser->bindParam(":mem_id", $mem_id, PDO::PARAM_STR);
	$getuser->bindParam(":token", $token, PDO::PARAM_STR);
	$getuser->execute();
	$optionsreset = array(
		SITE_NAME => 32,
	);
	$status = 1;
	$message = "";
	$newhash = password_hash($mem_id, PASSWORD_BCRYPT, $optionsreset);
	if ($getuser->rowCount() < 1) {
		$message = "Email Verification failed!";
	}else{
		$updateHash = $db_conn->prepare("UPDATE members SET password_hash = :newhash, accStatus = :status WHERE mem_id = :mem_id");
		$updateHash->bindParam(":newhash", $newhash, PDO::PARAM_STR);
		$updateHash->bindParam(":status", $status, PDO::PARAM_INT);
		$updateHash->bindParam(":mem_id", $mem_id, PDO::PARAM_INT);
		if($updateHash->execute()){
			session_destroy();
			session_unset();
			$message = "Email address has been verified successfully";
		}else{
			$message = "There was an error verifying your email address";
		}
	}
}

?>
<title>Email Verification - Best Trading Platform </title>
<?php include "pageheader.php"; ?>
<!-- Start About -->
<!-- Start About -->
<section class="section pt-5">
    <div class="container pt-4">
        <h2 class="text-center fw-bolder mb-4">Verify Email Address</h2>
        <p class="alert alert-primary text-center"><?= $message; ?></p>
    </div><!--end container-->
</section><!--end section-->
<!-- End About -->
<?php include "footer.php"; ?>
<script>
	<?php if($message == "Email address has been verified successfully"){ ?>
	setTimeout(' window.location.href = "./signin"; ', 5000);
	<?php } ?>
</script>
