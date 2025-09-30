<?php
require('../../ops/connect.php');

$checkusers = $db_conn->prepare("SELECT * FROM members");
$checkusers->execute();
$totalusers = $checkusers->rowCount();

$stat = 0;
$checkdeps = $db_conn->prepare("SELECT * FROM deptransc WHERE status = :status");
$checkdeps->bindParam(":status", $stat, PDO::PARAM_STR);
$checkdeps->execute();
$allDep = $checkdeps->rowCount();


$checkwit = $db_conn->prepare("SELECT * FROM wittransc WHERE status = :status");
$checkwit->bindParam(":status", $stat, PDO::PARAM_STR);
$checkwit->execute();
$allWit = $checkwit->rowCount();

if (!isset($_SESSION['admusername']) and !isset($_SESSION['admin_id'])) {
  header("Location: ../../backoffice");
  exit();
} else {
  $admin_id = $_SESSION['admin_id'];
  $admusername = $_SESSION['admusername'];
  $chekuser = $db_conn->prepare("SELECT * FROM admin WHERE username = :username AND admin_id = :admin_id");
  $chekuser->bindParam(':username', $admusername, PDO::PARAM_STR);
  $chekuser->bindParam(':admin_id', $admin_id, PDO::PARAM_STR);
  $chekuser->execute();
  if ($chekuser->rowCount() < 1) {
    header("Location: ../../backoffice");
    exit();
  }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <!-- Style CSS -->
  <link rel="icon" href="../../assets/images/favicon.png" type="image/x-icon">
  <link rel="stylesheet" href="../../assets/css/font-awesome.min.css">
  <link rel="stylesheet" href="../../assets/css/style.min.css">
  <link href='https://fonts.googleapis.com/css?family=Inter:100,300,400,700,900' rel='stylesheet'>
  <link rel="stylesheet" href="../../assets/css/datatables.min.css">
  <link rel="stylesheet" href="../../assets/css/toastr.css">
  <script src="../../assets/js/jquery-3.6.0.min.js"></script>
  <style>
    body {
      font-family: 'Inter' !important;
      /* font-size: 13.8px; */
    }

    .pos {
      z-index: 100;
      position: fixed !important;
      top: 48px;
    }

    .circ {
      height: 7.5rem;
      width: 7.5rem;
      background: rgb(59, 155, 196);
      overflow: hidden;
      border-radius: 50%;
    }

    .img-sc {
      display: block;
      width: 100%;
      height: 100%;
    }
  </style>
</head>

<body class="" data-mdb-theme="light">
  <header>
    <div id="sidenav-1" class="sidenav" role="navigation" data-mdb-close-on-esc="true" data-mdb-position="fixed" data-mdb-hidden="true" data-mdb-mode="over" style="overflow-y: auto;" data-mdb-slim="false" data-mdb-slim-collapsed="true" data-mdb-content="#content" data-mdb-focus-trap="true">
      <ul class="sidenav-menu mt-5">
        <li class="sidenav-item mb-1">
          <a class="sidenav-link" href="./">
            <i class="fas fa-home me-4"></i><span> Dashboard</span>
          </a>
        </li>
        <li class="sidenav-item mb-1">
          <a class="sidenav-link collapsed" data-mdb-target="#users" data-mdb-toggle="collapse">
            <i class="fas fa-user me-4"></i><span> Users <span class="ps-2 accordion pt-1 fas fa-angle-down rotate-down"></span></span>
          </a>
          <div class="collapse py-1" id="users">
            <a class="sidenav-link submenu" href="./users">
              <i class="fas fa-users me-4 pe-2 submenu"></i><span> All Users</span>
            </a>
            <a class="sidenav-link submenu" href="./testimonials">
              <i class="fas fa-users me-4 pe-2 submenu"></i><span> Testimonials</span>
            </a>
            <a class="sidenav-link submenu" href="./sendmessage">
              <i class="fas fa-envelope me-4 pe-2 submenu"></i><span> Send Mail</span>
            </a>
          </div>
        </li>
        <li class="sidenav-item mb-1">
          <a class="sidenav-link collapsed" data-mdb-target="#tradLink" data-mdb-toggle="collapse">
            <i class="fas fa-users me-3 pe-1"></i><span> Traders <span class="ps-2 accordion pt-1 fas fa-angle-down rotate-down"></span></span>
          </a>
          <div class="collapse py-1" id="tradLink">
            <a class="sidenav-link submenu" href="./addtrader">
              <i class="fas fa-user-plus me-4 pe-2 submenu"></i><span> Add Traders</span>
            </a>
            <a class="sidenav-link submenu" href="./traders">
              <i class="fas fa-user-tie me-4 pe-2 submenu"></i><span> All Traders</span>
            </a>
          </div>
        </li>
        <li class="sidenav-item mb-1">
          <a class="sidenav-link collapsed" data-mdb-target="#nfts" data-mdb-toggle="collapse">
            <i class="fas fa-image me-3 pe-1"></i><span> NFTs <span class="ps-2 accordion pt-1 fas fa-angle-down rotate-down"></span></span>
          </a>
          <div class="collapse py-1" id="nfts">
            <a class="sidenav-link submenu" href="./addnft">
              <i class="fas fa-camera-retro me-4 pe-2 submenu"></i><span> Add Nft</span>
            </a>
            <a class="sidenav-link submenu" href="./allnft">
              <i class="fas fa-photo-video me-4 pe-2 submenu"></i><span> All Nfts</span>
            </a>
          </div>
        </li>
        <li class="sidenav-item mb-1">
          <a class="sidenav-link collapsed" data-mdb-target="#finance" data-mdb-toggle="collapse">
            <i class="fas fa-landmark me-4"></i><span> Finance <span class="ps-2 accordion pt-1 fas fa-angle-down rotate-down"></span></span>
          </a>
          <div class="collapse py-1" id="finance">
            <a class="sidenav-link submenu" href="./crypto">
              <i class="fas fa-chart-line me-4 pe-2 submenu"></i><span> Add Wallets</span>
            </a>
            <a class="sidenav-link submenu" href="./sendmoney">
              <i class="fas fa-wallet me-4 pe-2 submenu"></i><span> Send Funds</span>
            </a>
            <a class="sidenav-link submenu" href="./withdraw">
              <i class="fas fa-credit-card me-4 pe-2 submenu"></i><span> Withdraw Funds</span>
            </a>
            <a class="sidenav-link submenu" href="./deposit">
              <i class="fas fa-wallet me-4 pe-2 submenu"></i><span> Deposit</span>
            </a>
            <a class="sidenav-link submenu" href="./approvewit">
              <i class="fas fa-wallet me-4 pe-2 submenu"></i><span> User Withdrawal</span>
            </a>
            <a class="sidenav-link submenu" href="./trades">
              <i class="fas fa-piggy-bank me-4 pe-2 submenu"></i><span> Trades</span>
            </a>
          </div>
        </li>
        <li class="sidenav-item mb-1">
          <a class="sidenav-link" href="./logout">
            <i class="fas fa-sign-out-alt me-4"></i><span> Logout</span>
          </a>
        </li>
        <li class="sidenav-item justify-content-center align-items-center d-flex">
          <i class="fas fa-sun"></i>
          <!-- Default switch -->
          <div class="ms-2 form-check form-switch">
            <input class="form-check-input" type="checkbox" role="switch" id="themingSwitcher" />
          </div>
          <i class="fas fa-moon"></i>
        </li>
      </ul>
      <div class="sidenav-footer mt-5">
        <p class="text-info text-center">&copy; <?php echo date("Y"); ?> <?= SITE; ?></p>
      </div>
    </div>
    <!-- Sidenav -->
    <!-- Navbar -->
    <nav id="main-navbar" class="navbar bg-body-tertiary navbar-expand-lg fixed-top">
      <div class="container-fluid">
        <a href="./" class="navbar-brand"><?= SITE_NAME; ?></a>
        <ul class="navbar-nav ml-auto d-flex flex-row">
          <li class="nav-item dropstart me-3">
            <a class="nav-link dropdown-toggle hidden-arrow" href="#" id="navProfile" role="button" data-mdb-toggle="dropdown" aria-expanded="false"> <span class="fas fa-user-circle"></span> </a>
            <ul class="dropdown-menu" aria-labelledby="navProfile">
              <li><a class="dropdown-item" href="../../">Home page</a></li>
              <li><a class="dropdown-item" href="./settings">Settings</a></li>
              <li><a class="dropdown-item" href="./logout">Logout</a></li>
            </ul>
          </li>
          <li class="nav-item me-3">
            <a href="javascript:history.back();" class="nav-link"><span class="fas fa-angle-double-left"></span></a>
          </li>
          <li class="nav-item me-3">
            <a onclick="slimInstance.show()" class="nav-link" data-mdb-content="#slim-content" aria-haspopup="true">
              <i class="fas fa-bars fa-lg" style="cursor: pointer;"></i></a>
          </li>
        </ul>
      </div>
    </nav>
  </header>
  <!--Main layout-->