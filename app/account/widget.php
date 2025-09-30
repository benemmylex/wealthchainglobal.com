<?php include('header.php');
if (!isset($_GET['tvwidgetsymbol'])) {
    header("Location: ./");
} else {
    $mainPair = explode(":", $_GET['tvwidgetsymbol']);
    $newstr1 = $mainPair[0];
    $newstr2 = $mainPair[1];
    $page = $newstr2;
};
?>
<title><?= $newstr2; ?> - <?= SITE_NAME; ?> </title>
<main class="py-5 mt-5" id="content">
    <div class="container pt-5">
        <h5><?= ucfirst($newstr2); ?> Chart</h5>
        <div class="">
            <div class="card">
                <div class="card-body lh-base">
                <!-- TradingView Widget BEGIN -->
                <div class="tradingview-widget-container">
                    <div class="tradingview-widget-container__widget"></div>
                    <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-symbol-overview.js" async>
                        {
                            "symbols": [
                                [
                                    "<?= $newstr1; ?>:<?= $newstr2 ?>|1M"
                                ]
                            ],
                            "chartOnly": false,
                            "width": "100%",
                            "height": 340,
                            "locale": "en",
                            "colorTheme": "dark",
                            "autosize": false,
                            "showVolume": true,
                            "showMA": true,
                            "hideDateRanges": false,
                            "hideMarketStatus": false,
                            "hideSymbolLogo": false,
                            "scalePosition": "right",
                            "scaleMode": "Normal",
                            "fontFamily": "-apple-system, BlinkMacSystemFont, Trebuchet MS, Roboto, Ubuntu, sans-serif",
                            "fontSize": "10",
                            "noTimeScale": false,
                            "valuesTracking": "1",
                            "changeMode": "price-and-percent",
                            "chartType": "area",
                            "maLineColor": "#2962FF",
                            "maLineWidth": 1,
                            "maLength": 9,
                            "lineWidth": 2,
                            "lineType": 0,
                            "dateRanges": [
                                "1d|1",
                                "1m|30",
                                "3m|60",
                                "12m|1D",
                                "60m|1W",
                                "all|1M"
                            ],
                            "lineColor": "rgba(51, 104, 248, 1)",
                            "timeHoursFormat": "24-hours"
                        }
                    </script>
                </div>
                <!-- TradingView Widget END -->
            </div>
            </div>
            <div class="col-lg-4 col-md-12">
                <div class="card border border-1 border-primary mb-3">
                    <div class="card-body">
                        <h4 class="fw-bold">Invest in <?= ucfirst($newstr2); ?></h4>
                        <form>
                            <div class="form-outline mb-0 mt-3">
                                <input type="text" id="assetName" value="<?= ucfirst($newstr2); ?>" readonly class="form-control" placeholder="Asset" name="assetName">
                                <label class="form-label" for="amount">Asset</label>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <small>Balance <?= $_SESSION['symbol']; ?><span class="fw-bold"><?= number_format($available, 2); ?></span></small>
                            </div>
                            <div class="form-outline my-3">
                                <input type="number" min="10" id="amount" class="form-control" placeholder="Amount ()" name="amount">
                                <label class="form-label" for="amount">Amount</label>
                            </div>
                            <div class="mt-2 p-3">
                                <p class="alert alert-primary" id="error"></p>
                            </div>
                            <div class="mt-1 d-flex justify-content-center align-items-center">
                                <div class="me-2">
                                    <a onclick="investAsset();" class="btn btn-md btn-success">Invest</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="card border border-1 border-primary">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="">
                        <h5 class="fw-bold"><?= ucfirst($newstr2); ?> Earnings</h5>
                    </div>
                </div>
                <div class="table-wrapper table-responsive">
                    <table class="table" id="<?= ucfirst($newstr2); ?>_tab">
                        <thead>
                            <th class="text-nowrap">SN</th>
                            <th class="text-nowrap">Asset</th>
                            <th class="text-nowrap">Duration</th>
                            <th class="text-nowrap">Profit</th>
                            <th class="text-nowrap">Date</th>
                            <th class="text-nowrap">Invested</th>
                            <th class="text-nowrap">Status</th>
                        </thead>
                        <tbody>
                            <?php
                            $mem_id = $_SESSION['mem_id'];
                            $asset = ucfirst($newstr2);
                            $sql2 = $db_conn->prepare("SELECT * FROM comminvest WHERE mem_id = :mem_id AND comm = :asset ORDER BY main_id DESC");
                            $sql2->bindParam(':mem_id', $mem_id, PDO::PARAM_STR);
                            $sql2->bindParam(':asset', $asset, PDO::PARAM_STR);
                            $sql2->execute();
                            if ($sql2->rowCount() < 1) {
                                echo "<tr class='text-center'><td colspan='7'>No history available to show</td></tr>";
                            } else {
                                $n = 1;
                                while ($row2 = $sql2->fetch(PDO::FETCH_ASSOC)) :
                            ?>
                                    <tr class="text-nowrap">
                                        <td><?= $n; ?></td>
                                        <td>
                                            <div class="d-flex justify-content-start align-items-center">
                                                <div>
                                                    <img src="../../assets/images/svgs/<?= strtolower(ucfirst($newstr2)); ?>-image.svg" width="20" height='20'>
                                                </div>
                                                <div class="ps-1">
                                                    <span class="fw-bold small"><?= ucfirst($row2['comm']); ?></span>
                                                </div>
                                            </div>
                                        </td>
                                        <td><?= $row2['duration']; ?></td>
                                        <td><?= $_SESSION['symbol']; ?><?= number_format($row2['profit'], 2); ?></td>
                                        <td><?= $row2['date_added']; ?></td>
                                        <td><?= $_SESSION['symbol']; ?><?= number_format($row2['amount'], 2); ?></td>
                                        <td><?= $row2['status'] == 0 ? '<span class="text-warning fw-bold">Pending</span>' : ($row2['status'] == 1 ? '<span class="text-success fw-bold">Active</span>' : '<span class="text-danger fw-bold">Ended</span>'); ?></td>
                                    </tr>
                            <?php $n++;
                                endwhile;
                            } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>
