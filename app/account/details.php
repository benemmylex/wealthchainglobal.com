<?php include "header.php";

if (isset($_GET['type']) and isset($_GET['transcid'])) {
    $transcid = $_GET['transcid'];
    $type = $_GET['type'];
    $mem_id = $_SESSION['mem_id'];
} else {
    header('Location: ' . $_SERVER['HTTP_REFERER']);
}

?>
<title>Transaction details</title>
<main class="py-5 mt-5" id="content">
    <div class="container pt-5">
        <?php switch ($type) {
            case 'deposit':
                $select = $db_conn->prepare("SELECT * FROM deptransc WHERE transc_id = :transc_id AND mem_id = :mem_id");
                $select->bindParam(':transc_id', $transcid, PDO::PARAM_STR);
                $select->bindParam(':mem_id', $mem_id, PDO::PARAM_STR);
                $select->execute();
                if ($select->rowCount() < 1) {
                    header('Location: ' . $_SERVER['HTTP_REFERER']);
                    exit();
                } else {
                    $row = $select->fetch(PDO::FETCH_ASSOC);
                }
        ?>
                <div class="card border border-1 border-primary">
                    <div class="card-body">
                        <h5 class="text-center mb-4 text-uppercase">Deposit Details</h5>
                        <div class="border-bottom border-4 w-50 mb-4 me-auto ms-auto"></div>
                        <div class="container">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="fw-bold w-100">
                                    <h6 class="fw-bold">Amount: </h6>
                                </div>
                                <div class="w-100">
                                    <p class=""><?= $_SESSION['symbol']; ?><?= number_format($row['amount'], 2); ?></p>
                                </div>
                            </div>
                            <div class="border-bottom border-2 mb-4"></div>
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="fw-bold w-100">
                                    <h6 class="fw-bold">Payment method: </h6>
                                </div>
                                <div class="text-start w-100">
                                    <p class=""><?= $row['crypto_name']; ?></p>
                                </div>
                            </div>
                            <div class="border-bottom border-2 mb-4"></div>
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="fw-bold w-100">
                                    <h6 class="fw-bold">Date: </h6>
                                </div>
                                <div class="w-100">
                                    <p class="fw-bold"><?= $row['date_added']; ?></p>
                                </div>
                            </div>
                            <div class="border-bottom border-2 mb-4"></div>
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="fw-bold w-100">
                                    <h6 class="fw-bold">Status: </h6>
                                </div>
                                <div class="w-100">
                                    <p class="fw-bold"><?= $row['status'] == 0 ? '<span class="text-warning">Processing</span>' : ($row['status'] == 1 ? '<span class="text-success">Completed</span>' : '<span class="text-danger">Failed</span>'); ?></p>
                                </div>
                            </div>
                            <!-- <div class="border-bottom border-2 mb-4"></div>
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="fw-bold w-100">
                                    <h6 class="fw-bold">Payment proof: </h6>
                                </div>
                                <div class="w-100">
                                    <a class="btn btn-sm btn-primary" target="_blank" href="../../assets/images/proof/<?= $row['proof']; ?>">view</a>
                                </div>
                            </div> -->
                        </div>
                    </div>
                </div>
            <?php break;
            case 'withdrawal':
                $select = $db_conn->prepare("SELECT * FROM wittransc WHERE transc_id = :transc_id AND mem_id = :mem_id");
                $select->bindParam(':transc_id', $transcid, PDO::PARAM_STR);
                $select->bindParam(':mem_id', $mem_id, PDO::PARAM_STR);
                $select->execute();
                if ($select->rowCount() < 1) {
                    header('Location: ' . $_SERVER['HTTP_REFERER']);
                    exit();
                } else {
                    $row = $select->fetch(PDO::FETCH_ASSOC);
                }
            ?>
                <div class="card border border-1 border-primary">
                    <div class="card-body">
                        <h5 class="text-center mb-4 text-uppercase">Withdrawal Details</h5>
                        <div class="border-bottom border-4 w-50 mb-4 me-auto ms-auto"></div>
                        <div class="container">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="fw-bold w-100">
                                    <h6 class="fw-bold">Amount: </h6>
                                </div>
                                <div class="w-100">
                                    <p class=""><?= $_SESSION['symbol']; ?><?= number_format($row['amount'], 2); ?></p>
                                </div>
                            </div>
                            <div class="border-bottom border-2 mb-4"></div>
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="fw-bold w-100">
                                    <h6 class="fw-bold">Withdrawal method: </h6>
                                </div>
                                <div class="text-start w-100">
                                    <p class=""><?= $row['method']; ?></p>
                                </div>
                            </div>
                            <div class="border-bottom border-2 mb-4"></div>
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="fw-bold w-100">
                                    <h6 class="fw-bold">Date: </h6>
                                </div>
                                <div class="w-100">
                                    <p class="fw-bold"><?= $row['date_added']; ?></p>
                                </div>
                            </div>
                            <div class="border-bottom border-2 mb-4"></div>
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="fw-bold w-100">
                                    <h6 class="fw-bold">Status: </h6>
                                </div>
                                <div class="w-100">
                                    <p class="fw-bold"><?= $row['status'] == 0 ? '<span class="text-warning">Processing</span>' : ($row['status'] == 1 ? '<span class="text-success">Successful</span>' : '<span class="text-danger">Failed</span>'); ?></p>
                                </div>
                            </div>
                            <div class="border-bottom border-2 mb-4"></div>
                        </div>
                    </div>
                </div>
        <?php break;
        case 'nft':
                $select = $db_conn->prepare("SELECT * FROM nfthistory WHERE transc_id = :transc_id AND mem_id = :mem_id");
                $select->bindParam(':transc_id', $transcid, PDO::PARAM_STR);
                $select->bindParam(':mem_id', $mem_id, PDO::PARAM_STR);
                $select->execute();
                if ($select->rowCount() < 1) {
                    header('Location: ' . $_SERVER['HTTP_REFERER']);
                    exit();
                } else {
                    $row = $select->fetch(PDO::FETCH_ASSOC);
                }
            ?>
            <div class="card border border-1 border-primary">
                    <div class="card-body">
                        <h5 class="text-center mb-4 text-uppercase">Nft Purchase Details</h5>
                        <div class="border-bottom border-4 w-50 mb-4 me-auto ms-auto"></div>
                        <div class="container">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="fw-bold w-100">
                                    <h6 class="fw-bold">Amount: </h6>
                                </div>
                                <div class="w-100">
                                    <p class=""><?= $_SESSION['symbol']; ?><?= number_format($row['amount'], 2); ?></p>
                                </div>
                            </div>
                            <div class="border-bottom border-2 mb-4"></div>
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="fw-bold w-100">
                                    <h6 class="fw-bold">Payment method: </h6>
                                </div>
                                <div class="text-start w-100">
                                    <p class=""><?= $row['method']; ?></p>
                                </div>
                            </div>
                            <div class="border-bottom border-2 mb-4"></div>
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="fw-bold w-100">
                                    <h6 class="fw-bold">Purchase Date: </h6>
                                </div>
                                <div class="w-100">
                                    <p class="fw-bold"><?= $row['addeddate']; ?></p>
                                </div>
                            </div>
                            <div class="border-bottom border-2 mb-4"></div>
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="fw-bold w-100">
                                    <h6 class="fw-bold">View NFT: </h6>
                                </div>
                                <div class="w-100">
                                    <a class="btn btn-sm btn-primary" target="_blank" href="./nft?nftid=<?= $row['nft_id']; ?>"> Open</a>
                                </div>
                            </div>
                            <div class="border-bottom border-2 mb-4"></div>
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="fw-bold w-100">
                                    <h6 class="fw-bold">Payment proof: </h6>
                                </div>
                                <div class="w-100">
                                    <a class="btn btn-sm btn-primary" target="_blank" href="../../assets/images/proof/<?= $row['proof']; ?>"> view</a>
                                </div>
                            </div>
                            <div class="border-bottom border-2 mb-4"></div>
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="fw-bold w-100">
                                    <h6 class="fw-bold">Status: </h6>
                                </div>
                                <div class="w-100">
                                    <p class="fw-bold"><?= $row['status'] == 0 ? '<span class="text-warning">Processing</span>' : ($row['status'] == 1 ? '<span class="text-success">Completed</span>' : '<span class="text-danger">Failed</span>'); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        <?php break;
        } ?>
    </div>
</main>
<?php include "footer.php"; ?>