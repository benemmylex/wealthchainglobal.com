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
                        <h5 class="fw-bold mb-3">My Investments</h5>
                        <div class="table-wrapper table-responsive">
                            <table class="table" id="transctab">
                                <thead>
                                    <th class="text-nowrap">SN</th>
                                    <th class="text-nowrap">Plan</th>
                                    <th class="text-nowrap">Start Date</th>
                                    <th class="text-nowrap">Amount</th>
                                    <th class="text-nowrap">Profit</th>
                                    <th class="text-nowrap">Status</th>
                                    <th class="text-nowrap">Action</th>
                                </thead>
                                <tbody>
                                    <?php
                                    $mem_id = $_SESSION['mem_id'];
                                    $sql1 = $db_conn->prepare("SELECT i.*, p.name as plan_name FROM investment i LEFT JOIN plans p ON i.plan = p.id WHERE i.uid = :mem_id ORDER BY i.id DESC");
                                    $sql1->bindParam(':mem_id', $mem_id, PDO::PARAM_INT);
                                    $sql1->execute();
                                    if ($sql1->rowCount() < 1) {
                                        echo "<tr class='text-center'><td colspan='7'>No investments available</td></tr>";
                                    } else {
                                        $n = 1;
                                        while ($row1 = $sql1->fetch(PDO::FETCH_ASSOC)) : ?>
                                            <tr class="text-nowrap">
                                                <td><?= $n; ?></td>
                                                <td><?= htmlspecialchars($row1['plan_name']); ?> (<?= htmlspecialchars($row1['type']); ?>)</td>
                                                <td><?= date('d M, Y', strtotime($row1['start'])); ?></td>
                                                <td><?= $_SESSION['symbol']; ?><?= number_format($row1['amount'], 2); ?></td>
                                                <td><?= $_SESSION['symbol']; ?><?= number_format($row1['profit'], 2); ?></td>
                                                <td><?= $row1['status'] == 1 ? '<span class="text-success">Active</span>' : ($row1['status'] == 0 ? '<span class="text-warning">Pending</span>' : '<span class="text-danger">Closed</span>'); ?></td>
                                                <td><a href="#" class="btn btn-sm btn-primary disabled"><span>View</span></a></td>
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

