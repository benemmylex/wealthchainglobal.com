<?php include('header.php'); ?>
<title>Dashboard | <?= SITE_NAME; ?></title>
<style>
    /* div [data-index] {
        width: auto !important;
    } */
</style>
<main class="pt-5 mt-5" id="content">
    <div class="container pt-5">
        <div class="row mb-3">
            <div class="col-lg-12">
                <div class="card border border-1 border-primary">
                    <div class="card-body">
                        <h5 class="fw-bold mb-3">All transactions</h5>
                        <div class="table-wrapper table-responsive">
                            <table class="table" id="transctab">
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
                                    $acct1 = 'live';
                                    $sql1 = $db_conn->prepare("SELECT * FROM transactions WHERE mem_id = :mem_id AND account = :account ORDER BY main_id DESC");
                                    $sql1->bindParam(':mem_id', $mem_id, PDO::PARAM_STR);
                                    $sql1->bindParam(':account', $acct1, PDO::PARAM_STR);
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
    </div>
</main>
<?php include "footer.php"; ?>
<script src="../../assets/js/datatables.min.js"></script>
<script>

    <?php if ($sql1->rowCount() > 0) { ?>
        var one = $('#transctab').DataTable({
            "pagingType": 'simple_numbers',
            "lengthChange": true,
            "pageLength": 10,
            dom: 'Bfrtip'
        });
    <?php } ?>
</script>

