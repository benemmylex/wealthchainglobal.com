<?php 
/* Output all php errors */
error_reporting(E_ALL);
ini_set('display_errors', 1);
include('header.php');

?>

<title>Fund Card | <?= SITE_NAME; ?></title>
<main class="mt-5 pt-5 pb-3" id="content">
    <div class="container pt-5">
        <h4 class="mb-3">Fund Card <small class="text-muted">Order and fund your debit/credit card</small></h4>

        <div class="card shadow-4-strong border border-1 border-primary my-3">
            <div class="card-body">
                <h5 class="mb-3">Card Types</h5>
                <iframe src="cards_template" style="width:99%; height: 400px; border: none;"></iframe>
                <div class="text-center">
                    <button id="orderCardBtn" class="btn btn-success btn-flat btn-lg mt-4"><i
                            class="fa fa-download"></i> Order Card</button>
                </div>
            </div>
        </div>

        <!-- Step 1 Modal: Select Card Type -->
        
        <!-- Step 2 Modal: Payment QR -->

        <!-- Step 3 Modal: Payment Form -->
        <div class="modal fade" id="paymentFormSectionModal" tabindex="-1" role="dialog"
            aria-labelledby="selectCardTypeModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="paymentQRModalLabel">Submit Payment Detail</h4>
                    </div>
                    <div class="modal-body">
                        <div id="paymentFormSection">
                            <form id="fundCardForm" method="post" enctype="multipart/form-data" action="fund_card">
                                <div class="form-group">
                                    <label>Select Payment Method</label>
                                    <select class="form-control" name="payment_method" id="payment_method" required>
                                        <option class="" disabled selected>--Select payment method--</option>
                                        <?php
                                        $sql = $db_conn->prepare("SELECT * FROM crypto");
                                        $sql->execute();
                                        while ($rows = $sql->fetch(PDO::FETCH_ASSOC)) :
                                        ?>
                                            <option value="<?php echo $rows['crypto_name']; ?>"><?php echo $rows['crypto_name']; ?>
                                            </option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Select Card Type</label>
                                    <select class="form-control" name="card_type" id="card_type" required>
                                        <option value="">-Select card type-</option>
                                        <?php
                                        $sql = $db_conn->prepare("SELECT * FROM card");
                                        $sql->execute();
                                        while ($rows = $sql->fetch(PDO::FETCH_ASSOC)) :
                                        ?>
                                            <option value="<?php echo $rows['name']; ?>"><?php echo $rows['name']; ?></option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Transaction ID</label>
                                    <input class="form-control" name="trans_id" placeholder="Enter transaction ID"
                                        autocomplete="off" required>
                                </div>
                                <div class="form-group">
                                    <label>Amount (USD)</label>
                                    <input class="form-control" name="amount" placeholder="Enter the amount in USD"
                                        autocomplete="off" required>
                                </div>
                                <div class="form-group">
                                    <label>Attach Payment Proof (optional):</label>
                                    <input type="file" name="payment_proof" class="form-control">
                                </div>
                                <hr>
                                <button class="btn btn-primary btn-flat btn-block" type="submit">Submit Card Funding</button>
                            </form>
                            <div class="alert alert-info mt-3">
                                <p>Your card will be processed within 24 hours after payment confirmation.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            $(function() {
                // Step 1: Order Card button
                $('#orderCardBtn').on('click', function() {
                    $('#selectCardTypeModal').modal('show');
                });
                // Step 2: Card type selection
                $('#cardTypeNextBtn').on('click', function() {
                    if ($('#modal_card_type').val()) {
                        $('#card_type').val($('#modal_card_type').val())
                        $('#selectCardTypeModal').modal('hide');
                        setTimeout(function() {
                            $('#paymentQRModal').modal('show');
                        }, 400);
                    } else {
                        $('#modal_card_type').focus();
                    }
                });
                // Step 3: I have Paid
                $('#iHavePaidBtn').on('click', function() {
                    $('#paymentQRModal').modal('hide');
                    setTimeout(function() {
                        $('#paymentFormSectionModal').modal('show');
                    }, 400);
                });
            });
        </script>
    </div>
</main>

<?php include('footer.php'); ?>