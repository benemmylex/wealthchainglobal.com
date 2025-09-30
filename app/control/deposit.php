<?php include 'header.php'; ?>
<title>Approve Deposits | <?= SITE_NAME; ?></title>
<main class="py-5 px-2" id="content">
	<div class="container text-start pt-5">
		<div class="card shadow-3 ">
			<div class="card-body">
				<h3 class="fw-bold text-center">Deposit Request</h3>
				<div class="col-md-6 me-auto ms-auto">
					<p class="alert alert-primary" id="errorshow1"></p>
				</div>
				<div class="table-wrapper table-responsive">
					<table class="table align-middle hoverable table-striped table-hover" id="invdeptbl">
						<thead class="">
							<tr class="text-nowrap">
								<th scope="col">ID</th>
								<th scope="col">Date</th>
								<th scope="col">Coin</th>
								<th scope="col">Username</th>
								<th scope="col">Proof</th>
								<th scope="col">Amount</th>
								<th scope="col">Status</th>
								<th scope="col">Action</th>
								<th scope="col">Fail</th>
								<th scope="col">Delete</th>
							</tr>
						</thead>
						<?php
						$transc_type = "copy";
						$sql = $db_conn->prepare("SELECT * FROM members, deptransc WHERE deptransc.mem_id = members.mem_id ORDER BY deptransc.main_id DESC");
						$sql->execute();
						?>
						<tbody>
							<div class="text-center" align="center">
								<?php
								if ($sql->rowCount() < 1) {
									echo "<td class='text-center' colspan='10'>No transactions available to show</td>";
								} else {
									while ($row = $sql->fetch(PDO::FETCH_ASSOC)) :
										$symbol = "$";
								?></div>
							<tr class="text-nowrap font-weight-bold">
								<td class="text-left"><?= $row['transc_id']; ?></td>
								<td class="text-left"><?= $row['date_added']; ?></td>
								<td class="text-left"><?= $row['crypto_name']; ?></td>
								<td class="text-left"><?= ucfirst($row['username']); ?></td>
								<td class="text-left"><a target="_blank" href="../../assets/images/proof/<?= $row['proof']; ?>" class="btn btn-sm btn-rounded btn-info">proof</a></td>
								<td class="text-left"><?= $symbol . number_format($row['amount'], 2); ?></td>
								<td class="text-left">
									<?php
										if ($row['status'] == 1) {
											echo "<span class='text-success'>Success</span>";
										} elseif ($row['status'] == 0) {
											echo "<span class='text-warning'>Pending</span>";
										} elseif ($row['status'] == 2) {
											echo "<span class='text-danger'>Failed</span>";
										}
									?>
								</td>
								<?php if ($row['status'] == 0 || $row['status'] == 2) { ?>
									<td class="text-left"><button type='button' class='btn btn-primary btn-rounded btn-sm' onclick="approvedep('<?= $row['mem_id']; ?>', '<?= $row['amount']; ?>', '<?= $row['transc_id']; ?>')"> Approve</button></td>
								<?php } else {
											echo "<td class='text-left'>All Good</td>";
										} ?>
								<td class="text-left"><button type='button' class='btn btn-warning btn-rounded btn-sm' onclick="faildep('<?= $row['mem_id']; ?>', '<?= $row['amount']; ?>', '<?= $row['transc_id']; ?>', '<?= $row['status']; ?>')"> Fail</button></td>
								<td class="text-left"><button type='button' class='btn btn-danger btn-rounded btn-sm' onclick="deleteFunc('deleteDep', '<?= $row['mem_id']; ?>', '<?= $row['transc_id']; ?>', 'errorshow1')"> Delete</button></td>
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
</main>
</body>
<?php include 'footer.php'; ?>
<script>
	$(document).ready(function() {
		$("#errorshow1").hide();
	});

	var one = $('#invdeptbl').DataTable({
		"pagingType": 'simple_numbers',
		"lengthChange": true,
		"pageLength": 6,
		dom: 'Bfrtip'
	});

	function deleteFunc(request, mem_id, transc_id, span) {
		$.ajax({
			type: 'POST',
			url: '../../ops/adminauth',
			data: {
				request: request,
				'mem_id': mem_id,
				'transc_id': transc_id
			},
			beforeSend: function() {
				$('#' + span).html("Deleting <span class='far fa-spinner fa-spin'></span>").show();
			},
			success: function(data) {
				if (data == "success") {
					$("#" + span).html("Deleted successfully <span class='far fa-check-circle'></span>").show();;
					setTimeout(' window.location.href = "approvewit"; ', 3000)
				} else {
					$("#" + span).html("<span class='far fa-exclamation-triangle'></span> " + data).show();
				}
			},
			error: function(err) {
				$("#" + span).html("<span class='far fa-exclamation-triangle'></span> An error occured. <br> Try again. " + err).show();
			}
		});
	}

	function approvedep(mem_id, amount, transc_id) {
		$.ajax({
			type: 'POST',
			url: '../../ops/adminauth',
			data: {
				request: 'approvedep',
				mem_id,
				amount,
				transc_id
			},
			beforeSend: function() {
				$('#errorshow1').html("Approving deposit <span class='fas fa-spinner fa-spin'></span>").show();
			},
			success: function(data) {
				if (data == "success") {
					$("#errorshow1").html("Deposit approved successfully <span class='fas fa-check-circle'></span>");
					setTimeout(() => {
						location.reload();
					}, 3000);
				} else {
					$("#errorshow1").html(data).show();
				}
			},
			error: function(err) {
				$("#errorshow1").html("An error occured. <br> Try again. " + err.statusText).show();
			}
		});
	}

	function faildep(mem_id, amount, transc_id, status) {
		$.ajax({
			type: 'POST',
			url: '../../ops/adminauth',
			data: {
				request: 'faildep',
				mem_id,
				amount,
				transc_id,
				status
			},
			beforeSend: function() {
				$('#errorshow1').html("Failing deposit <span class='fas fa-spinner fa-spin'></span>").show();
			},
			success: function(data) {
				if (data == "success") {
					$("#errorshow1").html("Transaction failed successfully <span class='fas fa-check-circle'></span>");
					setTimeout(() => {
						location.reload();
					}, 3000);
				} else {
					$("#errorshow1").html(data).show();
				}
			},
			error: function(err) {
				$("#errorshow1").html("An error occured. <br> Try again. " + err.statusText).show();
			}
		});
	}
</script>