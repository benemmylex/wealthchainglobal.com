<?php include('header.php');
/* Output all php errors */
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>

<title>Fund Card | <?= SITE_NAME; ?></title>
<main class="mt-5 pt-5 pb-3" id="content">
    <div class="container pt-5">
        <h4 class="mb-3">Fund Card <small class="text-muted">Order and fund your debit/credit card</small></h4>

        <div class="card shadow-4-strong border border-1 border-primary my-3">
            <div class="card-body">
                <h5 class="mb-3">Card Types</h5>
<!--                 <iframe src="cards_template" style="width:99%; height: 400px; border: none;"></iframe>
                <div class="text-center">
                    <button id="orderCardBtn" class="btn btn-success btn-flat btn-lg mt-4"><i
                            class="fa fa-download"></i> Order Card</button>
                </div> -->
            </div>
        </div>
    </div>
</main>

<?php include('footer.php'); ?>