<?php include "./ops/connect.php"; ?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- <?= SITE_NAME; ?>s meta Data -->
    <meta name="application-name"
    content="<?= SITE_NAME; ?> - Best Platfotm for Your Crypto, Forex, Stocks & Day Trading">
    <meta name="author" content="<?= SITE_NAME; ?>">
    <meta name="keywords" content="<?= SITE_NAME; ?>, Crypto, Forex, and Stocks Trading Business, Copy Trading">
    <meta name="description"
    content="Experience the power of copy trading, the ultimate platform designed to transform trading. With its sleek design and advanced features, <?= SITE_NAME; ?> empowers you to showcase your expertise, engage in trades, and dominate the markets. Elevate your online presence and unlock new trading possibilities with <?= SITE_NAME; ?>.">

    <!-- OG meta data -->
    <meta property="og:title"
    content="<?= SITE_NAME; ?> - Best Online Platfotm for Your Crypto, Forex, Stocks & Day Trading">
    <meta property="og:<?= SITE_NAME; ?>_name" content=<?= SITE_NAME; ?>>
    <meta property="og:url" content="index">
    <meta property="og:description"
    content="Welcome to <?= SITE_NAME; ?>, the game-changing platform meticulously crafted to revolutionize trading business. With its sleek and modern design, <?= SITE_NAME; ?> provides a cutting-edge platform to showcase your expertise, attract good profits, and stay ahead in the competitive trading markets.">
    <meta property="og:type" content="web<?= SITE_NAME; ?>">
    <meta property="og:image" content="assets/images/favicon.png">

    <link rel="shortcut icon" href="assets/images/favicon.png" type="image/x-icon">

    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/aos.css">
    <link rel="stylesheet" href="assets/css/toastr.css">
    <link rel="stylesheet" href="assets/css/all.min.css">

    <link rel="stylesheet" href="assets/css/swiper-bundle.min.css">
    <!-- main css for template -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<style>
    .pos{
     z-index: 1;
     position: fixed !important;
     top: 82px;
 }
</style>

<body>
    <div class="preloader">
        <img src="assets/images/logo/preloader.png" alt="preloader icon">
    </div>
    <div class="lightdark-switch">
        <span class="switch-btn" id="btnSwitch">
            <img src="assets/images/icon/moon.svg" alt="light-dark-switchbtn"
            class="swtich-icon">
        </span>
    </div>
    <header class="header-section <?= $currentPage != "index" ? 'bg-color-3': 'header-section--style2'?>">
        <div class="header-bottom">
            <div class="container">
                <div class="header-wrapper">
                    <div class="logo">
                        <a href="./">
                            <img class="dark" width="160" src="assets/images/logo/logo.png" alt="logo">
                        </a>
                    </div>
                    <div class="menu-area">
                        <ul class="menu menu--style1">
                            <li class="">
                                <a href="./">Home </a>
                            </li>
                            <li class="">
                                <a href="./about">About </a>
                            </li>
                            <li>
                                <a href="javascript:void(0)">Services</a>
                                <ul class="submenu">
                                    <li><a href="./buy-crypto">Buy Crypto</a></li>
                                    <li><a href="./copy-trading">Copy Trading</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="javascript:void(0)">Trading Tools</a>
                                <ul class="submenu">
                                    <li><a href="./markets?market=forex">Forex Charts</a></li>
                                    <li><a href="./markets?market=index">Index Charts</a></li>
                                    <li><a href="./markets?market=crypto">Crypto Market</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="./contact">Contact Us</a>
                            </li>
                            <li>
                                <a href="./signin">Sign in</a>
                            </li>
                            <li>
                                <a href="./signup">Sign up</a>
                            </li>
                        </ul>
                    </div>
                    <div class="header-action">
                        <div class="menu-area">
                            <!-- toggle icons -->
                            <div class="header-bar d-lg-none header-bar--style1">
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="pos">
            <div class="cryptohopper-web-widget" data-id="2" data-realtime="on"></div>
        </div>
    </header>
    <!-- ===============>> Header section end here <<================= -->