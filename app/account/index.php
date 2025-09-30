<?php include('header.php');

?>
<title>Dashboard | <?= SITE_NAME; ?></title>
<style>
    /* div [data-index] {
        width: auto !important;
    } */
</style>
<main class="mt-5 pt-5 pb-3" id="content">
    <div class="container pt-5">
        <h4 class="mb-3">Welcome <span class="fw-bold"><?= $_SESSION['username']; ?></span></h4>
        <?php if ($_SESSION['identity'] != 3) { ?>
            <div class="card shadow-4-strong border border-1 border-primary my-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h5 class="mb-2"><span class="small">Complete account verification</span></h5>
                            <a href="./verification" class="btn btn-outline-primary btn-sm mt-2">Proceed</a>
                        </div>
                        <div class="mt-3">
                            <img src="../../assets/images/userverify.png" class="img-fluid" style="max-width: 70px;">
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
        <div class="tiny-two-item">
            <div class="tiny-slide">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="flex-fill">
                                <span class="small text-muted">Trading Balance</span>
                                <h3>
                                    <span id="showBal1"><?= $_SESSION['symbol'] . number_format($available, 2); ?></span>
                                    <span id="showBal11">******</span>
                                </h3>
                            </div>
                            <div>
                                <a class="" href="javascript:void(0)" id="slashOne">
                                    <i class="fas fa-eye-slash" onclick="showBal();"></i>
                                </a>
                                <a class="" href="javascript:void(0)" id="slashOnes">
                                    <i class="fas fa-eye" onclick="hideBal();"></i>
                                </a>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <div><span class="small">Current day loss</span></div>
                            <div>
                                <span class="text-danger small">
                                    <span id="showBal22">-<?= $_SESSION['symbol'] . number_format($currdayloss, 2); ?></span>
                                    <span id="showBal23">*****</span>
                                </span>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <div><span class="small">All day gain</span></div>
                            <div>
                                <span class="text-success small">
                                    <span id="showBal24">+<?= $_SESSION['symbol'] . number_format($alldaygain, 2); ?></span>
                                    <span id="showBal25">*****</span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tiny-slide">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="flex-fill">
                                <span class="small text-muted">Profit</span>
                                <h3>
                                    <span id="showBal12"><?= $_SESSION['symbol'] . number_format($profit, 2); ?></span>
                                    <span id="showBal13">******</span>
                                </h3>
                            </div>
                            <div>
                                <a class="" href="javascript:void(0)" id="slashTwos">
                                    <i class="fas fa-eye" onclick="hideBal();"></i>
                                </a>
                                <a class="" href="javascript:void(0)" id="slashTwo">
                                    <i class="fas fa-eye-slash" onclick="showBal();"></i>
                                </a>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <div><span class="small">Current day profit</span></div>
                            <div>
                                <span class="text-success small">
                                    <span id="showBal2">+<?= $_SESSION['symbol'] . number_format($currdaypro, 2); ?></span>
                                    <span id="showBal21">*****</span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tiny-slide">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="flex-fill">
                                <span class="small text-muted">Bonus</span>
                                <h3>
                                    <span id="showBal121"><?= $_SESSION['symbol'] . number_format($bonus, 2); ?></span>
                                    <span id="showBal131">******</span>
                                </h3>
                            </div>
                            <div>
                                <a class="" href="javascript:void(0)" id="slashTwose">
                                    <i class="fas fa-eye" onclick="hideBal();"></i>
                                </a>
                                <a class="" href="javascript:void(0)" id="slashTwoe">
                                    <i class="fas fa-eye-slash" onclick="showBal();"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="my-3">
            <div class="shadow-4-strong card border border-2 border-primary">
                <div class="card-body px-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="flex-fill text-center">
                            <div class="rounded-circle">
                                <a class="text-center" href="deposit">
                                    <p class="small"><i class="fas text-primary fa-donate"></i><br><span class="" style="font-size: 11px;">Deposit</span></p>
                                </a>
                            </div>
                        </div>
                        <div class="flex-fill text-center">
                            <div class="rounded-circle">
                                <a class="text-center" href="withdrawal">
                                    <p class="small"><i class="fas text-primary fa-wallet"></i><br><span class="" style="font-size: 11px;">Withdraw</span></p>
                                </a>
                            </div>
                        </div>
                        <div class="flex-fill text-center">
                            <div class="rounded-circle">
                                <a class="text-center" href="investment">
                                    <p class="small"><i class="fas text-primary fa-cubes"></i><br><span class="" style="font-size: 11px;">Investment</span></p>
                                </a>
                            </div>
                        </div>
                        <div class="flex-fill text-center">
                            <div class="rounded-circle">
                                <a class="text-center" href="traders">
                                    <p class="small"><i class="fas text-primary fa-chart-line"></i><br><span class="" style="font-size: 11px;">Copy Trader</span></p>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3 border-primary border-bottom border-1">
                        <div class="flex-fill">
                            <div class="rounded-circle">
                                <a class="text-center" href="chart">
                                    <p class="small"><i class="fas text-primary fa-chart-pie"></i><br><span class="" style="font-size: 11px;">Place Trade</span></p>
                                </a>
                            </div>
                        </div>
                        <div class="flex-fill">
                            <div class="rounded-circle">
                                <a class="text-center" href="claimbonus">
                                    <p class="small"><i class="fas text-primary fa-piggy-bank"></i><br><span class="" style="font-size: 11px;">Claim Bonus</span></p>
                                </a>
                            </div>
                        </div>
                        <div class="flex-fill">
                            <div class="rounded-circle">
                                <a class="text-center" href="./market">
                                    <p class="small"><i class="fas text-primary fa-image"></i><br><span class="" style="font-size: 11px;">Market</span></p>
                                </a>
                            </div>
                        </div>
                        <div class="flex-fill">
                            <div class="rounded-circle">
                                <a class="text-center" href="commodities">
                                    <p class="small"><i class="fas text-primary fa-landmark"></i><br><span class="" style="font-size: 11px;">Commodities</span></p>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border border-primary border-1 mb-3">
            <div class="card-header">
                <h4>Top crypto assets</h4>
            </div>
            <div class="card-body">
                <div id="cryptoAssets"></div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-lg-12">
                <div class="card border border-1 border-primary">
                    <div class="card-body">
                        <h5 class="fw-bold mb-3">Recent activity</h5>
                        <div class="table-wrapper table-responsive">
                            <table class="table">
                                <thead>
                                    <th class="text-nowrap">SN</th>
                                    <th class="text-nowrap">Transaction type</th>
                                    <th class="text-nowrap">Date</th>
                                    <th class="text-nowrap">Amount</th>
                                    <th class="text-nowrap">Status</th>
                                    <th class="text-nowrap">Action</th>
                                </thead>
                                <tbody>
                                    <?php
                                    $mem_id = $_SESSION['mem_id'];
                                    $sql1 = $db_conn->prepare("SELECT * FROM transactions WHERE mem_id = :mem_id ORDER BY main_id DESC LIMIT 5");
                                    $sql1->bindParam(':mem_id', $mem_id, PDO::PARAM_STR);
                                    $sql1->execute();
                                    if ($sql1->rowCount() < 1) {
                                        echo "<tr class='text-center'><td colspan='6'>No transations available</td></tr>";
                                    } else {
                                        $n = 1;
                                        while ($row1 = $sql1->fetch(PDO::FETCH_ASSOC)) : ?>
                                            <tr class="text-nowrap">
                                                <td><?= $n; ?> </td>
                                                <td><?= $row1['transc_type']; ?></td>
                                                <td><?= $row1['date_added']; ?></td>
                                                <td><?= $_SESSION['symbol']; ?><?= number_format($row1['amount'], 2); ?></td>
                                                <td><?= $row1['status'] == 0 ? '<span class="text-warning">Processing</span>' : ($row1['status'] == 1 ? '<span class="text-success">Completed</span>' : '<span class="text-danger">Failed</span>'); ?></td>
                                                <?php if (strtok($row1['transc_type'], " ") == 'Trade') { ?>
                                                    <td><a href="./tradedetails?tradeid=<?= $row1['transc_id']; ?>" class="btn btn-sm btn-primary"><span class="">View</span></a></td>
                                                <?php } elseif ($row1['transc_type'] == 'Deposit') { ?>
                                                    <td><a href="./details?type=deposit&transcid=<?= $row1['transc_id']; ?>" class="btn btn-sm btn-primary"><span class="">View</span></a></td>
                                                <?php } elseif ($row1['transc_type'] == 'Withdrawal') { ?>
                                                    <td><a href="./details?type=withdrawal&transcid=<?= $row1['transc_id']; ?>" class="btn btn-sm btn-primary"><span class="">View</span></a></td>
                                                <?php } elseif ($row1['transc_type'] == 'NFT Purchase') { ?>
                                                    <td><a href="./details?type=nft&transcid=<?= $row1['transc_id']; ?>" class="btn btn-sm btn-primary"><span class="">View</span></a></td>
                                                <?php } ?>
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
        </div>

        <div class="row">
            <div class="col-lg-6 col-md- mb-3">
                <div class="card border border-1 border-primary">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div class="">
                                <h5 class="fw-bold">Recent trades</h5>
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
                                                            <img src="../../assets/images/svgs/<?= strtolower($row2['asset']); ?>-image.svg" width="30" height='30'>
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
            <div class="col-lg-6 col-md-6">
                <div class="card border border-1 border-primary">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div class="">
                                <h5 class="fw-bold mb-3">Recent withdrawals</h5>
                            </div>
                            <div class="">
                                <a class="link" href="./withdrawal">View all</a>
                            </div>
                        </div>
                        <div class="table-wrapper table-responsive">
                            <table class="table">
                                <thead>
                                    <th class="text-nowrap">SN</th>
                                    <th class="text-nowrap">Date</th>
                                    <th class="text-nowrap">Amount</th>
                                    <th class="text-nowrap">Status</th>
                                    <th class="text-nowrap">Action</th>
                                </thead>
                                <tbody>
                                    <?php
                                    $mem_id = $_SESSION['mem_id'];
                                    $sql3 = $db_conn->prepare("SELECT * FROM wittransc WHERE mem_id = :mem_id ORDER BY main_id DESC LIMIT 5");
                                    $sql3->bindParam(':mem_id', $mem_id, PDO::PARAM_STR);
                                    $sql3->execute();
                                    if ($sql3->rowCount() < 1) {
                                        echo "<tr class='text-center'><td colspan='5'>No withrawals available to show</td></tr>";
                                    } else {
                                        $n = 1;
                                        while ($row3 = $sql3->fetch(PDO::FETCH_ASSOC)) :
                                    ?>
                                            <tr class="text-nowrap">
                                                <td><?= $n; ?> </td>
                                                <td><?= $row3['date_added']; ?></td>
                                                <td><?= $_SESSION['symbol']; ?><?= number_format($row3['amount'], 2); ?></td>
                                                <td><?= $row3['status'] == 1 ? '<span class="text-success fw-bold">Success</span>' : ($row3['status'] == 0 ? '<span class="text-warning fw-bold">Pending</span>' : '<span class="text-danger fw-bold">Failed</span>'); ?></td>
                                                <td><a href="./details?type=withdrawal&transcid=<?= $row3['transc_id']; ?>" class="btn btn-sm btn-primary"><span class="">View</span></a></td>
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
        </div>
    </div>
</main>

<?php include('footer.php'); ?>

<script>
    // let hiden = 

    $(document).ready(function() {
        getAssets();
    });


    if (document.getElementsByClassName('tiny-two-item').length > 0) {
        var slider = tns({
            container: '.tiny-two-item',
            controls: false,
            mouseDrag: true,
            loop: true,
            rewind: true,
            autoplay: true,
            autoplayButtonOutput: false,
            autoplayTimeout: 3000,
            navPosition: "bottom",
            speed: 400,
            gutter: 12,
            responsive: {
                992: {
                    items: 1
                },
                767: {
                    items: 1
                },
                320: {
                    items: 1
                },
            },
        });
    };

    function getAssets() {
        let divData = [];
        $.ajax({
            url: 'https://api.coincap.io/v2/assets?ids=<?= implode(",", $pairs); ?>',
            method: 'GET',
            async: true,
            success: function(json) {
                if (json.data.length > 0) {
                    let index;
                    for (var i = 0; i < json.data.length; i++) {
                        if (json.data[i].changePercent24Hr > 0) {
                            badge = "bg-success";
                        } else if (json.data[i].changePercent24Hr < 0) {
                            badge = "bg-danger";
                        } else {
                            badge = "bg-primary";
                        }
                        let div = `<div class="row pt-3 border-bottom border-1" style="cursor: pointer" onclick="$.redirect('chart', {market: 'crypto', symbol: '${json.data[i].symbol}USD'})">
    
                          <div class="col-md-2" dataIndex="${i}" style="width: 15.66667% !important;">
                          <img class="img-fluid" width="40" loading="lazy" height="40" src="https://assets.coincap.io/assets/icons/${json.data[i].symbol.toLowerCase()}@2x.png" src="${json.data[i].symbol}" />
                          </div>
                    
                          <div class="col-md-4" dataIndex="${i}" style="width: 32.33333% !important;">
                          <p class="text-start small mb-0" style="font-size: 0.695em;">${json.data[i].symbol}</p>
                          <p class="text-start small" style="font-size: 0.695em;">${json.data[i].name}</p>
                          </div>
                          
                          <div class="col-md-3" dataIndex="${i}" style="width: 30% !important;">
                          <p class="text-start small" style="font-size: 0.695em;">$${parseFloat(json.data[i].priceUsd).toFixed(2)}</p>
                          </div>
                    
                          <div class="col-md-3" dataIndex="${i}" style="width: 22% !important;">
                          <p class="text-start badge ${badge} small" style="font-size: 0.695em;">${parseFloat(
                            json.data[i].changePercent24Hr
                          ).toFixed(2)}%</p>
                          </div>`;
                        divData.push(div);
                    }
                    $("#cryptoAssets").append(divData);
                }
            },
            error: function(error) {
                console.log(error)
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
                var response = $.parseJSON(data);
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
</script>