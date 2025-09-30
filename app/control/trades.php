<?php include "header.php";  ?>
<title>All trades : <?= SITE_NAME; ?></title>
<main style="margin-bottom: 96px; margin-top: 76px; height:100%;" class="mb-5" id="content">
	<div class="container-fluid text-start mt-5 justify-content-center">
		<h3 class="font-weight-bold black-text ps-3"><i class="fas fa-tachometer-alt"></i> Hello, <?= $admusername; ?></h3>
		<p class="small mt-0 pt-0 ps-3">All Trades</p>
		<div class="card shadow-3 col-md-12 mt-3 py-2 me-auto ms-auto">
			<div class="">
				<div class="card py-4 mt-3 me-auto ms-auto mb-5 z-depth-2 shadow-3">
					<div class="card-body card-body-cascade pt-3 pb-4 px-3">
						<div class="table-wrapper table-responsive">
							<table class="table align-middle hoverable table-striped table-hover" id="tradetable">
								<thead class="orange darken-2 white-text">
									<tr class="text-nowrap">
										<th scope="col">ID</th>
										<th scope="col">Date</th>
										<th scope="col">Asset</th>
										<th scope="col">Leverage</th>
										<th scope="col">Type</th>
										<th scope="col">Entry Price</th>
										<th scope="col">Outcome</th>
										<th scope="col">Gain/Loss</th>
										<th scope="col">Status</th>
										<th scope="col">View</th>
									</tr>
								</thead>
								<?php
								// $nstats = 1;
								$sql2 = $db_conn->prepare("SELECT * FROM trades ORDER BY main_id DESC");
								// $sql2->bindParam(':stat', $nstats, PDO::PARAM_STR);
								$sql2->execute();
								$b = 1;
								?>
								<tbody>
									<div class="text-center" align="center">
										<?php if ($sql2->rowCount() < 1) {
											echo "<td class='text-center' colspan='10'>No open trades available to show</td>";
										} else {
											while ($row2 = $sql2->fetch(PDO::FETCH_ASSOC)) : ?></div>
									<tr class="text-nowrap font-weight-bold">
										<td class="text-start"><?= $row2['tradeid']; ?></td>
										<td class="text-start"><?= $row2['tradedate']; ?></td>
										<td class="text-start"><?= $row2['small_name']; ?></td>
										<td class="text-start"><?= $row2['leverage']; ?></td>
										<td class="text-start">
											<?php if ($row2['tradetype'] == "Buy") {
													echo "<span class='text-success'>Buy</span>";
												} elseif ($row2['tradetype'] == "Sell") {
													echo "<span class='text-danger'>Sell</span>";
												} ?></td>
										<td class="text-start">$<?= number_format($row2['price'], 2); ?></td>
										<td class="text-start"><?= $row2['outcome']; ?></td>
										<td class="text-start"><?= $row2['outcome'] == "Profit" && $row2['tradestatus'] == 0 ? "<span class='text-success'>+$" . number_format($row2['oamount'], 2) . "</span>" : ($row2['outcome'] == "Loss" && $row2['tradestatus'] == 0 ? "<span class='text-danger'>-$" . number_format($row2['oamount'], 2) . "</span>" : number_format("0.00", 2)); ?></td>
										<td class="text-start">
											<?php if ($row2['tradestatus'] == 1) {
													echo "<span class='text-success'>Open</span>";
												} elseif ($row2['tradestatus'] == 0) {
													echo "<span class='text-warning'>Closed</span>";
												} ?></td>
										<td class="text-start"><a href="./tradedetails?tradeid=<?= $row2['tradeid'] ?>&mem_id=<?= $row2['mem_id'] ?>" class="btn btn-sm btn-primary btn-rounded">View</a></td>
								<?php $b++;
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
<?php include "footer.php";  ?>
<script>
	var two = $('#tradetable').DataTable({
		"pagingType": 'simple_numbers',
		"lengthChange": true,
		"pageLength": 6,
		dom: 'Bfrtip'
	});
</script>