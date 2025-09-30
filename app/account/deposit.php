<?php include "header.php"; ?>
<title>Deposit - <?= SITE_NAME; ?></title>
<main class="py-5 mt-5" id="content">
    <div class="container pt-5">
        <div class="card border border-1 border-primary">
            <div class="card-header py-3">
                <!--<div class="d-flex justify-content-center align-items-center">-->
                    <div class="">
                        <h5 class="fw-bold text-uppercase text-center">Deposit</h5>
                    </div>
                <!--</div>-->
            </div>
            <div class="card-body">
                <form id="depositForm" enctype="multipart/form-data" method="POST">
                    <p class="alert alert-primary" id="errorshow"></p>
                    <div id="amountDiv">
                        <div class="input-group form-outline my-3">
                            <input value="0" type="text" class="form-control" placeholder="Amount" min="10" required id="amount" name="amount" aria-label="Amount" aria-describedby="amount-addon" />
                            <span class="input-group-text" id="amount-addon"><?= $_SESSION['currency']; ?></span>
                            <label class="form-label" for="amount">Amount</label>
                        </div>
                        <div class="form-group my-3">
                            <label class="form-label mb-2" for="aactType">Select option</label>
                            <select class="form-control browser-default" readonly data-mdb-select-initialized="true" required id="aactType" name="aactType">
                                <option disabled selected>Trading Balance Deposit</option>
                            </select>
                        </div>
                        <div class="my-3" align="center">
                            <button type="button" id="amountBtn" class="btn btn-md btn-primary btn-block">Proceed</button>
                        </div>
                    </div>
                    <!-- End amount -->
                    <div id="selectDiv">
                        <p>Funding Trading Balance Deposit</p>
                        <h4><?= $_SESSION['symbol']; ?><span id="amtShow" class="fw-bold"></span></h4>
                        <div class="form-group my-3">
                            <label class="form-label mb-2" for="type">Select Payment method</label>
                            <select class="form-control browser-default" data-mdb-select-initialized="true" required id="type" name="type">
                                <option class="" disabled selected>--Select payment methods--</option>
                                <?php $sql = $db_conn->prepare("SELECT * FROM crypto");
                                $sql->execute();
                                while ($rows = $sql->fetch(PDO::FETCH_ASSOC)) :
                                ?>
                                    <option value="<?php echo $rows['crypto_name']; ?>"><?php echo $rows['crypto_name']; ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="my-3" align="center">
                            <span class="fas fa-spinner fa-spin" id="spinner"></span>
                            <button type="button" id="selectBtn" class="btn btn-md btn-primary btn-block">Proceed</button>
                        </div>
                    </div>
                    <!-- End select Div -->
                    <div id="depositDiv">
                        <p id="sendP" class="text-center"></p>
                        <div class="input-group form-outline mt-4 mb-3">
                            <input type="text" class="form-control" readonly placeholder="Wallet address" id="address" name="address" aria-label="address" />
                            <button class="btn btn-primary" id="copyBtn" type="button" data-mdb-ripple-init aria-expanded="false">
                                Copy
                            </button>
                        </div>
                        <a href="javascript:void(0)" onclick="$('#barcodeModal').modal('show');" class="d-flex mb-2 fw-semibold justify-content-end mb-3">
                            <small>Or tap here to reveal Qr Code</small>
                        </a>
                        <div id="proofDiv">
                            <div>
                                <label class="form-label mb-0" for="proof">Proof</label>
                                <div class="form-outline my-3">
                                    <i class="fas fa-image trailing text-muted"></i>
                                    <input type="file" id="proof" name="proof" class="form-control form-icon-trailing">
                                      
                                </div>
                            </div>
                        </div>
                        <div class="my-3" align="center">
                            <button type="button" id="proofBtn" class="btn btn-md btn-outline-primary btn-block mb-3">Upload Proof</button> 
                            <button type="submit" class="btn btn-md btn-primary btn-block">Submit request</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="card border border-1 border-primary mt-3">
            <div class="card-body p-2">
                <div class="border-bottom border-2 pb-1 mb-3">
                    <h5 class="fw-bold text-center">My Deposits</h5>
                </div>
                <div class="table-wrapper table-responsive">
                    <table class="table align-middle hoverable table-striped table-hover" id="depTable">
                        <thead class="">
                            <tr class="text-nowrap">
                                <th scope="col" class="">ID</th>
                                <th scope="col" class="">Date</th>
                                <th scope="col" class="">Method</th>
                                <th scope="col" class="">Type</th>
                                <th scope="col" class="">Amount</th>
                                <th scope="col" class="">Status</th>
                                <th scope="col" class="">Action</th>
                            </tr>
                        </thead>
                        <?php
                        $sql2 = $db_conn->prepare("SELECT * FROM deptransc WHERE mem_id = :mem_id ORDER BY main_id DESC");
                        $sql2->bindParam(':mem_id', $mem_id, PDO::PARAM_STR);
                        $sql2->execute();
                        $b = 1;
                        ?>
                        <tbody>
                            <?php if ($sql2->rowCount() < 1) { ?>
                                <tr class="text-center">
                                    <td class='text-center' colspan='7'>No transactions available to show</td>
                                </tr>
                                <?php
                            } else {
                                while ($row = $sql2->fetch(PDO::FETCH_ASSOC)) : ?>
                                    <tr class="text-nowrap">
                                        <td class="text-start"><?= $row['transc_id']; ?></td>
                                        <td class="text-start"><?= $row['date_added']; ?></td>
                                        <td class="text-start"><?= $row['crypto_name']; ?></td>
                                        <td class="text-start"><?= "Deposit"; ?></td>
                                        <td class="text-start"><?= $_SESSION['symbol'] . number_format($row['amount'], 2); ?></td>
                                        <td class="text-start">
                                            <?php
                                            if ($row['status'] == 1) {
                                                echo "<span class='text-success'>Success</span>";
                                            } elseif ($row['status'] == 0) {
                                                echo "<span class='text-warning'>Pending</span>";
                                            } elseif ($row['status'] == 2) {
                                                echo "<span class='text-danger'>Failed</span>";
                                            }
                                            ?>
                                        </td>
                                        <td><a href="./details?type=deposit&transcid=<?= $row['transc_id']; ?>" class="btn btn-sm btn-primary"><span class="">View</span></a></td>
                                <?php $b++;
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
<div class="modal fade" id="barcodeModal" tabindex="-1" aria-labelledby="barcodeModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content text-center">
            <div class="modal-header justify-content-center">
                <h3 class="fw-bold"><span class="fas fa-exclamation-circle"></span> Pay with <span id="paywith"></span></h3>
                <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body py-3">
                <div class="input-group form-outline mt-4 mb-3">
                    <input type="text" class="form-control" readonly placeholder="Wallet address" id="address2" name="address2" aria-label="address2" />
                    <button class="btn btn-primary" id="copyBtns" type="button" data-mdb-ripple-init aria-expanded="false">
                        Copy
                    </button>
                    <label class="form-label" for="address">Wallet address</label>
                </div>
                <p class="h6 text-start lh-base">Make your deposit of <?= $_SESSION['symbol']; ?><span id="crypAmount">0</span> worth of <span id="crypto"></span> into the provided address and tap the deposit button. Or scan the QR Code below to complete deposit.</p>
                <div>
                    <img src="" id="barcode" class="img-fluid w-50" loading="lazy" />
                </div>
            </div>
            <div class="modal-footer">
                <span class="badge badge-danger p-3">
                    <a type="button" onclick="$('#barcodeModal').modal('hide');" class="link">Close</a>
                </span>
            </div>
        </div>
    </div>
</div>
<?php include "footer.php"; ?>
<script src="../../assets/js/datatables.min.js"></script>
<script>
    $(document).ready(() => {
        $("#errorshow").fadeOut();
        $("#spinner").hide();
        $("#selectDiv").hide();
        $("#depositDiv").hide();
        $("#proofDiv").hide();
    });
    
    let t_id = '';
    
    <?php if ($sql2->rowCount() > 0) { ?>
        var one = $('#depTable').DataTable({
            "pagingType": 'simple_numbers',
            "lengthChange": true,
            "pageLength": 10,
            dom: 'Bfrtip'
        });
    <?php } ?>
    
    $("#type").change(() => {
        let val = $('#type').val();
        let request = "getcoin";

        $.ajax({
            url: '../../ops/users',
            type: 'POST',
            data: {
                request: request,
                type: val
            },
            success: function(data) {
                var response = $.parseJSON(data);
                $('#address').val(response.wallet);
                $('#address2').val(response.wallet);
                $('#crypAmount').html($('#amount').val());
                $('#crypto').html($('#type').val());
                $('#paywith').html($('#type').val());
                $('#barcode').attr('src', `../../assets/images/wallets/${response.qrcode}`);
            },
            cache: false,
            error: function(err) {
                $('#errorshow').html(err).fadeIn();
                setTimeout(() => {
                    $('#errorshow').fadeOut();
                }, 5000)
            }
        });
    });
    
    $('#amountBtn').click(function(){
        if($('#amount').val() === 0 || $('#amount').val() === null){
           $("#errorshow").html("Please enter a valid amount").fadeIn(); 
        } else if($("#amount").val() != 0 || $("#amount").val() != null) {
            $('#crypAmount').html($('#amount').val());
            $('#amtShow').html($('#amount').val());
            $("#amountDiv").fadeOut();
            $("#selectDiv").fadeIn();
        }
    });
    
    $('#selectBtn').click(function(){
        if($('#type').val() == "" || $('#type').val() == null){
           $("#errorshow").html("select a payment method").fadeIn(); 
        } else{
            $("#selectBtn").fadeOut();
            $("#spinner").fadeIn();
            setTimeout(function(){
                $("#spinner").fadeOut();
                $("#selectDiv").fadeOut();
                $("#depositDiv").fadeIn();
            }, 4000);
            $("#sendP").html(`Send <?= $_SESSION['symbol']; ?>${$("#amount").val()} worth of ${$("#type").val()} <br><br> <span class="text-uppercase">to the wallet address below or scan the QR code with your wallet app</span><br><br> Please send only ${$("#type").val()} to the address, sending any other token may result in permanent loss`)
            
            let request = "deposit";
            let amount = $('#amount').val();
            let type = $('#type').val();

            $.ajax({
                url: '../../ops/users',
                type: 'POST',
                data: {request, amount, type},
                beforeSend: function() {
                    $('#errorshow').html("Please wait <span class='fas fa-spinner fa-spin'></span>").fadeIn();
                },
                success: function(data) {
                    let response = $.parseJSON(data);
                    if (response.status == "success") {
                        setTimeout(() => {
                            $("#errorshow").html(response.message).fadeIn();
                        }, 5000);
                        t_id = response.transc_id
                    } else {
                        $("#errorshow").html(response.message);
                    }
                },
                error: function(err) {
                    $('#errorshow').html("An error has occured! " + err.statusText).fadeIn();
                }
            });
        }
    });
    
    $('#proofBtn').click(function(){
        $('#proofDiv').toggle();
    });
    
    
    $("#copyBtn").click(function() {
        let text = document.getElementById("address");
        text.select();
        document.execCommand('copy');
        toastr.info('Address Copied', 'Info');
    });

    $("#copyBtns").click(function() {
        let text = document.getElementById("address2");
        text.select();
        document.execCommand('copy');
        toastr.info('Address Copied', 'Info');
    });

    $("form#depositForm").submit(function(e) {
        e.preventDefault();
        let formData = new FormData(this);
        let req = "deposits";
        formData.append('request', req);
        formData.append('transc_id', t_id);
        if ($("#type").val() == null) {
            $('#errorshow').html("Select a payment method").fadeIn();
        } else {
            $.ajax({
                url: '../../ops/users',
                type: 'POST',
                data: formData,
                beforeSend: function() {
                    $('#errorshow').html("Please wait <span class='fas fa-spinner fa-spin'></span>").fadeIn();
                },
                success: function(data) {
                    let response = $.parseJSON(data);
                    if (response.status == "success") {
                        $("#errorshow").html(response.message).fadeIn();
                        setTimeout(() => {
                            location.reload();
                        }, 5000);
                    } else {
                        $("#errorshow").html(response.message);
                    }
                },
                cache: false,
                error: function(err) {
                    $('#errorshow').html("An error has occured! " + err.statusText).fadeIn();
                },
                contentType: false,
                processData: false
            });
        }
    });
</script>