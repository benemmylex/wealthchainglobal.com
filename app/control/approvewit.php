<?php include 'header.php'; ?>
<title>Approve Withdrawal | <?= SITE_NAME; ?></title>
<main class="py-5 px-2" id="content">
	<div class="container text-start pt-5 justify-content-center">
		<h3 class="fw-bold ps-3"><i class="fas fa-tachometer-alt"></i> Hello, <?= ucfirst($admusername); ?></h3>
		<p class="small mt-0 pt-0 ps-3">Approve Withdrawal</p>

		<!-- Pills navs -->
		<ul class="nav nav-pills nav-fill mb-3" id="ex1" role="tablist">
			<li class="nav-item" role="presentation">
				<a class="nav-link text-nowrap" id="ex3-tab-2" data-mdb-toggle="pill" href="#cryptow" role="tab" aria-controls="cryptow" aria-selected="false"><i class="fab fa-btc fa-fw me-2"></i>Withdrawal list</a>
			</li>
		</ul>
		<!-- Pills navs -->
		<!-- Pills content -->
		<div class="tab-content" id="ex2-content">
			<div class="tab-pane fade show active" id="cryptow" role="tabpanel" aria-labelledby="ex3-tab-2">
				<div class="card">
					<div class="card-body">
						<div class="col-md-6 me-auto ms-auto" align="center">
							<p class="alert alert-primary" id="errorshow"></p>
						</div>
						<div class="table-wrapper card-body table-responsive">
							<h3>Approve Withdrawal</h3>
							<table class="table table-striped table-hover" id="cryptoTable">
								<thead>
									<tr class="text-nowrap">
										<th scope="col">TXN ID</th>
										<th scope="col">Username</th>
										<th scope="col">Date</th>
										<th scope="col">Status</th>
										<th scope="col">Crypto</th>
										<th scope="col">Address</th>
										<th scope="col">Amount</th>
										<th scope="col">Approve</th>
										<th scope="col">Fail</th>
										<th scope="col">Delete</th>
									</tr>
								</thead>
								<?php
								$w = "crypto";
								$sql = $db_conn->prepare("SELECT *, wittransc.account AS acct FROM wittransc, balances, members WHERE wittransc.mem_id = balances.mem_id AND members.mem_id = balances.mem_id");
								$sql->execute();
								$new = $sql->rowCount();
								?>
								<tbody>
									<div class="text-center" align="center">
										<?php if ($sql->rowCount() < 1) {
											echo "<td class='text-center' colspan='10'>No data available</td>";
										} else {
											while ($row = $sql->fetch(PDO::FETCH_ASSOC)) :
												$symbol = "$";
										?></div>
									<tr class="text-nowrap">
										<td class="text-start"><?= $row['transc_id']; ?></td>
										<td class="text-start"><?= $row['username']; ?></td>
										<td class="text-start"><?= $row['date_added']; ?></td>
										<td class="text-start">
											<?php
												if ($row['status'] == 1) {
													echo "<span class='text-success'>Completed</span>";
												} elseif ($row['status'] == 0) {
													echo "<span class='text-warning'>Pending</span>";
												} elseif ($row['status'] == 2) {
													echo "<span class='text-danger'>Failed</span>";
												}
											?>
										</td>
										<td class="text-start"><?= $row['method']; ?></td>
										<td class="text-start"><?= $row['wallet_addr']; ?></td>
										<td class="text-start"><?= $symbol . number_format($row['amount'], 2); ?></td>
										<td class="text-start">
											<?php if ($row['status'] == 0) { ?>
												<button type='button' class='btn btn-primary btn-rounded btn-sm' onclick="approve('<?= $row['mem_id']; ?>', '<?= $row['amount']; ?>', '<?= $row['transc_id']; ?>', '<?= $row['acct']; ?>','errorshow')"> Approve</button>
											<?php } else { ?>
												<p class="">All good</p>
											<?php } ?>
										</td>
										<td class="text-start">
											<?php if ($row['status'] == 2) { ?>
												<p class="">All good</p>
											<?php } else { ?>
												<button type='button' class='btn btn-warning btn-rounded btn-sm' onclick="failwit('<?= $row['mem_id']; ?>', '<?= $row['amount']; ?>', '<?= $row['transc_id']; ?>', '<?= $row['acct']; ?>', '<?= $row['status']; ?>', 'errorshow')"> Failed</button>
											<?php } ?>
										</td>
										<td class="text-start"><button type='button' class='btn btn-danger btn-rounded btn-sm' onclick="deletewit('<?= $row['mem_id']; ?>', '<?= $row['transc_id']; ?>', 'errorshow')"> Delete</button></td>
										<!-- ================================================================================================================================================ -->
										<script>

										</script>
								<?php
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
<?php include 'footer.php'; ?>
<script>
	$(document).ready(function() {
		$("#errorshow").fadeOut();

		<?php if ($sql->rowCount() > 0) { ?>

			$('#cryptoTable').DataTable({
				"pagingType": 'simple_numbers',
				"lengthChange": true,
				"pageLength": 6,
				dom: 'Bfrtip'
			});
		<?php } ?>
	});

	function approve(mem_id, amount, transc_id, account, span) {
		$.ajax({
			type: 'POST',
			url: '../../ops/adminauth',
			data: {
				request: 'approvewit',
				mem_id,
				transc_id,
				account,
				amount
			},
			beforeSend: function() {
				$('#' + span).html("Approving withdrawal <span class='fas fa-spinner fa-spin'></span>").fadeIn();
			},
			success: function(data) {
				if (data == "success") {
					$("#" + span).html("Withdrawal successful <span class='far fa-check-circle'></span>").fadeIn();
					setTimeout(() => {
						location.reload();
					}, 3000).show();
				} else {
					$("#" + span).html(data).fadeIn();
				}
			},
			error: function(err) {
				$("#" + span).html("An error occured. <br> Try again. " + err.statusText).fadeIn();
			}
		});
	}

	function deleteTrans(mem_id, transc_id, span) {
		$.ajax({
			type: 'POST',
			url: '../../ops/adminauth',
			data: {
				request: 'deletewit',
				mem_id,
				transc_id
			},
			beforeSend: function() {
				$('#' + span).html("Deleting withdrawal <span class='fas fa-spinner fa-spin'></span>").fadeIn();
			},
			success: function(data) {
				if (data == "success") {
					$("#" + span).html("Withdrawal deleted successfully <span class='far fa-check-circle'></span>").fadeIn();
					setTimeout(() => {
						location.reload();
					}, 3000);
				} else {
					$("#" + span).html(data).fadeIn();
				}
			},
			error: function(err) {
				$("#" + span).html("An error occured. <br> Try again. " + err.statusText).fadeIn();
			}
		});
	}

	function failwit(mem_id, amount, transc_id, account, status, span) {
		$.ajax({
			type: 'POST',
			url: '../../ops/adminauth',
			data: {
				request: 'failwit',
				mem_id,
				transc_id,
				account,
				status,
				amount
			},
			beforeSend: function() {
				$('#' + span).html("Failing withdrawal <span class='fas fa-spinner fa-spin'></span>").fadeIn();
			},
			success: function(data) {
				if (data == "success") {
					$("#" + span).html("Withdrawal failed successfully <span class='far fa-check-circle'></span>").fadeIn();
					setTimeout(() => {
						location.reload();
					}, 3000).show();
				} else {
					$("#" + span).html(data).fadeIn();
				}
			},
			error: function(err) {
				$("#" + span).html("An error occured. <br> Try again. " + err.statusText).fadeIn();
			}
		});
	}
</script>