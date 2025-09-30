<?php include('header.php'); ?>
<title>Withdrawal | <?= SITE_NAME; ?></title>
<main class="py-5 pt-5 mt-5" id="content">
    <div class="container pt-5">
        <div class="card mb-3">
            <div class="card-header py-3">
                <h5 class="fw-bold text-uppercase text-center">Withdrawal</h5>
            </div>
            <div class="card-body">
                <form id="withdraw" enctype="multipart/form-data" method="POST">
                    <div class="my-4">
                        <select class="select" required id="type" name="type" data-mdb-filter="true">
                            <option class="" disabled selected>--Select method--</option>
                            <?php $sql = $db_conn->prepare("SELECT * FROM crypto");
                            $sql->execute();
                            while ($rows = $sql->fetch(PDO::FETCH_ASSOC)) :
                            ?>
                                <option value="<?php echo $rows['crypto_name']; ?>"><?php echo $rows['crypto_name']; ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="form-outline my-4">
                        <i class="fas fa-dollar-sign trailing text-muted"></i>
                        <input type="text" min="10" required id="amount" name="amount" class="form-control form-icon-trailing">
                        <label class="form-label" for="amount">Amount</label>
                    </div>
                    <div class="my-4">
                        <select class="select" required id="account" name="account">
                            <option class="" disabled selected>--Select account--</option>
                            <option value="available">Available Balance (<?= $_SESSION['symbol'] . number_format($available, 2); ?>)</option>
                            <option value="bonus">Bonus Balance (<?= $_SESSION['symbol'] . number_format($bonus, 2); ?>)</option>
                            <option value="profit">Profit Balance (<?= $_SESSION['symbol'] . number_format($profit, 2); ?>)</option>
                        </select>
                    </div>
                    <div id="wallet" class="my-4">
                        <div class="form-outline my-3">
                            <i class="fas fa-wallet trailing text-muted"></i>
                            <input type="text" id="address" name="address" class="form-control form-icon-trailing">
                            <label class="form-label" for="address"><span id="coinid">Wallet</span> Address</label>
                        </div>
                    </div>
                    <div class="my-3">
                        <p class="alert alert-primary" id="error"></p>
                    </div>
                    <div class="my-3" align="center">
                        <button type="submit" class="btn btn-md btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card border border-1 border-primary">
            <div class="card-header py-3">
                <h5 class="fw-bold text-uppercase text-center">Withdrawal History</h5>
            </div>
            <div class="card-body">
                <div class="table-wrapper table-responsive">
                    <table class="table align-middle hoverable table-striped table-hover" id="cryptoTable">
                        <thead class="">
                            <tr class="text-nowrap">
                                <th scope="col" class="">ID</th>
                                <th scope="col" class="">Date</th>
                                <th scope="col" class="">Method</th>
                                <th scope="col" class="">Address</th>
                                <th scope="col" class="">Amount</th>
                                <th scope="col" class="">Status</th>
                                <th scope="col" class="">Action</th>
                            </tr>
                        </thead>
                        <?php
                        $sql2 = $db_conn->prepare("SELECT * FROM wittransc WHERE mem_id = :mem_id ORDER BY main_id DESC");
                        $sql2->bindParam(':mem_id', $mem_id, PDO::PARAM_STR);
                        $sql2->execute();
                        ?>
                        <tbody>
                            <?php
                            if ($sql2->rowCount() < 1) { ?>
                                <tr>
                                    <td class='text-center' colspan='7'>No transactions available to show</td>
                                </tr>
                                <?php } else {
                                while ($row2 = $sql2->fetch(PDO::FETCH_ASSOC)) :
                                ?>
                                    <tr class="text-nowrap">
                                        <td class="text-start"><?= $row2['transc_id']; ?></td>
                                        <td class="text-start"><?= $row2['date_added']; ?></td>
                                        <td class="text-start"><?= $row2['method']; ?></td>
                                        <td class="text-start"><?= $row2['wallet_addr']; ?></td>
                                        <td class="text-start"><?= $_SESSION['symbol'] . number_format($row2['amount'], 2); ?></td>
                                        <td class="text-start">
                                            <?php if ($row2['status'] == 1) {
                                                echo "<span class='text-success'>Success</span>";
                                            } elseif ($row2['status'] == 0) {
                                                echo "<span class='text-warning'>Pending</span>";
                                            } elseif ($row2['status'] == 2) {
                                                echo "<span class='text-danger'>Failed</span>";
                                            } ?>
                                        </td>
                                        <td><a href="./details?type=withdrawal&transcid=<?= $row2['transc_id']; ?>" class="btn btn-sm btn-primary"><span class="">View</span></a></td>
                                <?php
                                endwhile;
                            } ?>
                                    </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>
</body>
<?php include "footer.php"; ?>
<script src="../../assets/js/datatables.min.js"></script>
<script>
    $(document).ready(() => {
        $("#error").fadeOut();
    });

    <?php if ($sql2->rowCount() > 0) { ?>
        var two = $('#cryptoTable').DataTable({
            "pagingType": 'simple_numbers',
            "lengthChange": true,
            "pageLength": 10,
            dom: 'Bfrtip'
        });
    <?php } ?>

    $("form#withdraw").submit(function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        var request = "withdraw";
        formData.append('request', request);
        if ($("#type").val() == null) {
            $('#error').html("Select an asset to withdraw").fadeIn();
        } else if ($("#account").val() == null) {
            $('#error').html("Select withdrawal account").fadeIn();
        } else {
            $.ajax({
                url: '../../ops/users',
                type: 'POST',
                data: formData,
                beforeSend: function() {
                    $('#error').html("Processing withdrawal, Please wait <span class='fas fa-spinner fa-spin'></span>").fadeIn();
                },
                success: function(data) {
                    var response = $.parseJSON(data);
                    if (response.status == "success") {
                        $("#error").html(response.message).fadeIn();
                        setTimeout(() => {
                            location.reload();
                        }, 7000);
                    } else {
                        $("#error").html(response.message).fadeIn();
                    }
                },
                cache: false,
                error: function() {
                    $('#error').html("An error has occured!").fadeIn();
                },
                contentType: false,
                processData: false
            });
        }
    });
</script>