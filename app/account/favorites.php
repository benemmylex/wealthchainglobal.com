<?php
include 'header.php';
?>
<title>Favorites - <?= SITE_NAME; ?></title>
<main class="py-5 mt-5" id="content">
    <div class="container pt-5">
        <div class="card border border-1 border-primary">
            <div class="card-body" id="favorites">
                <h4 class="fw-bold">My Favorites</h4>
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
                                            <img width="35" height="35" class="img-fluid" src="../../assets/images/svgs/<?= strtolower($rowss['symbol']) ?>-image.svg">
                                        </div>
                                        <div class="ms-3">
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
</main>
<?php include 'footer.php'; ?>
<script src="../../assets/js/assets.js"></script>
<script>
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
                    }, 1000);
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