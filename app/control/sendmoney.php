<?php include 'header.php'; ?>
<title>Send Money | <?= SITE_NAME; ?></title>
<main class="py-5 px-2" id="content">
	<div class="container text-start pt-5">
		<div class="shadow-3">
			<!-- Pills navs -->
			<ul class="nav nav-pills nav-fill mb-3" id="ex1" role="tablist">
				<li class="nav-item" role="presentation">
					<a class="nav-link active text-nowrap" id="ex3-tab-2" data-mdb-toggle="pill" href="#tradefnd" role="tab" aria-controls="tradefnd" aria-selected="false"><i class="fas fa-coins fa-fw me-2"></i>Available Balance</a>
				</li>
				<li class="nav-item" role="presentation">
					<a class="nav-link text-nowrap" id="ex3-tab-3" data-mdb-toggle="pill" href="#refund" role="tab" aria-controls="refund" aria-selected="false"><i class="fas fa-handshake fa-fw me-2"></i>Bonus Balance</a>
				</li>
				<li class="nav-item" role="presentation">
					<a class="nav-link text-nowrap" id="ex3-tab-4" data-mdb-toggle="pill" href="#profitfund" role="tab" aria-controls="profitfund" aria-selected="false"><i class="fas fa-landmark fa-fw me-2"></i>Profit Balance</a>
				</li>
			</ul>
			<!-- Pills navs -->
			<!-- Pills content -->
			<div class="tab-content card " id="ex2-content">
				<div class="tab-pane fade show active" id="tradefnd" role="tabpanel" aria-labelledby="ex3-tab-2">
					<div class="card-body">
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
										<td class="text-left"><?= $row['fullname']; ?></td>
										<td class="text-left"><?= $row['username']; ?></td>
										<td class="text-left"><?= $row['email']; ?></td>
										<td class="text-left"><?= $symbol . number_format($row['available'], 2); ?></td>
										<td class="text-left"><input class="form-control" type="text" name="amount" placeholder="Amount" id="amounttrade<?= $row['mem_id']; ?>"></td>
										<td class="text-left"><button class='btn btn-primary btn-rounded btn-sm' id='btnwitTrade<?= $row["mem_id"]; ?>'> Send Funds</button></td>
										<!-- ================================================================================================================================================ -->
										<script>
											function sendfundtrade<?= $row['mem_id']; ?>() {
												var mem_id = "<?= $row['mem_id']; ?>";
												var amount = document.getElementById("amounttrade<?= $row['mem_id']; ?>").value;
												var available = "<?= $row['available']; ?>";
												var email = "<?= $row['email']; ?>";
												var username = "<?= $row['username']; ?>";
												$.ajax({
													type: 'POST',
													url: '../../ops/adminauth',
													data: {
														request: 'sendfundsAvl',
														'mem_id': mem_id,
														'amount': amount,
														'available': available,
														'email': email,
														'username': username
													},
													beforeSend: function() {
														$('#errorshow2').html("Sending <span class='fas fa-spinner fa-spin'></span>").fadeIn();
													},
													success: function(data) {
														if (data == "success") {
															$("#errorshow2").html("Sending successful <span class='fas fa-check-circle'></span>").fadeIn();
															setTimeout(' window.location.href = "sendmoney"; ', 3000);
														} else {
															$("#errorshow2").html(data).fadeIn();
														}
													},
													error: function(err) {
														$("#errorshow2").html("An error occured. <br> Try again. " + err.statusText).fadeIn();
													}
												});
											}

											$('#btnwitTrade<?= $row['mem_id']; ?>').click(function() {
												sendfundtrade<?= $row['mem_id']; ?>();
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
					<div class="card-body">
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
										<td class="text-left"><?= $row['fullname']; ?></td>
										<td class="text-left"><?= $row['username']; ?></td>
										<td class="text-left"><?= $row['email']; ?></td>
										<td class="text-left"><?= $symbol . number_format($row['bonus'], 2); ?></td>
										<td class="text-left"><input class="form-control" type="text" name="amount" placeholder="Amount" id="amountref<?= $row['mem_id']; ?>"></td>
										<td class="text-left"><button class='btn btn-primary btn-rounded btn-sm' id='btnwitRef<?= $row["mem_id"]; ?>'> Send Funds</button></td>
										<!-- ================================================================================================================================================ -->
										<script>
											function sendfundref<?= $row['mem_id']; ?>() {
												var mem_id = "<?= $row['mem_id']; ?>";
												var amount = document.getElementById("amountref<?= $row['mem_id']; ?>").value;
												var bonus = "<?= $row['bonus']; ?>";
												var email = "<?= $row['email']; ?>";
												var username = "<?= $row['username']; ?>";
												$.ajax({
													type: 'POST',
													url: '../../ops/adminauth',
													data: {
														request: 'sendfundsBonus',
														'mem_id': mem_id,
														'amount': amount,
														'bonus': bonus,
														'email': email,
														'username': username
													},
													beforeSend: function() {
														$('#errorshow3').html("Sending <span class='fas fa-spinner fa-spin'></span>").fadeIn();
													},
													success: function(data) {
														if (data == "success") {
															$("#errorshow3").html("Sending successful <span class='fas fa-check-circle'></span>").fadeIn();
															setTimeout(' window.location.href = "sendmoney"; ', 3000);
														} else {
															$("#errorshow3").html(data).fadeIn();
														}
													},
													error: function(err) {
														$("#errorshow3").html("An error occured. <br> Try again. " + err.statusText).fadeIn();
													}
												});
											}

											$('#btnwitRef<?= $row['mem_id']; ?>').click(function() {
												sendfundref<?= $row['mem_id']; ?>();
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
					<div class="card-body">
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
												switch ($row['currency']) {
													case 'USD':
													$symbol = "$";
													break;
													case 'EUR':
													$symbol = "€";
													break;
													case 'GBP':
													$symbol = "£";
													break;
													default:
													$symbol = "$";
													break;
												}
										?></div>
									<tr class="text-nowrap">
										<td scope="row"><?= $b; ?></td>
										<td class="text-left"><?= $row['fullname']; ?></td>
										<td class="text-left"><?= $row['username']; ?></td>
										<td class="text-left"><?= $row['email']; ?></td>
										<td class="text-left"><?= $symbol . number_format($row['profit'], 2); ?></td>
										<td class="text-left"><input class="form-control" type="text" name="amount" placeholder="Amount" id="amountPrf<?= $row['mem_id']; ?>"></td>
										<td class="text-left"><button class='btn btn-primary btn-rounded btn-sm' id='btnwitPrf<?= $row["mem_id"]; ?>'> Send Funds</button></td>
										<!-- ================================================================================================================================================ -->
										<script>
											function sendfundPrf<?= $row['mem_id']; ?>() {
												var mem_id = "<?= $row['mem_id']; ?>";
												var amount = document.getElementById("amountPrf<?= $row['mem_id']; ?>").value;
												var profit = "<?= $row['profit']; ?>";
												var email = "<?= $row['email']; ?>";
												var username = "<?= $row['username']; ?>";
												$.ajax({
													type: 'POST',
													url: '../../ops/adminauth',
													data: {
														request: 'sendfundsPrf',
														'mem_id': mem_id,
														'amount': amount,
														'profit': profit,
														'email': email,
														'username': username
													},
													beforeSend: function() {
														$('#errorshow4').html("Sending <span class='fas fa-spinner fa-spin'></span>").fadeIn();
													},
													success: function(data) {
														if (data == "success") {
															$("#errorshow4").html("Sending successful <span class='fas fa-check-circle'></span>").fadeIn();
															setTimeout(' window.location.href = "sendmoney"; ', 3000);
														} else {
															$("#errorshow4").html(data).fadeIn();
														}
													},
													error: function(err) {
														$("#errorshow4").html("An error occured. <br> Try again. " + err.statusText).fadeIn();
													}
												});
											}

											$('#btnwitPrf<?= $row['mem_id']; ?>').click(function() {
												sendfundPrf<?= $row['mem_id']; ?>();
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
				<!---->
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

		var one = $('#reftab').DataTable({
			"pagingType": 'simple_numbers',
			"lengthChange": true,
			"pageLength": 6,
			dom: 'Bfrtip'
		});

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
	});
</script>