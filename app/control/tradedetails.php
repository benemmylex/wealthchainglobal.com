<?php
include 'header.php';

if (!isset($_GET) && !isset($_GET['tradeid'])) {
    header('Location: ' . $_SERVER['HTTP_REFERER']);
} else {
    $tradeid = $_GET['tradeid'];
    $mem_id = $_GET['mem_id'];
    $getTrades = $db_conn->prepare("SELECT * FROM trades WHERE tradeid = :tradeid AND mem_id = :mem_id");
    $getTrades->bindParam(":tradeid", $tradeid, PDO::PARAM_STR);
    $getTrades->bindParam(":mem_id", $mem_id, PDO::PARAM_STR);
    $getTrades->execute();
    if ($getTrades->rowCount() < 1) {
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    } else {
        $row = $getTrades->fetch(PDO::FETCH_ASSOC);
        
        $getUser = $db_conn->prepare("SELECT * FROM members WHERE mem_id = :mem_id");
        $getUser->bindParam(":mem_id", $mem_id, PDO::PARAM_STR);
        $getUser->execute();
        
        $rowUser = $getUser->fetch(PDO::FETCH_ASSOC);
    }
}
?>

<title>Trade Details - <?= SITE_NAME; ?></title>

<main class="mt-5 py-5" id="content">
    <div class="container">
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
                <div class="">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="w-100">
                            <h6 class="fw-bold">Username: </h6>
                        </div>
                        <div class="w-100">
                            <p class=""><?= $rowUser['username']; ?></p>
                        </div>
                    </div>
                    <div class="border-bottom border-2 mb-4"></div>
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
                            <p class="">$<?= number_format($row['amount'], 2); ?></p>
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
                    <div class="border-bottom border-2 mb-4"></div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="fw-bold w-100">
                            <h6 class="fw-bold">Opened: </h6>
                        </div>
                        <div class="w-100">
                            <p class="fw-bold"><?= $row['tradetime']; ?></p>
                        </div>
                    </div>
                    <div class="border-bottom border-2 mb-4"></div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="fw-bold w-100">
                            <h6 class="fw-bold">Duration: </h6>
                        </div>
                        <div class="w-100">
                            <p class="fw-bold"><?= $row['duration']; ?></p>
                        </div>
                    </div>
                    <div class="border-bottom border-2 mb-4"></div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="fw-bold w-100">
                            <h6 class="fw-bold">Entry Price: </h6>
                        </div>
                        <div class="w-100">
                            <p class="fw-bold">$<?= number_format($row['price'], 2); ?></p>
                        </div>
                    </div>
                    <div class="border-bottom border-2 mb-4"></div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="fw-bold w-100">
                            <h6 class="fw-bold">Close time: </h6>
                        </div>
                        <div class="w-100">
                            <p class="fw-bold"><?= $row['closetime']; ?></p>
                        </div>
                    </div>
                    <div class="border-bottom border-2 mb-4"></div>
                    <?php if ($row['tradestatus'] == 0) { ?>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="fw-bold w-100">
                                <h6 class="fw-bold"><?= $row['outcome'] == "Profit" ? 'Profit' : "Loss" ?>: </h6>
                            </div>
                            <div class="w-100">
                                <p class="fw-bold">$<?= number_format($row['oamount'], 2); ?></p>
                            </div>
                        </div>
                        <div class="border-bottom border-2 mb-4"></div>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="fw-bold w-100">
                                <h6 class="fw-bold">Closing Price: </h6>
                            </div>
                            <div class="w-100">
                                <p class="fw-bold">$<?= number_format($row['finalprice'], 2); ?></p>
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
                    <?php if ($row['tradestatus'] == 1) { ?>
                        <div class="col-md-12 me-auto ms-auto">
                            <h6 class="font-weight-bold">Close Trade</h6>
                            <p class="">Fill all fields to close trade</p>
                            <form class="mt-4" id="closetrade" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-md-12 mb-4 select-wrapper">
                                        <label for="finalprice" class="form-label">Select Outcome</label>
                                        <select class="select" name="outcome" required id="outcome">
                                            <option disabled selected>--Select Outcome--</option>
                                            <option>Profit</option>
                                            <option>Loss</option>
                                        </select>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-outline mb-4">
                                            <input type="text" id="entry" required name="entry" class="form-control">
                                            <label for="entry" class="form-label">Profit/Loss Amount</label>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-outline mb-4">
                                            <input type="text" id="finalprice" required name="finalprice" class="form-control">
                                            <label for="finalprice" class="form-label">Asset Closing Price</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mt-3" align="center">
                                    <p class="alert alert-primary" id="errorshow"></p>
                                </div>
                                <center>
                                    <div class="text-center">
                                        <button type="submit" id="btnEdit" class="btn-primary btn">Close Trade</button>
                                    </div>
                                </center>
                            </form>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</main>
<script type="text/javascript" src="https://s3.tradingview.com/tv.js"></script>
<?php include "footer.php"; ?>
<script>
    var thsst = localStorage.getItem('theme') || 'dark';

    $(document).ready(function() {
        $("#errorshow").fadeOut();
    });

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

    $("form#closetrade").submit(function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        var request = "closetrade";
        formData.append("request", request);
        formData.append("tradeid", "<?= $tradeid; ?>");
        formData.append("account", "<?= $row['account']; ?>");
        formData.append("amnt", "<?= $row['amount']; ?>");
        formData.append("mem_id", "<?= $mem_id; ?>");
        $.ajax({
            url: '../../ops/adminauth',
            type: 'POST',
            data: formData,
            beforeSend: function() {
                $('#errorshow').html("Processing, please wait <span class='fas fa-spinner fa-pulse'></span>").fadeIn();
            },
            success: function(data) {
                let response = $.parseJSON(data);
                if (response.status == "success") {
                    $("#errorshow").html(response.message).fadeIn();
                    setTimeout(function() {
                        location.reload();
                    }, 4000);
                } else {
                    $("#errorshow").html(response.message).fadeIn();
                }
            },
            cache: false,
            error: function(err) {
                $('#errorshow').html(err.statusText).fadeIn();
            },
            contentType: false,
            processData: false
        });
    });
</script>