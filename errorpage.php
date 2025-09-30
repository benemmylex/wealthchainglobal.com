<?php 
include "header.php";
$error = $_GET['error'];
$title = "";
$subtitle = "";

switch ($error) {
	case '404':
	$title = "Sorry! Page Not Found";
	$subtitle = "Page you are looking for counld not be found";
	break;
	case '403':
	$title = "Error! Access Forbidden";
	$subtitle = "You do not have access to this page.";
	break;
	case '401':
	$title = "Authorization Failed!";
	$subtitle = "Sorry! you do not have authorization to access this page.";
	break;
	case '400':
	$title = "Sorry! Bad Request";
	$subtitle = "The Browser cannot understand your request. Please clear browser cache or reconnect your internet connection and try again.";
	break;
	case '500':
	$title = "Internal Server Error!";
	$subtitle = "Internal server error. It seems the page is down, try refreshing page or clear browser cache.";
	break;
	case '503':
	$title = "Service Unavailable!";
	$subtitle = "The webserver is unable to process your request at the moment. Please try again later.";
	break;

	default:
	$title = "Sorry! Page Not Found";
	$subtitle = "Page you are looking for counld not be found";
	break;
}

?>
<title>Error <?= $error; ?> - Best Trading Platform </title>
<!-- Start About -->
<section class="page-header bg--cover" style="background-image:url(assets/images/header/1.png)">
	<div class="container">
		<div class="page-header__content pt-3" data-aos="fade-right" data-aos-duration="1000">
			<h2 class="mt-5">Error <?= $error; ?></h2>
			<nav style="--bs-breadcrumb-divider: '/';" aria-label="breadcrumb">
				<ol class="breadcrumb mb-0">
					<li class="breadcrumb-item "><a href="./">Home</a></li>
					<li class="breadcrumb-item active" aria-current="page">Error <?= $error; ?></li>
				</ol>
			</nav>
		</div>
		<div class="page-header__shape">
			<span class="page-header__shape-item page-header__shape-item--1"><img src="assets/images/header/2.png"
				alt="shape-icon"></span>
			</div>
		</div>
	</section>
	<!-- Start About -->
	<section class="section pt-5">
		<div class="container pt-4">
			<h2 class="text-center fw-bolder mb-4"><?= $title; ?></h2>
			<p class="mb-4"><?= $subtitle; ?>
			<a href="./contact" class="btn-link"><?= SITE_NAME; ?> Support</a>
		</p>
		<a href="./" class="btn btn-primary btn-md w-100">Go to <?= SITE_ADDRESS; ?> <i class="fal fa-angle-right ml-1"></i></a>
	</div><!--end container-->
</section><!--end section-->
<!-- End About -->
<?php include "footer.php"; ?>
