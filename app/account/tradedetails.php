<?php
include 'header.php';

if (!isset($_GET) && !isset($_GET['tradeid'])) {
    header('Location: ' . $_SERVER['HTTP_REFERER']);
} else {
    $tradeid = $_GET['tradeid'];
    $accts = "live";
    $getTrades = $db_conn->prepare("SELECT * FROM trades WHERE tradeid = :tradeid AND (mem_id = :mem_id AND account = :account)");
    $getTrades->bindParam(":tradeid", $tradeid, PDO::PARAM_STR);
    $getTrades->bindParam(":mem_id", $mem_id, PDO::PARAM_STR);
    $getTrades->bindParam(":account", $accts, PDO::PARAM_STR);
    $getTrades->execute();
    if ($getTrades->rowCount() < 1) {
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    } else {
        $row = $getTrades->fetch(PDO::FETCH_ASSOC);
    }
}
?>

<title>Trade Details - <?= SITE_NAME; ?></title>

<main class="mt-5 py-5" id="content">
    <div class="container pt-5">
        <div class="card border border-1 border-primary mb-3">
            <div class="card-body">
                <div class="d-flex justify-content-start align-items-center mb-3">
                    <div>
                        <img src="../../assets/images/svgs/<?= strtolower($row['asset']); ?>-image.svg" width="30" height='30' class="img-fluid rouded-circle">
                    </div>
                    <div class="ps-1">
                        <span class="fw-bold small"><?= ucfirst($row['small_name']); ?></span>
                    </div>
                </div>
                <div>
                    <!-- TradingView Widget BEGIN -->
                    <div class="tradingview-widget-container">
                        <div id="tradingview_d43f4"></div>
                        <div class="tradingview-widget-copyright"><a href="./" rel="noopener nofollow" target="_blank"><span class="blue-text"></span></a></div>
                    </div>
                    <!-- TradingView Widget END -->
                </div>
            </div>
        </div>
        <div class="card border border-1 border-primary">
            <div class="card-body">
                <h5 class="text-center mb-4 text-uppercase">Details</h5>
                <div class="border-bottom border-4 w-50 mb-4 me-auto ms-auto"></div>
                <div class="container">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="w-100">
                            <h6 class="fw-bold">Asset: </h6>
                        </div>
                        <div class="w-100">
                            <div class="d-flex justify-content-start align-items-center">
                                <div>
                                    <img src="../../assets/images/svgs/<?= strtolower($row['asset']); ?>-image.svg" width="30" height='30' class="img-fluid rouded-circle">
                                </div>
                                <div class="ms-2">
                                    <small class="fw-bold h6"><?= ucfirst($row['small_name']); ?></small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="border-bottom border-2 mb-4"></div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="fw-bold w-100">
                            <h6 class="fw-bold">Amount: </h6>
                        </div>
                        <div class="w-100">
                            <p class=""><?= $_SESSION['symbol']; ?><?= number_format($row['amount'], 2); ?></p>
                        </div>
                    </div>
                    <div class="border-bottom border-2 mb-4"></div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="fw-bold w-100">
                            <h6 class="fw-bold">Trade Type: </h6>
                        </div>
                        <div class="text-start w-100">
                            <p class="badge fs-6 p-2 <?= $row['tradetype'] == "Buy" ? "badge-success" : "badge-danger" ?> "><?= $row['tradetype']; ?></p>
                        </div>
                    </div>
                    <div class="border-bottom border-2 mb-4"></div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="fw-bold w-100">
                            <h6 class="fw-bold">Date: </h6>
                        </div>
                        <div class="w-100">
                            <p class="fw-bold"><?= $row['tradedate']; ?></p>
                        </div>
                    </div>
                    <!--<div class="border-bottom border-2 mb-4"></div>-->
                    <!--<div class="d-flex justify-content-between align-items-center mb-3">-->
                    <!--    <div class="fw-bold w-100">-->
                    <!--        <h6 class="fw-bold">Opened: </h6>-->
                    <!--    </div>-->
                    <!--    <div class="w-100">-->
                    <!--        <p class="fw-bold"><?= $row['tradetime']; ?></p>-->
                    <!--    </div>-->
                    <!--</div>-->
                    <div class="border-bottom border-2 mb-4"></div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="fw-bold w-100">
                            <h6 class="fw-bold">Duration: </h6>
                        </div>
                        <div class="w-100">
                            <p class="fw-bold"><?= $row['duration']; ?></p>
                        </div>
                    </div>
                    <!--<div class="border-bottom border-2 mb-4"></div>-->
                    <!--<div class="d-flex justify-content-between align-items-center mb-3">-->
                    <!--    <div class="fw-bold w-100">-->
                    <!--        <h6 class="fw-bold">Close time: </h6>-->
                    <!--    </div>-->
                    <!--    <div class="w-100">-->
                    <!--        <p class="fw-bold"><?= $row['closetime']; ?></p>-->
                    <!--    </div>-->
                    <!--</div>-->
                    <div class="border-bottom border-2 mb-4"></div>
                    <?php if ($row['tradestatus'] == 0) { ?>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="fw-bold w-100">
                                <h6 class="fw-bold"><?= $row['outcome'] == "Profit" ? 'Profit' : "Loss" ?>: </h6>
                            </div>
                            <div class="w-100">
                                <p class="fw-bold"><?= $_SESSION['symbol']; ?><?= number_format($row['oamount'], 2); ?></p>
                            </div>
                        </div>
                        <div class="border-bottom border-2 mb-4"></div>
                    <?php } ?>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="fw-bold w-100">
                            <h6 class="fw-bold">Status: </h6>
                        </div>
                        <div class="w-100">
                            <p class="fw-bold"><?= $row['tradestatus'] == 1 ? 'Open' : 'Closed'; ?></p>
                        </div>
                    </div>
                    <div class="border-bottom border-2 mb-4"></div>
                </div>
            </div>
        </div>
    </div>
</main>
<script type="text/javascript" src="https://s3.tradingview.com/tv.js"></script>
<?php include "footer.php"; ?>
<script>
    var thsst = localStorage.getItem('theme') || 'dark';


    new TradingView.widget({
        "width": "100%",
        "height": 460,
        "symbol": "<?= $row['symbol']; ?>",
        "interval": "D",
        "timezone": "Etc/UTC",
        "theme": `${thsst}`,
        "style": "1",
        "locale": "en",
        "toolbar_bg": "#f1f3f6",
        "enable_publishing": false,
        "allow_symbol_change": false,
        "save_image": false,
        "container_id": "tradingview_d43f4"
    });
</script>