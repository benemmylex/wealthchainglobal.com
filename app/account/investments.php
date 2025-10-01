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

                    <?php
                    // Fetch plans using existing PDO connection from connect.php
                    $plans = [];
                    try {
                        $stmt = $db_conn->prepare("SELECT * FROM plans WHERE status = 1 ORDER BY max_amt ASC");
                        $stmt->execute();
                        $plans = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    } catch (PDOException $e) {
                        echo '<div class="alert alert-danger">Database error: ' . htmlspecialchars($e->getMessage()) . '</div>';
                    }
                    ?>
                    <?php foreach ($plans as $plan): ?>
                        <div class="col-lg-4 col-md-12 mb-3">
                            <form method="POST" action="activate_plan.php">
                                <input type="hidden" name="plan_id" value="<?= $plan['id']; ?>">
                                <div class="card border border-1 border-primary">
                                    <div class="card-header">
                                        <h5 class="text-center">
                                            <?= htmlspecialchars($plan['name']); ?> Plan
                                            <?php
                                            $userPlan = isset($_SESSION['userplan']) ? strtolower($_SESSION['userplan']) : '';
                                            if ($userPlan == strtolower($plan['name']) && isset($_SESSION['planstatus']) && $_SESSION['planstatus'] == 1) {
                                                echo '<span class="fas fa-check-circle text-success"></span>';
                                            }
                                            ?>
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <small>Minimum</small>
                                        <h4><?= $_SESSION['symbol']; ?><?= number_format($plan['min_amt']); ?> - <?= $_SESSION['symbol']; ?><?= number_format($plan['max_amt']); ?></h4>
                                        <div class="text-center mb-2">
                                            <div class="btn btn-primary btn-block mb-1">
                                                <p class="fw-bold mb-0">ROI</p>
                                                <span><?= htmlspecialchars($plan['roi']); ?>%</span>
                                            </div>
                                            <?php if ($plan['duration'] > 1): ?>
                                                <div class="btn btn-primary btn-block mb-1">
                                                    <p class="fw-bold mb-0">Duration</p>
                                                    <span><?= htmlspecialchars($plan['duration']); ?> days</span>
                                                </div>
                                            <?php endif; ?>
                                            <div class="btn btn-primary btn-block mb-1">
                                                <p class="fw-bold mb-0">Cashout</p>
                                                <span><?= htmlspecialchars($plan['cashout']); ?> days</span>
                                            </div>
                                        </div>
                                        <div class="mb-2">
                                            <small><?= htmlspecialchars($plan['short_desc']); ?></small>
                                        </div>
                                        <div class="input-group form-outline mb-0 mt-3">
                                            <input value="0" type="text" class="form-control" placeholder="Amount" min="<?= htmlspecialchars($plan['min_amt']); ?>" max="<?= htmlspecialchars($plan['max_amt']); ?>" required id="amount_<?= $plan['id']; ?>" name="amount_<?= $plan['id']; ?>" aria-label="Amount" aria-describedby="amount-addon-<?= $plan['id']; ?>" />
                                            <button class="btn btn-primary" type="button" data-mdb-ripple-init aria-expanded="false">
                                                <?= $_SESSION['currency']; ?>
                                            </button>
                                            <label class="form-label" for="amount_<?= $plan['id']; ?>">Amount</label>
                                        </div>
                                        <p class="small text-end">Balance: <?= $_SESSION['symbol']; ?><?= number_format($available); ?></p>
                                        <div class="my-3" align="center">
                                            <button type="submit" class="btn btn-md btn-primary">Activate</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    <?php endforeach; ?>

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