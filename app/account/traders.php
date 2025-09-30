<?php include 'header.php'; ?>
<title>Copy Traders | <?= SITE_NAME; ?></title>
<main class="mt-5 pt-5" id="content">
    <div class="container pt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body lh-base">
                        <?php
                        $sql = $db_conn->prepare("SELECT trader, trader_status FROM members WHERE mem_id = :mem_id");
                        $sql->bindParam(":mem_id", $mem_id, PDO::PARAM_STR);
                        $sql->execute();
                        $row = $sql->fetch(PDO::FETCH_ASSOC);
                        ?>
                        <?php if ($row['trader'] == "" or $row['trader'] == NULL and $row['trader_status'] == 0) { ?>
                            <p class="small">You are not currently copying any trader</p>
                        <?php } elseif ($row['trader'] != NULL and $row['trader_status'] == 1) {
                            $trader = filter_var(htmlentities($row['trader']), FILTER_UNSAFE_RAW);
                            $getTraders = $db_conn->prepare("SELECT trader_id, t_name, t_photo1 FROM traders WHERE trader_id = :trader");
                            $getTraders->bindParam(":trader", $trader, PDO::PARAM_STR);
                            $getTraders->execute();
                            $rows = $getTraders->fetch(PDO::FETCH_ASSOC);
                        ?>
                            <p class="p my-3 text-center">
                                You are currently copying trades from <br>
                                <a href="./trader?trader=<?= $rows['trader_id']; ?>">
                                    <span class="fw-bolder h5">
                                        <div class="cent">
                                            <div class="circ">
                                                <img src="../../assets/images/traders/<?= $rows['t_photo1']; ?>" class="img-fluid img-sc me-3" alt="trader avatar" />
                                            </div>
                                        </div>
                                        <?= $rows['t_name']; ?> <span class="fas fa-check-circle text-success"></span>
                                    </span>
                                </a>
                            </p>
                        <?php } else { ?>
                            <p class="mb-3">You are not currently copying any trader</p>
                        <?php } ?>
                        <hr>

                        <h5 class="text-uppercase fw-bold mt-3">Traders</h5>
                        <div class="border-bottom w-25 border-2 mb-4"></div>
                        <div class="col-md-4 ms-auto mb-3">
                            <div class="form-outline">
                                <input type="text" placeholder="Enter name" class="form-control" id="search" name="search">
                                <label class="form-label" for="search">Search trader</label>
                            </div>
                        </div>
                        <div id="default">
                            <?php
                            $stat = 1;

                            $getTraders = $db_conn->prepare("SELECT * FROM traders WHERE t_status = :stat ORDER BY main_id ASC");
                            $getTraders->bindParam(":stat", $stat, PDO::PARAM_STR);
                            $getTraders->execute();

                            while ($rowss = $getTraders->fetch(PDO::FETCH_ASSOC)) :
                                $n = rand(1, 8);
                            ?> <div class="card border mb-3 border-1 border-primary">
                                    <div class="card-body mt-2 p-4">
                                        <div class="row">
                                            <div class="col-md-3 col-6 border-end border-1 pe-3">
                                                <div class="text-center">
                                                    <div class="cent">
                                                        <div class="circ">
                                                            <img src="../../assets/images/traders/<?= $rowss['t_photo1']; ?>" class="img-fluid img-sc" alt="">
                                                        </div>
                                                    </div>
                                                    <h6 style="cursor: pointer;" class="name my-1"><a><?= $rowss['t_name']; ?></a></h6>
                                                    <p class="mt-1"><button onclick="copytrader('<?= $rowss['trader_id'] ?>', 'requestBtn<?= $rowss["trader_id"]; ?>')" id="requestBtn<?= $rowss['trader_id']; ?>" class="btn btn-success btn-sm"><?= $row['trader'] == $rowss['trader_id'] && $row['trader_status'] == 0 ? 'Requested' : ($row['trader'] == $rowss['trader_id'] && $row['trader_status'] == 1 ? 'Accepted' : 'copy'); ?></button></p>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-6 border-end border-1 pe-3" align="center">
                                                <p class="text-center fw-bold small mb-0"><?= $rowss['t_profit_share']; ?>%</p>
                                                <p>Profit Share</p>
                                            </div>
                                            <div class="col-md-3 col-6 border-end border-1 pe-3" align="center">
                                                <p class="text-center fw-bold small mb-0"><?= $rowss['t_followers']; ?></p>
                                                <p>Followers</p>
                                            </div>
                                            <div class="col-md-3 col-6 border-end border-1 pe-3" align="center">
                                                <p class="text-center fw-bold small mb-0"><?= $rowss['t_minimum']; ?></p>
                                                <p>Minimum</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        </div>
                        <div id="searchres"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include "footer.php"; ?>
<script src="../../assets/js/toastr.js"></script>
<script>
    $(document).ready(function() {
        $('#searchres').hide();
        $("#errorshow").hide();
    });

    function copytrader(traderid, btn) {
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
                    toastr.info("Requested.");
                    $("#" + btn).html('Requested');
                    setTimeout(function(){
                        location.reload();
                    }, 1500);
                } else {
                    toastr.info(data);
                }
            },
            error: function(err) {
                toastr.info(err);
            }
        });
    }

    $('#search').on('input', function() {
        if ($("#search").val().length == 0) {
            $('#default').show();
            $('#searchres').hide();
        } else if ($("#search").val().length >= 3) {
            // () => {
            var searchkey = $(this).val();
            $.ajax({
                type: 'POST',
                url: '../../ops/users',
                data: {
                    request: 'searchTrader',
                    searchkey: searchkey
                },
                beforeSend: function() {
                    $('#searchres').html("Please wait ...").show();
                },
                success: function(data) {
                    $('#searchres').html(data).show();
                    $("#default").hide();
                },
                error: function() {
                    $('#searchres').html("<p class='text-center'>An error occured.</p>").show();
                }
            });
            // }

        }
    });
</script>