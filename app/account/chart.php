<?php
include 'header.php';
$price = 0;
$market = "";
$symbol = "";
if (isset($_GET) && isset($_GET['symbol'])) {
    extract($_GET);
    $price = 0.00;
} else {
    $price = 0;
    $market = "stock";
    $symbol = "AAPL";
}
?>
<title><?= ucfirst($symbol); ?></title>
<main class="mt-5 mb-5 pt-5" id="content">
    <div class="container pt-5">
        <div class="row mb-3">
            <div class="col-lg-8 col-md-12 mb-3">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="me-3 w-100">
                        <select class="select" name="market" id="market">
                            <option value="stock">Stock</option>
                            <option value="crypto">Crypto</option>
                            <option value="forex">Forex</option>
                            <option value="index">Indicies</option>
                        </select>
                    </div>
                    <div class="me-3 w-100">
                        <select class="select" name="items" id="items" data-mdb-filter="true">
                            <option disabled selected>--Click to select--</option>
                        </select>
                    </div>
                </div>
                <div class="d-flex justify-content-start align-items-center mb-3">
                    <div class="me-3">
                        <span class="text-center fw-bold">Price: $<span id="ddPrice"></span></span></span>
                    </div>
                    <div class="ms-1">
                        <?php if (!contains($symbol, $favs)) { ?>
                            <span style="cursor: pointer;" onclick="addfav('<?= $symbol ?>')" class="text-center fw-bold">Add Favorite: <span id="favorite" class="far fa-star"></span></span>
                        <?php } else { ?>
                            <span style="cursor: pointer;" onclick="removefav('<?= $symbol ?>')" class="text-center fw-bold">Remove Favorite: <span id="favorite" class="fas fa-star"></span></span>
                        <?php } ?>
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
            <div class="col-lg-4 col-md-12">
                <div class="card border border-1 border-primary mb-3">
                    <div class="card-body">
                        <h4 class="fw-bold">Place Trade</h4>
                        <form>
                            <div class="form-outline mb-0 mt-3">
                                <input type="text" id="assetName" value="<?= ucfirst($symbol); ?>" readonly class="form-control" placeholder="Asset" name="assetName">
                                <label class="form-label" for="amount">Asset</label>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <small>Price $<span id="dPrice"></span></small>
                                <small>Balance <?= $_SESSION['symbol']; ?><span class="fw-bold"><?= number_format($available, 2); ?></span></small>
                            </div>
                            <div class="form-outline my-3">
                                <input type="number" min="10" id="amount" class="form-control" placeholder="Amount ()" name="amount">
                                <label class="form-label" for="amount">Amount</label>
                            </div>
                            <div class="my-3">
                                <select class="select" id="time" name="time">
                                    <option disabled selected>--select time--</option>
                                    <option value="1 minute">1 minute</option>
                                    <option value="5 minutes">5 minutes</option>
                                    <option value="10 minutes">10 minutes</option>
                                    <option value="30 minutes">30 minutes</option>
                                    <option value="45 minutes">45 minutes</option>
                                    <option value="1 hour">1 hour</option>
                                    <option value="2 hours">2 hours</option>
                                    <option value="5 hours">5 hours</option>
                                    <option value="1 day">1 day</option>
                                    <option value="3 days">3 days</option>
                                    <option value="1 week">1 week</option>
                                    <option value="2 weeks">2 weeks</option>
                                    <option value="1 month">1 month</option>
                                    <option value="3 months">3 months</option>
                                    <option value="6 months">6 months</option>
                                    <option value="1 year">1 year</option>
                                </select>
                            </div>
                            <div>
                                <select class="select" id="leverage" name="leverage">
                                    <option disabled selected>--Leverage--</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <?php for ($i = 1; $i <= 20; $i++) { ?>
                                        <option value="<?= $i * 5; ?>"><?= $i * 5; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="my-4">
                                <select class="select" required id="account" name="account">
                                    <option class="" disabled selected>--Select account--</option>
                                    <option value="available">Available Balance (<?= $_SESSION['symbol'] . number_format($available, 2); ?>)</option>
                                    <option value="profit">Profit Balance (<?= $_SESSION['symbol'] . number_format($profit, 2); ?>)</option>
                                </select>
                            </div>
                            <div class="mt-2 p-3">
                                <p class="alert alert-primary" id="error"></p>
                            </div>
                            <div class="mt-1 d-flex justify-content-center align-items-center">
                                <div class="me-2">
                                    <a onclick="placeBuy();" class="btn btn-md btn-success">Buy</a>
                                </div>
                                <div class="">
                                    <a onclick="placeSell()" class="btn btn-md btn-danger">Sell</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card border border-1 border-primary">
                    <div class="card-body" id="favorites">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h4 class="fw-bold">My Favorites</h4>
                            </div>
                            <div>
                                <a href="./favorites" class="link">view</a>
                            </div>
                        </div>
                        <hr>
                        <?php
                        $favv = $db_conn->prepare("SELECT * FROM favorites WHERE mem_id = :mem_id");
                        $favv->bindParam(":mem_id", $mem_id, PDO::PARAM_STR);
                        $favv->execute();
                        if ($favv->rowCount() < 1) {
                            echo "<p class='text-center'>No Favorites added</p>";
                        } else {
                            while ($rowss = $favv->fetch(PDO::FETCH_ASSOC)) :
                        ?>
                                <div class="card mb-3">
                                    <div class="card-body px-2">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="d-flex justify-content-center align-items-center">
                                                <div>
                                                    <img width="30" height="30" class="img-fluid" src="../../assets/images/svgs/<?= strtolower($rowss['symbol']) ?>-image.svg">
                                                </div>
                                                <div class="ms-2">
                                                    <span class="fw-bold small"><?= str_replace("USD", "", $rowss['symbol']); ?></span>
                                                </div>
                                            </div>
                                            <!--<div class="text-start text-left" style="text-align: left !important;">-->
                                            <!--    <span class="small"><?= $rowss['price'] > 1 ? $_SESSION['symbol'] . "" . $rowss['price'] : $_SESSION['symbol'] . "" . $rowss['price']; ?></span>-->
                                            <!--</div>-->
                                            <div>
                                                <span style="cursor: pointer;" onclick="removefav('<?= $rowss['symbol']; ?>')" class="text-center fw-bold"><span id="favorite" class="fas fa-star"></span></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                        <?php
                            endwhile;
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="card border border-1 border-primary">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="">
                        <h5 class="fw-bold">Last five (5) trades</h5>
                    </div>
                    <div class="">
                        <a class="link" href="./trades">View all</a>
                    </div>
                </div>
                <div class="table-wrapper table-responsive">
                    <table class="table">
                        <thead>
                            <th class="text-nowrap">SN</th>
                            <th class="text-nowrap">Asset</th>
                            <th class="text-nowrap">Trade type</th>
                            <th class="text-nowrap">Date</th>
                            <th class="text-nowrap">Amount</th>
                            <th class="text-nowrap">Status</th>
                            <th class="text-nowrap">Action</th>
                        </thead>
                        <tbody>
                            <?php
                            $mem_id = $_SESSION['mem_id'];
                            $acct2 = 'live';
                            $sql2 = $db_conn->prepare("SELECT * FROM trades WHERE mem_id = :mem_id ORDER BY main_id DESC LIMIT 5");
                            $sql2->bindParam(':mem_id', $mem_id, PDO::PARAM_STR);
                            $sql2->execute();
                            if ($sql2->rowCount() < 1) {
                                echo "<tr class='text-center'><td colspan='7'>No trades available to show</td></tr>";
                            } else {
                                $n = 1;
                                while ($row2 = $sql2->fetch(PDO::FETCH_ASSOC)) :
                            ?>
                                    <tr class="text-nowrap">
                                        <td><?= $n; ?></td>
                                        <td>
                                            <div class="d-flex justify-content-start align-items-center">
                                                <div>
                                                    <img src="../../assets/images/svgs/<?= strtolower($row2['asset']); ?>-image.svg" width="20" height='20'>
                                                </div>
                                                <div class="ps-1">
                                                    <span class="fw-bold small"><?= ucfirst($row2['small_name']); ?></span>
                                                </div>
                                            </div>
                                        </td>
                                        <td><?= $row2['tradetype'] == 'Buy' ? '<span class="text-success">Buy</span>' : '<span class="text-danger">Sell</span>'; ?></td>
                                        <td><?= $row2['tradedate']; ?></td>
                                        <td><?= $_SESSION['symbol']; ?><?= number_format($row2['amount'], 2); ?></td>
                                        <td><?= $row2['tradestatus'] == 0 ? '<span class="text-success fw-bold">Closed</span>' : ($row2['tradestatus'] == 1 ? '<span class="text-warning fw-bold">Open</span>' : '<span class="text-danger fw-bold">Cancelled</span>'); ?></td>
                                        <td><a href="./tradedetails?tradeid=<?= $row2['tradeid']; ?>" class="btn btn-sm btn-primary"><span class="">View</span></a></td>
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

<?php
include 'footer.php';
?>
<script src="../../assets/js/assets.js"></script>
<script type="text/javascript" src="https://s3.tradingview.com/tv.js"></script>
<script>
    $(document).ready(function() {
        separateAssets(asset);
        updateSelect('items');
        $("#error").fadeOut();
    });

    let pps = 0;
    let balance = 0;

    function addfav(symbol) {
        $.ajax({
            url: '../../ops/users',
            method: 'POST',
            data: {
                request: "addfav",
                symbol: symbol,
                price: pps
            },
            success: function(data) {
                let response = $.parseJSON(data);
                if (response.status == 'success') {
                    toastr.info(response.message);
                    setTimeout(function() {
                        location.reload();
                    }, 2000);
                } else {
                    toastr.error(response.message);
                }
            },
            error: function(err) {
                toastr.error(err.statusText);
            }
        });
    }

    function removefav(symbol) {
        $.ajax({
            url: '../../ops/users',
            method: 'POST',
            data: {
                request: "removefav",
                symbol: symbol
            },
            success: function(data) {
                let response = $.parseJSON(data);
                if (response.status == 'success') {
                    toastr.info(response.message);
                    setTimeout(function() {
                        location.reload();
                    }, 2000);
                } else {
                    toastr.error(response.message);
                }
            },
            error: function(err) {
                toastr.error(err.statusText);
            }
        });
    }

    function updateSelect(select) {
        for (let i = 0; i < stocks.length; i++) {
            $("#" + select).append('<option value="' + stocks[i].symbol + '">' + stocks[i].name + '</option>')
        }
        $('#market').change(function() {
            $('#' + select + ' option:not(:first)').remove();
            if ($(this).val() == "crypto") {
                for (let i = 0; i < cryptos.length; i++) {
                    $("#" + select).append('<option value="' + cryptos[i].symbol + '">' + cryptos[i].name + '</option>')
                }
            } else if ($(this).val() == "stock") {
                for (let i = 0; i < stocks.length; i++) {
                    $("#" + select).append('<option value="' + stocks[i].symbol + '">' + stocks[i].name + '</option>')
                }
            } else if ($(this).val() == "forex") {
                for (let i = 0; i < forex.length; i++) {
                    $("#" + select).append('<option value="' + forex[i].symbol + '">' + forex[i].name + '</option>')
                }
            } else if ($(this).val() == "index") {
                for (let i = 0; i < indices.length; i++) {
                    $("#" + select).append('<option value="' + indices[i].symbol + '">' + indices[i].name + '</option>')
                }
            }
        })
    }

    let currAsset = {}

    const setAsset = (arr = [], symbol) => {
        const index = arr.findIndex(object => {
            return object.symbol === symbol;
        });
        currAsset = arr[index];
    };

    setAsset(asset, '<?= $symbol ?>');

    let thsst = localStorage.getItem('theme') || 'dark';

    if (currAsset) {
        new TradingView.widget({
            "width": "100%",
            "height": 460,
            "symbol": currAsset.pairs,
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
    }

    $('#items').change(function() {
        const index = asset.findIndex(object => {
            return object.symbol === $(this).val();
        });
        redir('chart', {
            market: asset[index].market,
            symbol: asset[index].symbol
        })
    });

    <?php if ($market == "crypto") { ?>

        const getMData = () => {
            $.ajax({
                url: 'https://api.coincap.io/v2/assets/' + currAsset.small,
                method: 'GET',
                success: function(json) {
                    let price = "";
                    if (json.data.priceUsd > 1) {
                        price = parseFloat(json.data.priceUsd).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, "$&,");
                    } else {
                        price = parseFloat(json.data.priceUsd).toFixed(6)
                    }
                    $("#currPrice").html(price);
                    pps = price;
                    $("#dPrice").html(price);
                    $("#ddPrice").html(price);
                    setTimeout(function() {
                        getMData();
                    }, 10000);
                },
                error: function() {
                    setTimeout(function() {
                        getMData();
                    }, 10000);
                }
            });
        }

        getMData();

    <?php } else { ?>

        const getMData = () => {
            $.ajax({
                url: 'https://ratesjson.fxcm.com/DataDisplayerMKTs',
                method: 'GET',
                crossDomain: true,
                dataType: 'jsonp',
                success: function(json) {
                    let index;
                    if (json.Rates.length > 0) {
                        index = json.Rates.findIndex(object => {
                            return object.Symbol === currAsset.small;
                        });
                    }
                    let price = "";
                    if (json.Rates[index].Ask > 1) {
                        price = parseFloat(json.Rates[index].Ask).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, "$&,")
                    } else {
                        price = parseFloat(json.Rates[index].Ask).toFixed(6)
                    }
                    $("#currPrice").html(price);
                    pps = price;
                    $("#dPrice").html(price);
                    $("#ddPrice").html(price);
                    setTimeout(function() {
                        getMData();
                    }, 10000);
                },
                error: function() {
                    setTimeout(function() {
                        getMData();
                    }, 10000);
                }
            });
        }

        getMData();

    <?php } ?>

    //Buy Trade Function

    $('#account').change(function() {
        if ($(this).val() == "available") {
            balance = <?= $available; ?>;
        } else if ($(this).val() == "profit") {
            balance = <?= $profit; ?>;
        }
    });

    function placeBuy() {
        let amount = $("#amount").val();
        let time = $("#time").val();
        let leverage = $("#leverage").val();
        let asset = "<?= $symbol ?>";
        let price = parseFloat(pps.replace(/,/g, ''));
        let market = currAsset.market;
        let symb = currAsset.pairs;
        let small = currAsset.name;
        let account = $("#account").val();

        if (amount == null || amount == "") {
            $("#error").html("Please enter an amount").fadeIn();
            setTimeout(() => {
                $("#error").fadeOut();
            }, 5000);
        } else if (time == null || time == "" || time < 10) {
            $("#error").html("The minimun trade time is 10 mins").fadeIn();
            setTimeout(() => {
                $("#error").fadeOut();
            }, 5000);
        } else if (leverage == null || leverage == "") {
            $("#error").html("Plese select a leverage").fadeIn();
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
                    request: 'placeBuy',
                    amount,
                    time,
                    leverage,
                    asset,
                    price,
                    market,
                    'symbol': symb,
                    account,
                    small
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

    //Buy Trade Function

    function placeSell() {
        let amount = $("#amount").val();
        let time = $("#time").val();
        let leverage = $("#leverage").val();
        let asset = "<?= $symbol ?>";
        let price = parseFloat(pps.replace(/,/g, ''));
        let market = currAsset.market;
        let small = currAsset.name;
        let symb = currAsset.pairs;
        let account = $("#account").val();

        if (amount == null || amount == "") {
            $("#error").html("Please enter an amount").fadeIn();
            setTimeout(() => {
                $("#error").fadeOut();
            }, 5000);
        } else if (time == null || time == "" || time < 10) {
            $("#error").html("The minimun trade time is 10 mins").fadeIn();
            setTimeout(() => {
                $("#error").fadeOut();
            }, 5000);
        } else if (leverage == null || leverage == "") {
            $("#error").html("Plese select a leverage").fadeIn();
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
                    request: 'placeSell',
                    amount,
                    time,
                    leverage,
                    asset,
                    price,
                    market,
                    'symbol': symb,
                    account,
                    small
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