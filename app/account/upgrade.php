<?php include "header.php"; ?>
<title>Investment Plan | <?= SITE_NAME; ?></title>
<main class="py-5 mt-5" id="content">
    <div class="container pt-5">
        <div class="card border-1 border border-primary">
            <div class="card-header py-3">
                <h5 class="fw-bold text-uppercase text-center">Investment Plan</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-4 col-md-12 mb-3">
                        <div class="card border border-1 border-primary">
                            <div class="card-header">
                                <h5 class="text-center">Bronze Plan <?= $_SESSION['userplan'] == 'bronze' && $_SESSION['planstatus'] == 1 ? '<span class="fas fa-check-circle text-success"></span>' : ''; ?></h5>
                            </div>
                            <div class="card-body">
                                <small>Minimum</small>
                                <h4><?= $_SESSION['symbol']; ?>500 - <?= $_SESSION['symbol']; ?>5,000</h4>
                                <div class="text-center">
                                    <div class="btn btn-primary btn-block">
                                        <p class="fw-bold mb-0">Signal</p>
                                        <span>Basic trading signal</span>
                                    </div>
                                    <div class="btn btn-primary btn-block">
                                        <p class="fw-bold mb-0">Expert support</p>
                                        <span>24/7 Experts support</span>
                                    </div>
                                    <div class="btn btn-primary btn-block">
                                        <p class="fw-bold mb-0">Currencies</p>
                                        <span>20+ currencies</span>
                                    </div>
                                </div>
                                <div class="input-group form-outline mb-0 mt-3">
                                    <input value="0" type="text" class="form-control" placeholder="Amount" min="10" required id="amountb" name="amountb" aria-label="Amount" aria-describedby="amountb-addon" />
                                    <button class="btn btn-primary" type="button" data-mdb-ripple-init aria-expanded="false">
                                        <?= $_SESSION['currency']; ?>
                                    </button>
                                    <label class="form-label" for="amountb">Amount</label>
                                </div>
                                <p class="small text-end">Balance: <?= $_SESSION['symbol']; ?><?= number_format($available); ?></p>
                                <div class="my-3" align="center">
                                    <button type="button" onclick="selectPlan($('#amountb').val(), 'bronze');" class="btn btn-md btn-primary">Select</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-12 mb-3">
                        <div class="card border border-1 border-primary">
                            <div class="card-header">
                                <h5 class="text-center">Silver Plan <?= $_SESSION['userplan'] == 'silver' && $_SESSION['planstatus'] == 1 ? '<span class="fas fa-check-circle text-success"></span>' : ''; ?></h5>
                            </div>
                            <div class="card-body">
                                <small>Minimum</small>
                                <h4><?= $_SESSION['symbol']; ?>5,000 - <?= $_SESSION['symbol']; ?>50,000</h4>
                                <div class="text-center">
                                    <div class="btn btn-primary btn-block">
                                        <p class="fw-bold mb-0">Signal</p>
                                        <span>Premium trading signal</span>
                                    </div>
                                    <div class="btn btn-primary btn-block">
                                        <p class="fw-bold mb-0">Expert support</p>
                                        <span>24/7 Experts support</span>
                                    </div>
                                    <div class="btn btn-primary btn-block">
                                        <p class="fw-bold mb-0">Currencies</p>
                                        <span>50+ currencies</span>
                                    </div>
                                </div>
                                <div class="input-group form-outline mb-0 mt-3">
                                    <input value="0" type="text" class="form-control" placeholder="Amount" min="10" required id="amountpr" name="amountpr" aria-label="Amount" aria-describedby="amountpr-addon" />
                                    <button class="btn btn-primary" type="button" data-mdb-ripple-init aria-expanded="false">
                                        <?= $_SESSION['currency']; ?>
                                    </button>
                                    <label class="form-label" for="amountpr">Amount</label>
                                </div>
                                <p class="small text-end">Balance: <?= $_SESSION['symbol']; ?><?= number_format($available); ?></p>
                                <div class="my-3" align="center">
                                    <button type="button" onclick="selectPlan($('#amountpr').val(), 'silver');" class="btn btn-md btn-primary">Select</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-12">
                        <div class="card border border-1 border-primary">
                            <div class="card-header">
                                <h5 class="text-center">Gold Plan <?= $_SESSION['userplan'] == 'gold' && $_SESSION['planstatus'] == 1 ? '<span class="fas fa-check-circle text-success"></span>' : ''; ?></h5>
                            </div>
                            <div class="card-body">
                                <small>Minimum</small>
                                <h4><?= $_SESSION['symbol']; ?>50,000 - above</h4>
                                <div class="text-center">
                                    <div class="btn btn-primary btn-block">
                                        <p class="fw-bold mb-0">Signal</p>
                                        <span>Expert analysis with premium trading signal</span>
                                    </div>
                                    <div class="btn btn-primary btn-block">
                                        <p class="fw-bold mb-0">Expert support</p>
                                        <span>24/7 Experts support</span>
                                    </div>
                                    <div class="btn btn-primary btn-block">
                                        <p class="fw-bold mb-0">Currencies</p>
                                        <span>150+ currencies</span>
                                    </div>
                                </div>
                                <div class="input-group form-outline mb-0 mt-3">
                                    <input value="0" type="text" class="form-control" placeholder="Amount" min="10" required id="amountpl" name="amountpl" aria-label="Amount" aria-describedby="amountpl-addon" />
                                    <button class="btn btn-primary" type="button" data-mdb-ripple-init aria-expanded="false">
                                        <?= $_SESSION['currency']; ?>
                                    </button>
                                    <label class="form-label" for="amountpl">Amount</label>
                                </div>
                                <p class="small text-end">Balance: <?= $_SESSION['symbol']; ?><?= number_format($available); ?></p>
                                <div class="my-3" align="center">
                                    <button type="button" onclick="selectPlan($('#amountpl').val(), 'gold');" class="btn btn-md btn-primary">Select</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?php include "footer.php"; ?>
<script>
    $(document).ready(() => {
        $("#error").fadeOut();
    });

    const selectPlan = (amount, plan) => {
        var request = "selectplan";
        if ($(amount) == null || amount == 0) {
            toastr.info("Enter an amount");
        } else {
            $.ajax({
                url: '../../ops/users',
                type: 'POST',
                data: {
                    request,
                    amount,
                    plan
                },
                beforeSend: function() {
                    toastr.info("Please wait", '', {
                        progressBar: true,
                    });
                },
                success: function(data) {
                    var response = $.parseJSON(data);
                    if (response.status == "success") {
                        toastr.info(response.message);
                        setTimeout(() => {
                            location.reload()
                        }, 2000);
                    } else {
                        toastr.info(response.message);
                    }
                },
                cache: false,
                error: function() {
                    toastr.info("An error has occured!!");
                }
            });
        }
    }
</script>