<?php include 'header.php'; ?>
<title>Withdraw Funds | <?= SITE_NAME; ?></title>
<main style="margin-bottom: 96px; margin-top: 76px; height:100%;" class="mb-5" id="content">
	<div class="container-fluid text-start mt-5 justify-content-center">
		<div class="card shadow-3 col-md-11 mt-5 px-3 py-2 me-auto ms-auto">
			<!-- Pills navs -->
			<ul class="nav nav-pills nav-fill mb-3" id="ex1" role="tablist">
				
				<li class="nav-item" role="presentation">
					<a class="nav-link active text-nowrap" id="ex3-tab-2" data-mdb-toggle="pill" href="#tradefnd" role="tab" aria-controls="tradefnd" aria-selected="false"><i class="fas fa-coins fa-fw me-2"></i>Available balance</a>
				</li>
				<li class="nav-item" role="presentation">
					<a class="nav-link text-nowrap" id="ex3-tab-3" data-mdb-toggle="pill" href="#refund" role="tab" aria-controls="refund" aria-selected="false"><i class="fas fa-handshake fa-fw me-2"></i>Bonus balance</a>
				</li>
				<li class="nav-item" role="presentation">
					<a class="nav-link text-nowrap" id="ex3-tab-4" data-mdb-toggle="pill" href="#profitfund" role="tab" aria-controls="profitfund" aria-selected="false"><i class="fas fa-landmark fa-fw me-2"></i>Profit balance</a>
				</li>
			</ul>
			<!-- Pills navs -->
			<!-- Pills content -->
			<div class="tab-content" id="ex2-content">
				
				<div class="tab-pane fade show active" id="tradefnd" role="tabpanel" aria-labelledby="ex3-tab-2">
					<div class="mt-4">
						<div class="col-md-6 me-auto ms-auto" align="center">
							<p class="alert alert-primary" id="errorshow2"></p>
						</div>
						<div class="table-wrapper table-responsive">
							<table class="table table-striped table-hover" id="tradetab">
								<thead>
									<tr class="text-nowrap">
										<th scope="col">S/N</th>
										<th scope="col">Full Name</th>
										<th scope="col">Username</th>
										<th scope="col">Email</th>
										<th scope="col">Balance</th>
										<th scope="col">Amount</th>
										<th scope="col">Action</th>
									</tr>
								</thead>
								<?php
								$sql = $db_conn->prepare("SELECT * FROM members, balances WHERE members.mem_id = balances.mem_id");
								$sql->execute();
								$b = 1;
								?>
								<tbody>
									<div class="text-center" align="center">
										<?php if ($sql->rowCount() < 1) {
											echo "<td class='text-center' colspan='7'>No data available</td>";
										} else {
											while ($row = $sql->fetch(PDO::FETCH_ASSOC)) :
												$symbol = "$";
										?></div>
									<tr class="text-nowrap">
										<td scope="row"><?= $b; ?></td>
										<td class="text-left"><?= ucfirst($row['fullname']); ?></td>
										<td class="text-left"><?= ucfirst($row['username']); ?></td>
										<td class="text-left"><?= $row['email']; ?></td>
										<td class="text-left"><?= $symbol . number_format($row['available'], 2); ?></td>
										<td class="text-left"><input class="form-control" type="text" name="amount" placeholder="Amount" id="amounttrade<?= $row['mem_id']; ?>"></td>
										<td class="text-left"><button class='btn btn-primary btn-rounded btn-sm' id='btnwitTrade<?= $row["mem_id"]; ?>'> Withdraw</button></td>
										<!-- ================================================================================================================================================ -->
										<script>
											function withdrawtrade<?= $row['mem_id']; ?>() {
												var mem_id = "<?= $row['mem_id']; ?>";
												var amount = document.getElementById("amounttrade<?= $row['mem_id']; ?>").value;
												var available = "<?= $row['available']; ?>";
												$.ajax({
													type: 'POST',
													url: '../../ops/adminauth',
													data: {
														request: 'withdrawdeposit',
														'mem_id': mem_id,
														'amount': amount,
														'available': available
													},
													beforeSend: function() {
														$('#errorshow2').html("Withdrawing <span class='far fa-spinner fa-spin'></span>").show();
														$('#btnwitTrade<?= $row['mem_id']; ?>').html("Processing <span class='far fa-spinner fa-spin'></span>");
													},
													success: function(data) {
														if (data == "success") {
															$("#errorshow2").html("Withdrawal successful <span class='fas fa-check-circle'></span>").show();
															$('#btnwitTrade<?= $row['mem_id']; ?>').html("Withdraw");
															setTimeout(' window.location.href = "withdraw"; ', 3000);
														} else {
															$("#errorshow2").html("<span class='far fa-exclamation-triangle'></span> " + data).show();
															$('#btnwitTrade<?= $row['mem_id']; ?>').html("Withdraw");
														}
													},
													error: function(err) {
														$("#errorshow2").html("<span class='far fa-exclamation-triangle'></span> An error occured. <br> Try again. " + err).show();
														$('#btnwitTrade<?= $row['mem_id']; ?>').html("Withdraw");
													}
												});
											}

											$('#btnwitTrade<?= $row['mem_id']; ?>').click(function() {
												withdrawtrade<?= $row['mem_id']; ?>();
											});
											//End Revoke
										</script>
								<?php $b++;
											endwhile;
										} ?>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<div class="tab-pane fade" id="refund" role="tabpanel" aria-labelledby="ex3-tab-3">
					<div class="mt-4">
						<div class="col-md-6 me-auto ms-auto" align="center">
							<p class="alert alert-primary" id="errorshow3"></p>
						</div>
						<div class="table-wrapper table-responsive">
							<table class="table table-striped table-hover" id="reftab">
								<thead>
									<tr class="text-nowrap">
										<th scope="col">S/N</th>
										<th scope="col">Full Name</th>
										<th scope="col">Username</th>
										<th scope="col">Email</th>
										<th scope="col">Balance</th>
										<th scope="col">Amount</th>
										<th scope="col">Action</th>
									</tr>
								</thead>
								<?php
								$sql = $db_conn->prepare("SELECT * FROM members, balances WHERE members.mem_id = balances.mem_id");
								$sql->execute();
								$b = 1;
								?>
								<tbody>
									<div class="text-center" align="center">
										<?php if ($sql->rowCount() < 1) {
											echo "<td class='text-center' colspan='7'>No data available</td>";
										} else {
											while ($row = $sql->fetch(PDO::FETCH_ASSOC)) :
												$symbol = "$";
										?></div>
									<tr class="text-nowrap">
										<td scope="row"><?= $b; ?></td>
										<td class="text-left"><?= ucfirst($row['fullname']); ?></td>
										<td class="text-left"><?= ucfirst($row['username']); ?></td>
										<td class="text-left"><?= $row['email']; ?></td>
										<td class="text-left"><?= $symbol . number_format($row['bonus'], 2); ?></td>
										<td class="text-left"><input class="form-control" type="text" name="amount" placeholder="Amount" id="amountref<?= $row['mem_id']; ?>"></td>
										<td class="text-left"><button class='btn btn-primary btn-rounded btn-sm' id='btnwitRef<?= $row["mem_id"]; ?>'> Withdraw</button></td>
										<!-- ================================================================================================================================================ -->
										<script>
											function withdrawref<?= $row['mem_id']; ?>() {
												var mem_id = "<?= $row['mem_id']; ?>";
												var amount = document.getElementById("amountref<?= $row['mem_id']; ?>").value;
												var bonus = "<?= $row['bonus']; ?>";
												$.ajax({
													type: 'POST',
													url: '../../ops/adminauth',
													data: {
														request: 'withdrawbonus',
														'mem_id': mem_id,
														'amount': amount,
														'bonus': bonus
													},
													beforeSend: function() {
														$('#errorshow3').html("Withdrawing <span class='far fa-spinner fa-spin'></span>").show();
														$('#btnwitRef<?= $row['mem_id']; ?>').html("Processing <span class='far fa-spinner fa-spin'></span>");
													},
													success: function(data) {
														if (data == "success") {
															$("#errorshow3").html("Withdrawal successful <span class='fas fa-check-circle'></span>").show();
															$('#btnwitRef<?= $row['mem_id']; ?>').html("Withdraw");
															setTimeout(' window.location.href = "withdraw"; ', 3000);
														} else {
															$("#errorshow3").html("<span class='far fa-exclamation-triangle'></span> " + data).show();
															$('#btnwitRef<?= $row['mem_id']; ?>').html("Withdraw");
														}
													},
													error: function(err) {
														$("#errorshow3").html("<span class='far fa-exclamation-triangle'></span> An error occured. <br> Try again. " + err).show();
														$('#btnwitRef<?= $row['mem_id']; ?>').html("Withdraw");
													}
												});
											}

											$('#btnwitRef<?= $row['mem_id']; ?>').click(function() {
												withdrawref<?= $row['mem_id']; ?>();
											});
											//End Revoke
										</script>
								<?php $b++;
											endwhile;
										} ?>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<div class="tab-pane fade" id="profitfund" role="tabpanel" aria-labelledby="ex3-tab-4">
					<div class="mt-4">
						<div class="col-md-6 me-auto ms-auto" align="center">
							<p class="alert alert-primary" id="errorshow4"></p>
						</div>
						<div class="table-wrapper table-responsive">
							<table class="table table-striped table-hover" id="profittab">
								<thead>
									<tr class="text-nowrap">
										<th scope="col">S/N</th>
										<th scope="col">Full Name</th>
										<th scope="col">Username</th>
										<th scope="col">Email</th>
										<th scope="col">Balance</th>
										<th scope="col">Amount</th>
										<th scope="col">Action</th>
									</tr>
								</thead>
								<?php
								$sql = $db_conn->prepare("SELECT * FROM members, balances WHERE members.mem_id = balances.mem_id");
								$sql->execute();
								$b = 1;
								?>
								<tbody>
									<div class="text-center" align="center">
										<?php if ($sql->rowCount() < 1) {
											echo "<td class='text-center' colspan='7'>No data available</td>";
										} else {
											while ($row = $sql->fetch(PDO::FETCH_ASSOC)) :
												$symbol = "$";
										?></div>
									<tr class="text-nowrap">
										<td scope="row"><?= $b; ?></td>
										<td class="text-left"><?= ucfirst($row['fullname']); ?></td>
										<td class="text-left"><?= ucfirst($row['username']); ?></td>
										<td class="text-left"><?= $row['email']; ?></td>
										<td class="text-left"><?= $symbol . number_format($row['profit'], 2); ?></td>
										<td class="text-left"><input class="form-control" type="text" name="amount" placeholder="Amount" id="amountPrf<?= $row['mem_id']; ?>"></td>
										<td class="text-left"><button class='btn btn-primary btn-rounded btn-sm' id='btnwitPrf<?= $row["mem_id"]; ?>'> Withdraw</button></td>
										<!-- ================================================================================================================================================ -->
										<script>
											function withdrawPrf<?= $row['mem_id']; ?>() {
												var mem_id = "<?= $row['mem_id']; ?>";
												var amount = document.getElementById("amountPrf<?= $row['mem_id']; ?>").value;
												var profit = "<?= $row['profit']; ?>";
												$.ajax({
													type: 'POST',
													url: '../../ops/adminauth',
													data: {
														request: 'withdrawProfit',
														'mem_id': mem_id,
														'amount': amount,
														'profit': profit
													},
													beforeSend: function() {
														$('#errorshow4').html("Withdrawing <span class='fas fa-spinner fa-spin'></span>").show();
													},
													success: function(data) {
														if (data == "success") {
															$("#errorshow4").html("Withdrawal successful <span class='fas fa-check-circle'></span>").show();
															setTimeout(' window.location.href = "withdraw"; ', 3000);
														} else {
															$("#errorshow4").html("<span class='fas fa-exclamation-triangle'></span> " + data).show();
														}
													},
													error: function(err) {
														$("#errorshow4").html("<span class='fas fa-exclamation-triangle'></span> An error occured. <br> Try again. " + err).show();
													}
												});
											}

											$('#btnwitPrf<?= $row['mem_id']; ?>').click(function() {
												withdrawPrf<?= $row['mem_id']; ?>();
											});
											//End Revoke
										</script>
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
</body>
<?php include 'footer.php'; ?>
<script>
	$(document).ready(function() {
		$("#errorshow1").hide();
		$("#errorshow2").hide();
		$("#errorshow3").hide();
		$("#errorshow4").hide();


		var one = $('#tradetab').DataTable({
			"pagingType": 'simple_numbers',
			"lengthChange": true,
			"pageLength": 6,
			dom: 'Bfrtip'
		});
		
		var two = $('#profittab').DataTable({
			"pagingType": 'simple_numbers',
			"lengthChange": true,
			"pageLength": 6,
			dom: 'Bfrtip'
		});

		var one = $('#reftab').DataTable({
			"pagingType": 'simple_numbers',
			"lengthChange": true,
			"pageLength": 6,
			dom: 'Bfrtip'
		});
	});
</script>