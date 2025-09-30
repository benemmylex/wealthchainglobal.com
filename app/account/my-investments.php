<?php include('header.php'); ?>
<title>My Investment | <?= SITE_NAME; ?></title>
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

