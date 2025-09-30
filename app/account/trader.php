<?php include "header.php";

if (isset($_GET['trader']) and is_numeric($_GET['trader'])) {
    $trader = $_GET['trader'];
    $checkTrader = $db_conn->prepare("SELECT * FROM traders WHERE trader_id = :trader_id");
    $checkTrader->bindParam(":trader_id", $trader, PDO::PARAM_STR);
    $checkTrader->execute();
    if ($checkTrader->rowCount() < 1) {
        header("Location: ./traders");
    } else {
        $row = $checkTrader->fetch(PDO::FETCH_ASSOC);
    }
} else {
    header("Location: ./traders");
}

?>

<title><?= $row['t_name']; ?> - <?= SITE_NAME; ?></title>
<main class="mt-5 pt-5" id="content">
    <div class="container pt-5">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 col-lg-4">
                        <div align="center">
                            <img class="img-fluid rounded-circle" style="border-radius: 50%; max-width: 200px;" src="../../assets/images/traders/<?= $row['t_photo1']; ?>">
                        </div>
                        <div class="mt-2">
                            <h5 class="text-center"><?= $row['t_name']; ?></h5>
                        </div>
                        <p class="text-center fw-bold small">
                            <?php
                            $k = 0;
                            while ($k < $row['stars']) : ?>
                                <span class="fas fa-star text-warning"></span>
                            <?php $k++;
                            endwhile; ?>
                        </p>
                        <div class="text-center mb-4">
                            <a onclick="copytrader('<?= $trader; ?>')" class="btn btn-primary btn-rounded mt-3">Copy Trader</a>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-8">
                        <div class="d-flex mb-3 justify-content-between align-items-center">
                            <div class="text-start w-100">
                                <p class="fw-bold">Name: </p>
                            </div>
                            <div class="w-100">
                                <p class="fw-normal"><?= $row['t_name'] ?> </p>
                            </div>
                        </div><hr>
                        <div class="d-flex mb-3 justify-content-between align-items-center">
                            <div class="text-start w-100">
                                <p class="fw-bold">Trades: </p>
                            </div>
                            <div class="w-100">
                                <p class="fw-normal"><?= (float) $row['t_total_win'] + (float) $row['t_total_loss']; ?></p>
                            </div>
                        </div><hr>
                        <div class="d-flex mb-3 justify-content-between align-items-center">
                            <div class="text-start w-100">
                                <p class="fw-bold">Followers: </p>
                            </div>
                            <div class="w-100">
                                <p class="fw-normal"><?= $row['t_followers'] ?></p>
                            </div>
                        </div><hr>
                        <div class="d-flex mb-3 justify-content-between align-items-center">
                            <div class="text-start w-100">
                                <p class="fw-bold">Win Rate: </p>
                            </div>
                            <div class="w-100">
                                <p class="fw-normal"><?= $row['t_win_rate'] ?>% </p>
                            </div>
                        </div><hr>
                        <div class="d-flex mb-3 justify-content-between align-items-center">
                            <div class="text-start w-100">
                                <p class="fw-bold">Total wins: </p>
                            </div>
                            <div class="w-100">
                                <p class="fw-normal"><?= $row['t_total_win'] ?></p>
                            </div>
                        </div><hr>
                        <div class="d-flex mb-3 justify-content-between align-items-center">
                            <div class="text-start w-100">
                                <p class="fw-bold">Total losses: </p>
                            </div>
                            <div class="w-100">
                                <p class="fw-normal"><?= $row['t_total_loss'] ?></p>
                            </div>
                        </div><hr>
                        <div class="d-flex mb-3 justify-content-between align-items-center">
                            <div class="text-start w-100">
                                <p class="fw-bold">Profit Share: </p>
                            </div>
                            <div class="w-100">
                                <p class="fw-normal"><?= $row['t_profit_share'] ?>% </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include "footer.php"; ?>
<script src="../../assets/js/toastr.js"></script>
<script>
    function copytrader(traderid) {
        $.ajax({
            url: '../../ops/users',
            type: 'POST',
            data: {
                request: 'copyTrader',
                traderid: traderid
            },
            beforeSend: function() {
                toastr.info("Copying trader, Please wait <span class='fa fa-1x fa-spinner fa-spin'></span>");
                setTimeout(() => {
                    toastr.clear();
                }, 5000);
            },
            success: function(data) {
                if (data == 'success') {
                    toastr.info("Copy request received by trader <br> please wait while trader accepts your request.");
                } else {
                    toastr.info(data);
                }
            },
            error: function(err) {
                toastr.info(err);
            }
        });
    }
</script>