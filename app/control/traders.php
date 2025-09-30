<?php include 'header.php'; ?>
<title>View Traders and Copies | <?= SITE_NAME; ?></title>
<main class="py-5 px-2" id="content">
	<div class="container text-start pt-5">
		<div class="card shadow-3 mt-5 px-3 py-2 me-auto ms-auto">
			<!-- Pills navs -->
			<ul class="nav nav-pills nav-fill mb-3" id="ex1" role="tablist">
				<li class="nav-item" role="presentation">
					<a class="nav-link active text-nowrap" id="ex3-tab-1" data-mdb-toggle="pill" href="#atraders" role="tab" aria-controls="atraders" aria-selected="true"><i class="fas fa-user-tie fa-fw me-2"></i> All Traders</a>
				</li>
				<li class="nav-item" role="presentation">
					<a class="nav-link text-nowrap" id="ex3-tab-2" data-mdb-toggle="pill" href="#copyreq" role="tab" aria-controls="copyreq" aria-selected="false"><i class="fas fa-edit fa-fw me-2"></i>Copy Requests</a>
				</li>
			</ul>
			<!-- Pills navs -->
			<!-- Pills content -->
			<div class="tab-content" id="ex2-content">
				<div class="tab-pane fade show active" id="atraders" role="tabpanel" aria-labelledby="ex3-tab-1">
					<div class="mt-4">
						<div class="col-md-6 me-auto ms-auto" align="center">
							<p class="alert alert-primary" id="errorshow1"></p>
						</div>
						<div class="table-wrapper table-responsive">
							<table class="table table-striped table-hover" id="allTraders">
								<thead>
									<tr class="text-nowrap">
										<th scope="col-sm">S/N</th>
										<th scope="col">ID</th>
										<th scope="col">Name</th>
										<th scope="col">Win Rate</th>
										<th scope="col">Profit Share</th>
										<th scope="col">View</th>
										<th scope="col">Edit</th>
										<th scope="col">Delete</th>
									</tr>
								</thead>
								<?php
								$sql = $db_conn->prepare("SELECT * FROM traders ORDER BY main_id DESC");
								$sql->execute();
								$b = 1;
								?>
								<tbody>
									<div class="text-center">
										<?php
										if ($sql->rowCount() < 1) {
											echo "<td class='text-center' colspan='8'>No data available</td>";
										} else {
											while ($row = $sql->fetch(PDO::FETCH_ASSOC)) :
										?></div>
									<tr class="text-nowrap">
										<td scope="row"><?= $b; ?></td>
										<td class="text-start">#<?= $row['trader_id']; ?></td>
										<td class="text-start"><?= $row['t_name']; ?></td>
										<td class="text-start"><?= $row['t_win_rate']; ?>%</td>
										<td class="text-start"><?= $row['t_profit_share']; ?>%</td>
										<td class="text-start"><a class="btn btn-sm btn-rounded btn-info" href="./traderdetails?tid=<?= $row['trader_id']; ?>" target="_blank">View</a></td>
										<td class="text-start"><a class="btn btn-sm btn-rounded btn-primary" href="edittrader?tid=<?= $row['trader_id']; ?>" target="_blank">Edit</a></td>
										<td class="text-start"><button class="btn btn-sm btn-rounded btn-danger" id="btnDelete<?= $row['trader_id']; ?>">Delete</button></td>
										<script>
											function deleteT<?= $row['trader_id']; ?>() {
												var photo = "<?= $row['t_photo1']; ?>";
												var trader_id = "<?= $row['trader_id']; ?>";
												$.ajax({
													type: 'POST',
													url: '../../ops/adminauth',
													data: {
														request: 'deleteTrader',
														'trader_id': trader_id,
														'photo': photo
													},
													beforeSend: function() {
														$("#errorshow1").html("Deleting Trader, please wait <span class='fas fa-spinner fa-pulse'></span> ").show();
														$('#btnApprove<?= $row['trader_id']; ?>').html("Deleting <span class='fas fa-spinner fa-pulse'></span>");
													},
													success: function(data) {
														if (data == "success") {
															$("#errorshow1").html("Trader Deleted successfully, page will reload").show();
															setTimeout(' window.location.href = "traders"; ', 2000);
														} else {
															$("#errorshow1").html("<span class='fas fa-exclamation-triangle'></span> " + data).show();
														}
													},
													error: function(err) {
														$("#errorshow1").html("<span class='fas fa-exclamation-triangle'></span> An error occured. Try again. " + err).show();
													}
												});
											}

											//End Function                         
											$('#btnDelete<?= $row['trader_id']; ?>').click(function() {
												deleteT<?= $row['trader_id']; ?>();
											});
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
				<div class="tab-pane fade" id="copyreq" role="tabpanel" aria-labelledby="ex3-tab-2">
					<div class="mt-4">
						<div class="col-md-6 me-auto ms-auto" align="center">
							<p class="alert alert-primary" id="errorshow2"></p>
						</div>
						<div class="table-wrapper table-responsive">
							<table class="table table-striped table-hover" id="allrequests">
								<thead>
									<tr class="text-nowrap">
										<th scope="col-sm">S/N</th>
										<th scope="col">Username</th>
										<th scope="col">Email</th>
										<th scope="col">Phone</th>
										<th scope="col">Trader</th>
										<th scope="col">Action</th>
									</tr>
								</thead>
								<?php
								$sql1 = $db_conn->prepare("SELECT * FROM members WHERE trader IS NOT NULL ORDER BY main_id DESC");
								$sql1->execute();
								$b = 1;
								?>
								<tbody>
									<div class="text-center">
										<?php
										if ($sql->rowCount() < 1) {
											echo "<td class='text-center' colspan='6'>No data available</td>";
										} else {
											while ($row = $sql1->fetch(PDO::FETCH_ASSOC)) :
												$t_id = $row['trader'];
												$sql2 = $db_conn->prepare("SELECT t_name, trader_id FROM traders WHERE trader_id = :trader");
												$sql2->bindParam(":trader", $t_id, PDO::PARAM_STR);
												$sql2->execute();
												$row2 = $sql2->fetch(PDO::FETCH_ASSOC);
										?></div>
									<tr class="text-nowrap">
										<td scope="row"><?= $b; ?></td>
										<td class="text-start"><?= $row['username']; ?></td>
										<td class="text-start"><?= $row['email']; ?></td>
										<td class="text-start"><?= $row['phone']; ?></td>
										<td class="text-start fw-bold"><?= $row2['t_name']; ?> <span class="fas fa-check-circle text-success"></span></span></td>
										<td class="text-start"><?php if ($row['trader_status'] == 0) { ?><button class="btn btn-sm btn-rounded btn-success" id="btnApprove<?= $row['mem_id']; ?>">Approve</button><?php } else { ?><button class="btn btn-sm btn-rounded btn-danger" id="btnCancel<?= $row['mem_id']; ?>">Cancel</button><?php } ?></td>
										<script>
											function approve<?= $row['mem_id']; ?>() {
												var mem_id = "<?= $row['mem_id']; ?>";
												var trader_id = "<?= $row2['trader_id']; ?>";
												$.ajax({
													type: 'POST',
													url: '../../ops/adminauth',
													data: {
														request: 'approveCopy',
														'trader_id': trader_id,
														'mem_id': mem_id
													},
													beforeSend: function() {
														$("#errorshow2").html("Approving request, please wait <span class='fas fa-spinner fa-pulse'></span> ").fadeIn();
														$('#btnApprove<?= $row['mem_id']; ?>').html("Approving <span class='fas fa-spinner fa-pulse'></span>");
													},
													success: function(data) {
														if (data == "success") {
															$("#errorshow2").html("Approval was successful, user is now copying <b><?= $row2['t_name']; ?></b>").fadeIn();
															setTimeout(' window.location.href = "traders"; ', 2000);
														} else {
															$("#errorshow2").html(data).fadeIn();
														}
													},
													error: function(err) {
														$("#errorshow2").html("An error occured. Try again. " + err.statusText).fadeIn();
													}
												});
											}

											function cancel<?= $row['mem_id']; ?>() {
												var mem_id = "<?= $row['mem_id']; ?>";
												var trader_id = "<?= $row2['trader_id']; ?>";
												$.ajax({
													type: 'POST',
													url: '../../ops/adminauth',
													data: {
														request: 'cancelCopy',
														'trader_id': trader_id,
														'mem_id': mem_id
													},
													beforeSend: function() {
														$("#errorshow2").html("Cancelling request, please wait <span class='fas fa-spinner fa-pulse'></span> ").fadeIn();
													},
													success: function(data) {
														if (data == "success") {
															$("#errorshow2").html("Cancelation was successful, user is no longer copying <b><?= $row2['t_name']; ?></b>").fadeIn();
															setTimeout(' window.location.href = "traders"; ', 2000);
														} else {
															$("#errorshow2").html(data).fadeIn();
														}
													},
													error: function(err) {
														$("#errorshow2").html("An error occured. Try again. " + err.statusText).fadeIn();
													}
												});
											}
											//End Function                         
											$('#btnApprove<?= $row['mem_id']; ?>').click(function() {
												approve<?= $row['mem_id']; ?>();
											});


											$('#btnCancel<?= $row['mem_id']; ?>').click(function() {
												cancel<?= $row['mem_id']; ?>();
											});
											//End Function
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
		$("#errorshow1").fadeOut();
		$("#errorshow2").fadeOut();

		var one = $('#allTraders').DataTable({
			"pagingType": 'simple_numbers',
			"lengthChange": true,
			"pageLength": 6,
			dom: 'Bfrtip'
		});

		var two = $('#allrequests').DataTable({
			"pagingType": 'simple_numbers',
			"lengthChange": true,
			"pageLength": 6,
			dom: 'Bfrtip'
		});
	});
</script>