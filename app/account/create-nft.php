<?php include "header.php"; ?>
<title>Create NFT - <?= SITE_NAME; ?></title>
<main class="py-5 mt-5" id="content">
    <div class="container pt-5">
        <div class="card border border-1 border-primary">
            <div class="card-header py-3">
                <h5 class="fw-bold text-uppercase text-center">Create NFT</h5>
            </div>
            <div class="card-body">
                <form id="nft-form" enctype="multipart/form-data" method="POST">
                    <p>To upload an NFT fill the form below.</p>
                    <div class="form-outline mt-4 mb-3">
                        <i class=" fas fa-folder trailing"></i>
                        <input type="text" class="form-control form-icon-trailing" placeholder="NFT name" id="nftname" name="nftname" aria-label="nftname" />
                        <label for="nftname" class="form-label">NFT name</label>
                    </div>
                    <div class="form-outline mt-4 mb-3">
                        <i class=" fas fa-dollar-sign trailing"></i>
                        <input type="text" class="form-control form-icon-trailing" placeholder="NFT price" id="amount" name="amount" aria-label="amount" />
                        <label for="amount" class="form-label">NFT price (ETH)</label>
                    </div>
                    <div class="form-group my-3">
                        <label class="form-label mb-2" for="type">Select NFT Network</label>
                        <select class="select" required id="nftnetwork" name="nftnetwork">
                            <option class="" disabled selected>--Select nft network--</option>
                            <option value="erc-20">ERC-20</option>
                            <option value="trc-20">TRC-20</option>
                            <option value="rpc-20">RPC-20</option>
                        </select>
                    </div>
                    <div>
                        <label class="form-label mb-0" for="nft">Select file</label>
                        <div class="form-outline my-3">
                            <i class="fas fa-image trailing text-muted"></i>
                            <input type="file" id="nft" required name="nft" class="form-control form-icon-trailing">
                        </div>
                    </div>
                    <div class="form-group text-center">
                        <div class="alert alert-primary" id="errorshow"></div>
                    </div>
                    <div class="my-3" align="center">
                        <button type="submit" class="btn btn-md btn-primary">Create</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="card border border-1 border-primary mt-3">
            <div class="card-body p-2">
                <div class="border-bottom border-2 pb-1 mb-3">
                    <h5 class="fw-bold text-center">My Nfts</h5>
                </div>
                <div class="table-wrapper table-responsive">
                    <table class="table align-middle hoverable table-striped table-hover" id="depTable">
                        <thead class="">
                            <tr class="text-nowrap">
                                <th scope="col" class="">ID</th>
                                <th scope="col" class="">Name</th>
                                <th scope="col" class="">Date</th>
                                <th scope="col" class="">Price</th>
                                <th scope="col" class="">Gas Fee</th>
                                <th scope="col" class="">Buyer</th>
                                <th scope="col" class="">Status</th>
                            </tr>
                        </thead>
                        <?php
                        $sql2 = $db_conn->prepare("SELECT * FROM mynft WHERE mem_id = :mem_id ORDER BY main_id DESC");
                        $sql2->bindParam(':mem_id', $mem_id, PDO::PARAM_STR);
                        $sql2->execute();
                        $b = 1;
                        ?>
                        <tbody>
                            <?php if ($sql2->rowCount() < 1) { ?>
                                <tr class="text-center">
                                    <td class='text-center' colspan='7'>No nfts available to show</td>
                                </tr>
                                <?php
                            } else {
                                while ($row = $sql2->fetch(PDO::FETCH_ASSOC)) : ?>
                                    <tr class="text-nowrap">
                                        <td class="text-start"><?= $row['nftid']; ?></td>
                                        <td class="text-start">
                                            <div class="d-flex">
                                                <span>
                                                    <img class="img-fluid" width="25" src="../../assets/nft/images/<?= $row['nftfile']; ?>"
                                                        </span>
                                                    <span>
                                                        <?= $row['nftname']; ?>
                                                    </span>
                                            </div>
                                        </td>
                                        <td class="text-start"><?= $row['dateadded']; ?></td>
                                        <td class="text-start"><?= $row['nftprice']; ?> ETH</td>
                                        <td class="text-start"><?= $row['gasfee'] == 0.00 ? " ETH <span style='cursor:pointer' onclick='location.reload()' class='text-warning small'>refresh</span>" : ($row['gasfee'] != 0.00 && $row['payment'] == 0 ? ' ETH <span style="cursor:pointer;" onclick="showModal(' . $row['main_id'] . ')" class="text-danger small">pay</span>' : " ETH <span class='text-success small'>Paid</span>"); ?> ETH</td>
                                        <td class="text-start"><?= $row['buyer']; ?></td>
                                        <td class="text-start">
                                            <?php
                                            if ($row['status'] == 1) {
                                                echo "<span class='text-success'>Sold</span>";
                                            } elseif ($row['status'] == 0) {
                                                echo "<span class='text-warning'>Pending</span>";
                                            } elseif ($row['status'] == 2) {
                                                echo "<span class='text-warning'>Uploaded</span>";
                                            }
                                            ?>
                                        </td>
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

<?php
$sql2 = $db_conn->prepare("SELECT * FROM mynft WHERE mem_id = :mem_id ORDER BY main_id DESC");
$sql2->bindParam(':mem_id', $mem_id, PDO::PARAM_STR);
$sql2->execute();
while ($row = $sql2->fetch(PDO::FETCH_ASSOC)) :
?>
    <div class="modal fade" id="modalPay<?= $row['main_id']; ?>" tabindex="-1" aria-labelledby="modalPay<?= $row['main_id']; ?>" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
            <div class="modal-content text-center">
                <div class="modal-header justify-content-center">
                    <h3 class="fw-bold"><span class="fas fa-exclamation-circle"></span> Pay NFT Gas Fee</h3>
                    <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-3">
                    <p class="h6 text-start lh-base">Make your deposit of <?= $row['gasfee']; ?> worth of Ethereum into the provided address and tap the complete button. Or scan the QR Code below to complete payment.</p>
                    <div class="input-group form-outline mt-4 mb-3">
                        <?php
                        $cryp = 'ethereum';
                        $getwal = $db_conn->prepare("SELECT * FROM crypto WHERE crypto_name = :cryp");
                        $getwal->bindParam(':cryp', $cryp, PDO::PARAM_STR);
                        $getwal->execute();
                        $wal = $getwal->fetch(PDO::FETCH_ASSOC);
                        ?>
                        <input type="text" class="form-control" value="<?= $wal['wallet_addr']; ?>" readonly placeholder="Wallet address" id="address<?= $row['main_id']; ?>" name="address<?= $row['main_id']; ?>" aria-label="address<?= $row['main_id']; ?>" />
                        <button class="btn btn-primary" onclick="copyVal('address<?= $row['main_id']; ?>')" type="button" data-mdb-ripple-init aria-expanded="false">
                            Copy
                        </button>
                        <label class="form-label" for="address<?= $row['main_id']; ?>">Wallet address</label>
                    </div>
                    <div>
                        <img src="../../assets/images/wallets/<?= $wal['barcode']; ?>" class="img-fluid w-50" loading="lazy" />
                    </div>
                    <form enctype="multipart/form-data" method="POST">
                        <div>
                            <label class="form-label mb-0" for="proof<?= $row['main_id']; ?>">Payment proof</label>
                            <div class="form-outline my-3">
                                <i class="fas fa-image trailing text-muted"></i>
                                <input type="file" id="proof<?= $row['main_id']; ?>" required name="proof<?= $row['main_id']; ?>" class="form-control form-icon-trailing">
                            </div>
                        </div>
                        <div class="form-group text-center">
                            <div class="alert alert-primary" id="errorshows<?= $row['main_id']; ?>"></div>
                        </div>
                        <div class="my-3" align="center">
                            <button type="button" onclick="payNft('proof<?= $row['main_id']; ?>', '<?= $row['nftid']; ?>', '<?= $row['gasfee']; ?>', 'errorshows<?= $row['main_id']; ?>')" class="btn btn-md btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <span class="badge badge-danger p-3">
                        <a type="button" onclick="$('#modalPay<?= $row['main_id']; ?>').modal('hide');" class="link">Close</a>
                    </span>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(() => {
            $("#errorshows<?= $row['main_id']; ?>").fadeOut();
        });
    </script>
<?php endwhile; ?>
<?php include "footer.php"; ?>
<script src="../../assets/js/datatables.min.js"></script>
<script>
    $(document).ready(() => {
        $("#errorshow").fadeOut();
    });
    const showModal = (id) => {
        $("#modalPay" + id).modal("show");
    }

    <?php if ($sql2->rowCount() > 0) { ?>
        var one = $('#depTable').DataTable({
            "pagingType": 'simple_numbers',
            "lengthChange": true,
            "pageLength": 10,
            dom: 'Bfrtip'
        });
    <?php } ?>

    const copyVal = (val) => {
        var text = document.getElementById(val);
        text.select();
        document.execCommand('copy');
        toastr.info('Address Copied', 'Info');
    }

    $("form#nft-form").submit(function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        var request = "create-nft";
        formData.append('request', request);

        $.ajax({
            url: '../../ops/users',
            type: 'POST',
            data: formData,
            beforeSend: function() {
                $('#errorshow').html("Creating, Please wait <span class='fas fa-spinner fa-spin'></span>").fadeIn();
            },
            success: function(data) {
                var response = $.parseJSON(data);
                if (response.status == "success") {
                    $("#errorshow").html(response.message).fadeIn();
                    location.reload();
                } else {
                    $("#errorshow").html(response.message);
                    setTimeout(function() {
                        $("#errorshow").fadeOut();
                    }, 5000);
                }
            },
            cache: false,
            error: function(err) {
                $('#errorshow').html("An error has occured! " + err.statusText).fadeIn();
                setTimeout(function() {
                    $("#errorshow").fadeOut();
                }, 5000);
            },
            contentType: false,
            processData: false
        });
    });

    function payNft(proof, nftid, amount, span) {
        let prof = document.getElementById(proof);
        if (prof.files[0] == null || prof.files[0] == "") {
            $("#" + span).html('select payment proof to upload').fadeIn();
            setTimeout(function() {
                $("#" + span).fadeOut();
            }, 5000);
        } else {
            let formData = new FormData();
            let request = "pay-nft";
            formData.append('amount', amount);
            formData.append('nftid', nftid);
            formData.append('proof', document.getElementById(proof).files[0]);
            formData.append('request', request);

            $.ajax({
                url: '../../ops/users',
                type: 'POST',
                data: formData,
                beforeSend: function() {
                    $('#' + span).html("Submitting proof, Please wait <span class='fas fa-spinner fa-spin'></span>").fadeIn();
                },
                success: function(data) {
                    var response = $.parseJSON(data);
                    if (response.status == "success") {
                        $("#" + span).html(response.message).fadeIn();
                        setTimeout(function() {
                            location.reload();
                        }, 10000);
                    } else {
                        $("#" + span).html(response.message);
                        setTimeout(function() {
                            $("#" + span).fadeOut();
                        }, 5000);
                    }
                },
                cache: false,
                error: function(err) {
                    $('#' + span).html("An error has occured! " + err.statusText).fadeIn();
                    setTimeout(function() {
                        $("#" + span).fadeOut();
                    }, 5000);
                },
                contentType: false,
                processData: false
            });
        }
    };
</script>