<?php include('footer.php'); ?>
<script src="../../assets/js/datatables.min.js"></script>
<script>
    $(document).ready(function() {
        $("#error").fadeOut();
    });
    
    <?php if ($sql2->rowCount() > 0) { ?>
        var two = $('#<?= ucfirst($newstr2); ?>_tab').DataTable({
            "pagingType": 'simple_numbers',
            "lengthChange": true,
            "pageLength": 10,
            dom: 'Bfrtip'
        });
    <?php } ?>
    
    function investAsset() {
        let amount = $("#amount").val();
        let asset = "<?= ucfirst($newstr2); ?>";
        let market = 'commodities';
        let balance = <?= $available; ?>;

        if (amount == null || amount == "") {
            $("#error").html("Please enter an amount").fadeIn();
            setTimeout(() => {
                $("#error").fadeOut();
            }, 5000);
        } else if (balance <= 0) {
            $("#error").html("You do not have sufficient balance to trade, click <a href='./deposit'>here</a> to deposit").fadeIn();
        } else if (amount > balance) {
            $("#error").html("The amount entered is greater than available'balance, click <a href='./deposit'>here</a> to deposit").fadeIn();
        } else {
            $.ajax({
                url: '../../ops/users',
                type: 'POST',
                data: {
                    request: 'investAsset',
                    amount,
                    asset,
                    market
                },
                beforeSend: function() {
                    $('#error').html("Processing <span class='fas fa-spinner fa-spin'></span>").fadeIn();
                },
                success: function(data) {
                    let response = $.parseJSON(data);
                    if (response.status == "success") {
                        $("#error").html(response.message).fadeIn();
                        setTimeout(() => {
                            $("#error").fadeOut();
                            location.reload();
                        }, 5000);
                    } else {
                        $("#error").html(response.message).fadeIn();
                        setTimeout(() => {
                            $("#error").fadeOut();
                        }, 5000);
                    }
                },
                cache: false,
                error: function(err) {
                    $('#error').html("An error has occured!!" + err.statusText).fadeIn();
                    setTimeout(() => {
                        $("#error").fadeOut();
                    }, 5000);
                }
            });
        }
    }
</script>