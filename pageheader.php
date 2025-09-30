  <?php


  if($currentPage !== "widget"){
  	$page = "";
  	switch ($currentPage) {
  		case 'about':
  		$page = "About us";
  		break;
  		case 'contact':
  		$page = "Contact us";
  		break;
  		case 'buy-crypto':
  		$page = "Buy Crypto";
  		break;
  		case 'copy-trading':
  		$page = "Copy Trading";
  		break;
  		case 'c-market':
  		$page = "Crypto Chart";
  		break;
  		case 'f-market':
  		$page = "Forex Chart";
  		break;
  		case 'i-market':
  		$page = "Indices Chart";
  		break;
  		case 'crypto':
  		$page = "Crypto Trading";
  		break;
  		case 'forex-trading':
  		$page = "Forex Trading";
  		break;
  		case 'privacy-policy':
  		$page = "Privacy Policy";
  		break;
  		case 'responsible-trading':
  		$page = "Responsible Trading";
  		break;
  		case 'risk-disclosure':
  		$page = "Risk Disclosure";
  		break;
  		case 'stock-trading':
  		$page = "Stock Trading";
  		break;
  		case 'terms':
  		$page = "Terms and Conditions";
  		break;
  		case 'verify-email':
  		$page = "Email Verification";
  		break;
  		default:
  		// code...
  		break;
  	}
  }

  ?>


  <!-- ================> Page header start here <================== -->
  	<section class="page-header bg--cover" style="background-image:url(assets/images/header/1.png)">
  		<div class="container">
  			<div class="page-header__content pt-3" data-aos="fade-right" data-aos-duration="1000">
  				<h2 class="mt-5"><?= $page; ?></h2>
  				<nav style="--bs-breadcrumb-divider: '/';" aria-label="breadcrumb">
  					<ol class="breadcrumb mb-0">
  						<li class="breadcrumb-item "><a href="./">Home</a></li>
  						<li class="breadcrumb-item active" aria-current="page"><?= $page; ?></li>
  					</ol>
  				</nav>
  			</div>
  			<div class="page-header__shape">
  				<span class="page-header__shape-item page-header__shape-item--1"><img src="assets/images/header/2.png"
  					alt="shape-icon"></span>
  				</div>
  			</div>
  		</section>
  		<!-- ================> Page header end here <================== -->
