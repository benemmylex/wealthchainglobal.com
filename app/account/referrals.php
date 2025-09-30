<?php include('header.php'); ?>
<title>Referrals | <?= SITE_NAME; ?></title>
<style>
    /* div [data-index] {
        width: auto !important;
    } */
</style>
<main class="pt-5 mt-5" id="content">
    <div class="container pt-5">
        <div class="card border border-1 border-primary">
            <div class="card-body">
                <div class="p-3 col-md-9 me-auto ms-auto">
                    <h6 class="text-center ">Referral Link</h6>
                    <div class="form-outline d-flex">
                        <input class="form-control" type="text" id="reflink" readonly="" name="reflink" placeholder="https://<?= SITE_URL; ?>/sigup?ref=<?= $_SESSION['username']; ?>" value="https://<?= SITE_URL; ?>/sigup?ref=<?= $_SESSION['username']; ?>">
                        <span class='fas fa-clipboard text-white p-2 bg-primary' style='border-radius: 5px; cursor:pointer;' id='copy'></span>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="my-3 col-md-12 me-auto ms-auto">
                        <h5 class="text-center fw-bold">My referral list</h5>
                        <div class="table-wrapper table-responsive">
                            <table class="table align-middle hoverable table-striped table-hover" id="reftable">
                                <thead class="orange darken-2 white-text">
                                    <tr class="text-nowrap">
                                        <th scope="col">S/N</th>
                                        <th scope="col">Username</th>
                                        <th scope="col">Registered on</th>
                                        <th scope="col">Status</th>
                                    </tr>
                                </thead>
                                <?php
                                $stl = $db_conn->prepare("SELECT * FROM referral WHERE referrer = :mem_id");
                                $stl->bindParam(':mem_id', $mem_id, PDO::PARAM_STR);
                                $stl->execute();
                                $sn = 1;
                                ?>
                                <tbody>
                                    <div class="text-center" align="center"><?php if ($stl->rowCount() < 1) {
                                                                                echo "<td class='text-center' colspan='4'>No data available to show</td>";
                                                                            } else {
                                                                                while ($row = $stl->fetch(PDO::FETCH_ASSOC)):
                                                                                    $user = $row['mem_id'];
                                                                                    $getu = $db_conn->prepare("SELECT username, regdate, account FROM members WHERE mem_id = :user");
                                                                                    $getu->bindParam(":user", $user, PDO::PARAM_STR);
                                                                                    $getu->execute();
                                                                                    $rowss = $getu->fetch(PDO::FETCH_ASSOC);
                                                                            ?></div>
                                    <tr class="text-nowrap font-weight-bold">
                                        <td class="text-start"><?= $sn; ?></td>
                                        <td class="text-start"><?= $rowss['username']; ?></td>
                                        <td class="text-start"><?= $rowss['regdate']; ?></td>
                                        <td class="text-start"><?= $rowss['account'] == 'live' ? "<span class='text-success'>Active</span>" : "<span class='text-success'>Inactive</span>"; ?></td>
                                <?php $sn++;
                                                                                endwhile;
                                                                            } ?>
                                    </tr>
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
    $("#copy").click(function() {
        var text = document.getElementById("reflink");
        text.select();
        document.execCommand('copy');
        toastr.success('Referral Link copied');
    });

    <?php if ($stl->rowCount() > 0) { ?>
        var one = $('#reftable').DataTable({
            "pagingType": 'simple_numbers',
            "lengthChange": true,
            "pageLength": 10,
            dom: 'Bfrtip'
        });
    <?php } ?>
</script>