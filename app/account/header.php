<?php include '../../ops/connect.php';

$pairs = array("bitcoin", "ethereum", "binance-coin", "xrp", "dogecoin", "solana", "stellar", "litecoin");

$smallpairs = array("btc", "eth", "bnb", "xrp", "doge", "sol", "xlm", "ltc");

$cheks = $db_conn->prepare("SELECT actpart FROM admin");
$cheks->execute();
$rCheks = $cheks->fetch(PDO::FETCH_ASSOC);


if ($rCheks['actpart'] == 1) {
    if ($_SESSION['identity'] != 3) {
        header("Location: ./verification");
    }
}


if (!isset($_SESSION['username']) and !isset($_SESSION['mem_id'])) {
    header("Location: ../../signin");
    exit();
} else {
    $mem_id = $_SESSION['mem_id'];
    $username = $_SESSION['username'];
    $chekuser = $db_conn->prepare("SELECT * FROM members WHERE username = :username AND mem_id = :mem_id");
    $chekuser->bindParam(':username', $username, PDO::PARAM_STR);
    $chekuser->bindParam(':mem_id', $mem_id, PDO::PARAM_STR);
    $chekuser->execute();
    if ($chekuser->rowCount() < 1) {
        header("Location: ../../signin");
        exit();
    }
}


$chekearning = $db_conn->prepare("SELECT * FROM balances WHERE mem_id = :mem_id");
$chekearning->bindParam(':mem_id', $mem_id, PDO::PARAM_STR);
$chekearning->execute();


$getEarns = $chekearning->fetch(PDO::FETCH_ASSOC);

$totalbal = $getEarns['balance'];

$bonus = $getEarns['bonus'];

$available = $getEarns['available'];

$pending = $getEarns['pending'];

$profit = $getEarns['profit'];

$currdaypro = $getEarns['currdaypro'];

$currdayloss = $getEarns['currdayloss'];

$alldaygain = $getEarns['alldaygain'];

$balance = $available + $bonus + $profit;

$totalbal = $balance;

$updateBal = $db_conn->prepare("UPDATE balances SET balance = :balance WHERE mem_id = :mem_id");
$updateBal->bindParam(':balance', $balance, PDO::PARAM_STR);
$updateBal->bindParam(':mem_id', $mem_id, PDO::PARAM_STR);
$updateBal->execute();

$favs = array();

$fav = $db_conn->prepare("SELECT * FROM favorites WHERE mem_id = :mem_id");
$fav->bindParam(":mem_id", $mem_id, PDO::PARAM_STR);
$fav->execute();
while ($rows = $fav->fetch(PDO::FETCH_ASSOC)) :
    $favs[] = $rows['symbol'];
endwhile;

$mys = 0;

$getNotif = $db_conn->prepare("SELECT * FROM notifications WHERE status = :status AND mem_id = :mem_id");
$getNotif->bindParam(":status", $mys, PDO::PARAM_STR);
$getNotif->bindParam(":mem_id", $mem_id, PDO::PARAM_STR);
$getNotif->execute();

$notifCount = $getNotif->rowCount();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <link rel="icon" href="../../assets/images/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="../../assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="../../assets/css/style.min.css">
    <link href='https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&amp;family=Public+Sans:wght@500;600;700;800&amp;display=swap' rel='stylesheet'>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/css/datatables.min.css">
    <link rel="stylesheet" href="../../assets/css/tiny-slider.css">
    <link rel="stylesheet" href="../../assets/css/toastr.css" />
    <script src="../../assets/js/jquery-3.6.0.min.js"></script>

</head>
<style>
    body {
        font-family: 'Inter' !important;
        /* font-size: 13.8px; */
    }

    button.btn {
        border-radius: 8px !important;
    }

    .pos {
        z-index: 100;
        position: fixed !important;
        top: 48px;
        width: 100% !important;
    }

    .tns-nav {
        display: none;
    }

    .circ {
        height: 70px;
        width: 70px;
        background: rgb(59, 155, 196);
        overflow: hidden;
        border-radius: 50%;
    }

    .img-sc {
        display: block;
        width: 100%;
        height: 100%;
    }

    .cent {
        display: flex;
        justify-content: center;
        align-items: center;
    }
</style>

