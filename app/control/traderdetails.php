<?php include 'header.php';

if (isset($_GET['tid']) and is_numeric($_GET['tid'])) {
	$trader = $_GET['tid'];
	$checkTrader = $db_conn->prepare("SELECT * FROM traders WHERE trader_id = :trader_id");
	$checkTrader->bindParam(":trader_id", $trader, PDO::PARAM_STR);
	$checkTrader->execute();
	if ($checkTrader->rowCount() < 1) {
		header("Location: ./traders");
	} else {
		$row = $checkTrader->fetch(PDO::FETCH_ASSOC);
	}
} else {
	header("Location: ./traders");
}

?>
<title><?= $row['t_name']; ?> - <?= SITE_NAME; ?></title>
<main class="py-5 px-2">
	<div class="container pt-5">
		<div class="card mb-3">
			<div class="card-body">
				<div class="row">
					<div class="col-md-12 col-lg-4 align-items-center">
						<div align="center">
							<img class="img-fluid rounded-circle" style="border-radius: 50%; max-width: 200px;" src="../../assets/images/traders/<?= $row['t_photo1']; ?>">
						</div>
						<div class="mt-2">
							<h3 class="text-center"><?= $row['t_name']; ?></h3>
						</div>
						<p class="text-center fw-bold small">
							<?php
							$k = 0;
							while ($k < $row['stars']) : ?>
								<span class="fas fa-star text-warning"></span>
							<?php $k++;
							endwhile; ?>
						</p>
					</div>
					<div class="col-md-12 col-lg-8">
						<div class="d-flex mb-3 justify-content-between align-items-center">
							<div class="text-start w-100">
								<p class="fw-bold">Name: </p>
							</div>
							<div class="w-100">
								<p class="fw-normal"><?= $row['t_name']; ?> </p>
							</div>
						</div> <hr>
						<div class="d-flex mb-3 justify-content-between align-items-center">
							<div class="text-start w-100">
								<p class="fw-bold">Trades: </p>
							</div>
							<div class="w-100">
								<p class="fw-normal"><?= (float) $row['t_total_win'] + (float) $row['t_total_loss']; ?></p>
							</div>
						</div> <hr>
						<div class="d-flex mb-3 justify-content-between align-items-center">
							<div class="text-start w-100">
								<p class="fw-bold">Followers: </p>
							</div>
							<div class="w-100">
								<p class="fw-normal"><?= $row['t_followers']; ?></p>
							</div>
						</div> <hr>
						<div class="d-flex mb-3 justify-content-between align-items-center">
							<div class="text-start w-100">
								<p class="fw-bold">Minimum Deposit: </p>
							</div>
							<div class="w-100">
								<p class="fw-normal"><?= $row['t_minimum']; ?></p>
							</div>
						</div> <hr>
						<div class="d-flex mb-3 justify-content-between align-items-center">
							<div class="text-start w-100">
								<p class="fw-bold">Win Rate: </p>
							</div>
							<div class="w-100">
								<p class="fw-normal"><?= $row['t_win_rate']; ?>%</p>
							</div>
						</div> <hr>
						<div class="d-flex mb-3 justify-content-between align-items-center">
							<div class="text-start w-100">
								<p class="fw-bold">Total wins: </p>
							</div>
							<div class="w-100">
								<p class="fw-normal"><?= $row['t_total_win']; ?></p>
							</div>
						</div> <hr>
						<div class="d-flex mb-3 justify-content-between align-items-center">
							<div class="text-start w-100">
								<p class="fw-bold">Total losses: </p>
							</div>
							<div class="w-100">
								<p class="fw-normal"><?= $row['t_total_loss']; ?></p>
							</div>
						</div> <hr>
						<div class="d-flex mb-3 justify-content-between align-items-center">
							<div class="text-start w-100">
								<p class="fw-bold">Profit Share: </p>
							</div>
							<div class="w-100">
								<p class="fw-normal"><?= $row['t_profit_share']; ?>%</p>
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
	$(document).ready(function() {
		$("#errorshow").hide();
	});
</script>