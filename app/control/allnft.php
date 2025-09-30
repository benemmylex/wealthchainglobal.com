<?php include "header.php"; ?>
<title>All NFTs | <?= SITE_NAME; ?></title>
<main class="my-5 pt-5" id="content">
    <div class="container">
        <div class="card">
            <div class="card-body">
                <h4 class="text-center py-3"> All Nfts</h4>
                <div class="col-md-6 me-auto ms-auto" align="center">
                    <p class="alert " id="errorshow"></p>
                </div>
        
                <div class="table-wrapper table-responsive">
                    <table class="table table-striped table-hover" id="allnfts">
                        <thead class="datatable-header">
                            <tr class="text-nowrap">
                                <th scope="col">NFT ID</th>
                                <th scope="col">NFT Name</th>
                                <th scope="col">NFT Price</th>
                                <th scope="col">NFT Image</th>
                                <th scope="col">Edit</th>
                                <th scope="col">Publish/Cancel</th>
                            </tr>
                        </thead>
                        <?php
                        $sql = $db_conn->prepare("SELECT * FROM nfts ORDER BY main_id DESC");
                        $sql->execute();
                        $b = 1;
                        ?>
                        <tbody class="text-nowrap">
                            <?php if ($sql->rowCount() < 1) {
                                echo "<tr><td class='text-center' colspan='6'>No data available</td></td>";
                            } else {
                                while ($row = $sql->fetch(PDO::FETCH_ASSOC)) : ?>
                                    <tr class="text-nowrap">
                                        <td>#<?= $row['nftid']; ?></td>
                                        <td><?= $row['nftname']; ?></td>
                                        <td>$<?= number_format($row['nftprice'], 2); ?></td>
                                        <td><?php if ($row['nfttype'] == "image") { ?>
                                                <a class="btn btn-sm btn-rounded btn-white" target="_blank" href="../assets/nft/images/<?= $row['nftimage']; ?>">View Image</a>
                                            <?php } elseif ($row['nfttype'] == "video") { ?>
                                                <a class="btn btn-sm btn-rounded btn-info" target="_blank" href="../assets/nft/videos/<?= $row['nftfile']; ?>">View Video</a>
                                            <?php } ?>
                                        </td>
                                        <td><?php if ($row['nftstatus'] == 0) { ?><a class="btn btn-sm btn-rounded btn-success" target="_blank" href="editnft?nftid=<?= $row['nftid']; ?>">Edit NFT</a> <?php } ?></td>
                                        <td><?php if ($row['nftstatus'] == 0) { ?><button class="btn btn-primary btn-sm btn-rounded" onclick="publishnft('<?= $row['nftid']; ?>')">Publish</button> <?php } else { ?><button class="btn btn-danger btn-sm btn-rounded" onclick="cancelnft('<?= $row['nftid']; ?>')">Cancel</button><?php } ?></td>
                                <?php endwhile;
                            } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>
<?php include "footer.php"; ?>
<script>
    $(document).ready(function() {
        $("#errorshow").hide();
        
         <?php if ($sql->rowCount() > 0) { ?>
        var one = $('#allnfts').DataTable({
            "pagingType": 'simple_numbers',
            "lengthChange": true,
            "pageLength": 10,
            dom: 'Bfrtip'
        });
    <?php } ?>
    });

    function publishnft(nftid) {
        $.ajax({
            type: 'POST',
            url: '../../ops/adminauth.php',
            data: {
                request: 'approveNft',
                'nftid': nftid
            },
            beforeSend: function() {
                $('#errorshow').html("Publishing <span class='fas fa-spinner fa-pulse'></span>").show();
            },
            success: function(data) {
                if (data == "success") {
                    $("#errorshow").html("<span class='fas fa-check-circle'></span> NFT has been published and will be available for purchase by users").show();
                    setTimeout(function() {
                        location.reload();
                    }, 4000);
                } else {
                    $("#errorshow").html("<span class='fas fa-exclamation-triangle'></span> " + data).show();
                    setTimeout(function() {
                        $("#errorshow").hide();
                    }, 4000);
                }
            },
            error: function(err) {
                $("#errorshow").html("<span class='fas fa-exclamation-triangle'></span> An error occured. <br> Try again. " + err).show();
                setTimeout(function() {
                    $("#errorshow").hide();
                }, 6000);
            }
        });
    }

    function cancelnft(nftid) {
        $.ajax({
            type: 'POST',
            url: '../../ops/adminauth.php',
            data: {
                request: 'cancelNft',
                'nftid': nftid
            },
            beforeSend: function() {
                $('#errorshow').html("Canceling <span class='fas fa-spinner fa-pulse'></span>").show();
            },
            success: function(data) {
                if (data == "success") {
                    $("#errorshow").html("<span class='fas fa-check-circle'></span> NFT has been Cancelled and will not be available for purchase by users").show();
                    setTimeout(function() {
                        location.reload();
                    }, 4000);
                } else {
                    $("#errorshow").html("<span class='fas fa-exclamation-triangle'></span> " + data).show();
                    setTimeout(function() {
                        $("#errorshow").hide();
                    }, 4000);
                }
            },
            error: function(err) {
                $("#errorshow").html("<span class='fas fa-exclamation-triangle'></span> An error occured. <br> Try again. " + err).show();
                setTimeout(function() {
                    $("#errorshow").hide();
                }, 6000);
            }
        });
    }
</script>