<body class="" data-mdb-theme="light">
    <header>
        <div id="sidenav-1" class="sidenav" role="navigation" data-mdb-close-on-esc="true" data-mdb-position="fixed" data-mdb-hidden="true" data-mdb-mode="side" style="overflow-y: auto;" data-mdb-slim="false" data-mdb-slim-collapsed="true" data-mdb-content="#content" data-mdb-focus-trap="true">
            <ul class="sidenav-menu mt-5">
                <li class="sidenav-item text-center border-bottom border-2 my-3">
                    <div class="cent">
                        <div class="circ">
                            <img src="../../assets/images/user/<?= $_SESSION['photo'] == null ? "user.png" : $_SESSION['photo'] ?>" class="img-fluid img-sc">
                        </div>
                    </div>
                    <h6 class="fw-bold mt-3 mb-1"> <?= ucfirst($_SESSION['fullname']); ?></h6>
                    <p class="small mb-0"><?= ucfirst($_SESSION['username']); ?></p>
                    <span class=""><?= ucfirst($_SESSION['userplan']); ?> Account <i class="material-icons" style="font-size: 0.89em;">star</i>
                    </span>
                </li>
                <li class="sidenav-item">
                    <a class="sidenav-link" href="./">
                        <i class="material-icons me-2" style="font-size: 0.99em;">dashboard</i><span> Home</span>
                    </a>
                </li>
                <!--<li class="sidenav-item">
                    <a class="sidenav-link" href="./market">
                        <i class="fas fa-chart-line me-2"></i><span> Markets</span>
                    </a>
                </li>
                <li class="sidenav-item">
                    <a class="sidenav-link" href="./trades">
                        <i class="fas fa-chart-bar me-2"></i><span> My trades</span>
                    </a>
                </li> -->
                <li class="sidenav-item">
                    <a class="sidenav-link" href="./deposit">
                        <i class="fas fa-sign-in-alt me-2"></i><span> Deposit</span>
                    </a>
                </li>
                <!-- <li class="sidenav-item">
                    <a class="sidenav-link" href="./nfts">
                        <i class="fas fa-image me-2"></i><span> Buy NFTs</span>
                    </a>
                </li>
                <li class="sidenav-item">
                    <a class="sidenav-link" href="./create-nft">
                        <i class="fas fa-user me-2"></i><span> Create NFTs</span>
                    </a>
                </li>-->
                <li class="sidenav-item">
                    <a class="sidenav-link" href="./investments">
                        <i class="fas fa-cubes me-2"></i><span> Investment Plans</span>
                    </a>
                </li>
                <li class="sidenav-item">
                    <a class="sidenav-link" href="./my-investments">
                        <i class="fas fa-cubes me-2"></i><span> My Investment Plans</span>
                    </a>
                </li>
                <li class="sidenav-item">
                    <a class="sidenav-link" href="./transactions">
                        <i class="fas fa-calendar-alt me-2"></i><span> All Transactions</span>
                    </a>
                </li>
                <!-- <li class="sidenav-item">
                    <a class="sidenav-link" href="./traders">
                        <i class="fas fa-user-tie me-2"></i><span> Copy Traders</span>
                    </a>
                </li>-->
                <li class="sidenav-item">
                    <a class="sidenav-link" href="./withdrawal">
                        <i class="fas fa-wallet me-2"></i><span> Withdrawal</span>
                    </a>
                </li>
                <li class="sidenav-item mb-1">
                    <a class="sidenav-link" href="./verification">
                        <i class="fas fa-users me-2"></i><span> Verification</span>
                    </a>
                </li>
                <li class="sidenav-item">
                    <a class="sidenav-link" href="./profile">
                        <i class="fas fa-cogs me-2"></i><span> User settings</span>
                    </a>
                </li>
                <li class="sidenav-item mb-1">
                    <a class="sidenav-link" href="./logout">
                        <i class="fas fa-power-off me-2"></i><span> Sign out</span>
                    </a>
                </li>
                <li class="sidenav-item justify-content-center align-items-center d-flex">
                    <i class="fas fa-sun"></i>
                    <div class="ms-2 form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" id="themingSwitcher" />
                    </div>
                    <i class="fas fa-moon"></i>
                </li>
            </ul>
            <div class="sidenav-footer mt-5">
                <p class="text-center">&copy; <?php echo date("Y"); ?> <?= SITE; ?></p>
            </div>
        </div>
        <!-- Sidenav -->
        <!-- Navbar -->
        <nav id="main-navbar" class="navbar bg-body-tertiary navbar-expand-lg fixed-top">
            <div class="container-fluid">
                <a onclick="slimInstance.show()" class="nav-link me-3" data-mdb-content="#slim-content" aria-haspopup="true">
                    <i class="fas fa-bars" style="cursor: pointer;"></i>
                    <a href="./" class="navbar-brand">
                        <img src="../../assets/images/logo/logo.png" id="navbar-brand" class="img-fluid" width="89" />
                    </a>
                </a>
                <ul class="navbar-nav ms-auto d-flex flex-row align-items-center">
                    <li class="nav-item me-3">
                        <?php if (basename($_SERVER['PHP_SELF']) != 'index.php') { ?>
                            <a href="javascript:history.back();" class="nav-link" aria-expanded="false">
                                <small><i class="fas fa-angle-left"></i> Back</small>
                            </a>
                        <?php } ?>
                    </li>
                    <li class="nav-item me-3">
                        <a onclick="$('#langmodal').modal('show');" style="cursor: pointer;" class="nav-link"> <i class="fas fa-language"></i></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./notifications">
                            <i class="fas fa-bell"></i>
                            <span class="position-relative top-10 translate-middle badge rounded-pill badge-primary"><?= $notifCount; ?><span class="visually-hidden">unread messages</span>
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="dropdown-toggle d-flex align-items-center" id="navbarDropdownMenuAvatar" data-mdb-toggle="dropdown" role="button" aria-expanded="false" href="#">
                            <img class="rounded-circle" height="25" src="../../assets/images/user/<?= $_SESSION['photo'] == NULL ? 'user.png' : $_SESSION['photo']; ?>" loading="lazy" />
                        </a>
                        <ul class="dropdown-menu dropdown-menu-right dropdown-menu-end" aria-labelledby="navbarDropdownMenuAvatar">
                            <li>
                                <a class="dropdown-item" href="./profile">My profile</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="./logout">Logout</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <!--Main layout-->
    <div class="pos">
        <div class="tradingview-widget-container">
            <div class="tradingview-widget-container__widget"></div>
            <div class="tradingview-widget-copyright"></div>
            <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-ticker-tape.js" async>
                {
                    "symbols": [{
                            "proName": "FOREXCOM:SPXUSD",
                            "title": "S&P 500"
                        },
                        {
                            "proName": "FOREXCOM:NSXUSD",
                            "title": "US 100"
                        },
                        {
                            "proName": "FX_IDC:EURUSD",
                            "title": "EUR/USD"
                        },
                        {
                            "proName": "BITSTAMP:BTCUSD",
                            "title": "Bitcoin"
                        },
                        {
                            "proName": "BITSTAMP:ETHUSD",
                            "title": "Ethereum"
                        },
                        {
                            "description": "Binance Smart Chain",
                            "proName": "BINANCE:BNBUSDT"
                        },
                        {
                            "description": "Luna",
                            "proName": "BINANCE:LUNAUSDT"
                        },
                        {
                            "description": "Gold",
                            "proName": "CURRENCYCOM:GOLD"
                        },
                        {
                            "description": "Gasoline",
                            "proName": "PEPPERSTONE:GASOLINE"
                        },
                        {
                            "description": "Aptos",
                            "proName": "BINANCE:APTUSDT"
                        },
                        {
                            "description": "Crude oil",
                            "proName": "CURRENCYCOM:OIL_CRUDE"
                        },
                        {
                            "description": "Solana",
                            "proName": "BINANCE:SOLUSDT"
                        },
                        {
                            "description": "Polygon Matic",
                            "proName": "BINANCE:MATICUSDT"
                        },
                        {
                            "description": "Shiba Inu",
                            "proName": "BINANCE:SHIBUSDT"
                        },
                        {
                            "description": "Cardano",
                            "proName": "BINANCE:ADAUSDT"
                        }
                    ],
                    "showSymbolLogo": true,
                    "colorTheme": "dark",
                    "isTransparent": false,
                    "displayMode": "adaptive",
                    "locale": "en"
                }
            </script>
        </div>
    </div>

    