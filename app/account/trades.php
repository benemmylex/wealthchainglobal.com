<?php include 'header.php';
?>

<title>My Trades - <?= SITE_NAME; ?></title>

<main class="mt-5 pt-5" id="content">
    <div class="container pt-5">
        <div class="row mb-3">
            <div class="col-md-12">
                <div class="">
                    <!-- Tabs navs -->
                    <ul class="nav nav-tabs nav-fill mb-3" id="ex1" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" id="ex2-tab-1" data-mdb-toggle="tab" href="#ex2-tabs-1" role="tab" aria-controls="ex2-tabs-1" aria-selected="true">Open</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="ex2-tab-2" data-mdb-toggle="tab" href="#ex2-tabs-2" role="tab" aria-controls="ex2-tabs-2" aria-selected="false">Closed</a>
                        </li>
                    </ul>
                    <!-- Tabs navs -->

                    <!-- Tabs content -->
                    <div class="tab-content" id="ex2-content">
                        <div class="tab-pane fade show active" id="ex2-tabs-1" role="tabpanel" aria-labelledby="ex2-tab-1">
                            <div class="card border border-1 border-primary">
                                <div class="card-body" id="open">
                                    <?php
                                    $stat = 1;
                                    $getOpen = $db_conn->prepare("SELECT * FROM trades WHERE tradestatus = :stat AND mem_id = :mem_id");
                                    $getOpen->bindParam(":stat", $stat, PDO::PARAM_STR);
                                    $getOpen->bindParam(":mem_id", $mem_id, PDO::PARAM_STR);
                                    $getOpen->execute();
                                    if ($getOpen->rowCount() < 1) {
                                        echo "<p class='text-center h6'>No Open trades</p>";
                                    } else {
                                        while ($row = $getOpen->fetch(PDO::FETCH_ASSOC)) {
                                    ?>

                                            <div class="card border border-primary border-1 mb-2">
                                                <div class="card-body" style="cursor: pointer;" onclick="redir('tradedetails', {tradeid: '<?= $row['tradeid'] ?>'})">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div class="">
                                                            <div class="d-flex justify-content-start align-items-center">
                                                                <div>
                                                                    <img src="../../assets/images/svgs/<?= strtolower($row['asset']); ?>-image.svg" width="30" height="30">
                                                                </div>
                                                                <div class="ms-3">
                                                                    <h6 class="fw-bold"><?= ucfirst($row['small_name']); ?></h6>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="">
                                                            <h4 class="badge <?= $row['tradetype'] == "Buy" ? "badge-success" : "badge-danger" ?> "><?= $row['tradetype']; ?></h4>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                    <?php
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="ex2-tabs-2" role="tabpanel" aria-labelledby="ex2-tab-2">
                            <div class="card border border-1 border-primary">
                                <div class="card-body" id="open">
                                    <?php
                                    $stat = 0;
                                    $getOpen = $db_conn->prepare("SELECT * FROM trades WHERE tradestatus = :stat AND mem_id = :mem_id");
                                    $getOpen->bindParam(":stat", $stat, PDO::PARAM_STR);
                                    $getOpen->bindParam(":mem_id", $mem_id, PDO::PARAM_STR);
                                    $getOpen->execute();
                                    if ($getOpen->rowCount() < 1) {
                                        echo "<p class='text-center h6'>No Open trades</p>";
                                    } else {
                                        while ($row = $getOpen->fetch(PDO::FETCH_ASSOC)) {
                                    ?>

                                            <div class="card border border-primary border-1 mb-2">
                                                <div class="card-body" style="cursor: pointer;" onclick="redir('tradedetails', {tradeid: '<?= $row['tradeid'] ?>'})">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div class="">
                                                            <div class="d-flex justify-content-start align-items-center">
                                                                <div>
                                                                    <img src="../../assets/images/svgs/<?= strtolower($row['asset']); ?>-image.svg" width="30" height="30">
                                                                </div>
                                                                <div class="ms-3">
                                                                    <span class="fw-bold"><?= ucfirst($row['small_name']); ?></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="">
                                                            <h4 class="badge <?= $row['tradetype'] == "Buy" ? "badge-success" : "badge-danger" ?> "><?= $row['tradetype']; ?></h4>
                                                        </div>
                                                        <div class="">
                                                            <p class="small fw-bold"><?= $row['outcome'] == "Profit" ? "<span class='text-success'>+".$_SESSION['symbol']. number_format($row['oamount'], 2) . "</span>" : "<span class='text-danger'>-" .$_SESSION['symbol']. number_format($row['oamount'], 2) . "</span>"; ?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                    <?php
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Tabs content -->
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card border border-1 border-primary">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div class="">
                                <h5 class="fw-bold">Earning history</h5>
                            </div>
                        </div>
                        <div class="table-wrapper table-responsive">
                            <table class="table">
                                <thead>
                                    <th class="text-nowrap">SN</th>
                                    <th class="text-nowrap">Date</th>
                                    <th class="text-nowrap">Outcome</th>
                                    <th class="text-nowrap">Amount</th>
                                    <th class="text-nowrap">Action</th>
                                </thead>
                                <tbody>
                                    <?php
                                    $mem_id = $_SESSION['mem_id'];
                                    $sql2 = $db_conn->prepare("SELECT * FROM earninghistory WHERE mem_id = :mem_id ORDER BY main_id DESC");
                                    $sql2->bindParam(':mem_id', $mem_id, PDO::PARAM_STR);
                                    $sql2->execute();
                                    if ($sql2->rowCount() < 1) {
                                        echo "<tr class='text-center'><td colspan='5'>No earning history available to show</td></tr>";
                                    } else {
                                        $n = 1;
                                        while ($row2 = $sql2->fetch(PDO::FETCH_ASSOC)) :
                                    ?>
                                            <tr class="text-nowrap">
                                                <td><?= $n; ?></td>
                                                <td><?= $row2['earndate']; ?></td>
                                                <td><?= $row2['outcome'] == 'Profit' ? '<span class="text-success fw-bold">Profit</span>' : '<span class="text-danger fw-bold">Loss</span>'; ?></td>
                                                <td><?= $_SESSION['symbol']; ?><?= number_format($row2['amount'], 2); ?></td>
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
        </div>
    </div>
</main>
<?php
include 'footer.php';
?>