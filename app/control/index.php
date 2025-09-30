<?php include 'header.php'; ?>
<title>Dashboard | <?= SITE_NAME; ?></title>
<main style="margin-top: 76px; height:100%;" class="h-100" id="content">
	<div class="container-fluid text-start mt-5 h-100">
		<div class="">
			<h3 class="font-weight-bold black-text ps-3"><i class="fas fa-tachometer-alt"></i> Hello, <?= $admusername; ?></h3>
			<p class="small mt-0 pt-0 ps-3">Account Summary</p>
			<div class="card py-4 mb-4 mt-3 z-depth-2 shadow-3">
				<div class="card-body bg-gradient">
					<div class="row g-1">
						<div class="col-md-4 mt-2" onclick="redir('./users');" style="cursor: pointer;">
							<div class="card shadow-5" style="background: linear-gradient(rgba(3,6,126,0.65), rgba(122,0,147,0.55));">
								<div class="card-body">
									<h1 class="text-center"><span class="fas fa-fw fa-users text-white" style="font-size: 34px;"></span></h1>
									<h5 class="text-center font-weight-bold text-white">All Users</h5>
									<h3 class="text-center font-weight-bold text-white"><?= $totalusers; ?></h3>
								</div>
							</div>
						</div>
						<div class="col-md-4 mt-2" onclick="redir('./approvewit');" style="cursor: pointer;">
							<div class="card shadow-5">
								<div class="card-body">
									<h1 class="text-center"><span class="fas fa-fw fa-credit-card text-info" style="font-size: 34px;"></span></h1>
									<h5 class="text-center font-weight-bold text-primary">Awaiting Withdrawals</h5>
									<h3 class="text-center font-weight-bold text-white"><?= $allWit; ?></h3>
								</div>
							</div>
						</div>
						<div class="col-md-4 mt-2 mb-3" onclick="redir('./deposit');" style="cursor: pointer;">
							<div class="card shadow-5" style="background: linear-gradient(rgba(3,6,126,0.65), rgba(122,0,147,0.55));">
								<div class="card-body">
									<h1 class="text-center"><span class="fas fa-fw fa-file-invoice-dollar text-white" style="font-size: 34px;"></span></h1>
									<h5 class="text-center font-weight-bold text-white">Awaiting Deposits</h5>
									<h3 class="text-center font-weight-bold text-white"><?= $allDep; ?></h3>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="card rounded-2 my-3 shadow-3">
				<div class="card-body">
					<h4 class="fw-bold">Registered Users</h4>
					<div class="my-2">
						<p class="alert alert-primary" id="errorshow1"></p>
					</div>
					<div class="table-wrapper table-responsive">
						<table class="table table-striped table-hover" id="alluser">
							<thead>
								<tr class="text-nowrap">
									<th scope="col-sm" class="">S/N</th>
									<th scope="col" class="">Full Name</th>
									<th scope="col" class="">Username</th>
									<th scope="col" class="">Email</th>
									<th scope="col" class="">Phone</th>
									<th scope="col" class="">Delete</th>
									<th scope="col" class="">View</th>
								</tr>
							</thead>
							<?php
							$sql = $db_conn->prepare("SELECT * FROM members ORDER BY main_id DESC LIMIT 5");
							$sql->execute();
							$b = 1;
							?>
							<tbody>
								<div class="text-center" align="center">
									<?php if ($sql->rowCount() < 1) {
										echo "<td class='text-center' colspan='10'>No data available</td>";
									} else {
										while ($row = $sql->fetch(PDO::FETCH_ASSOC)) : ?></div>
								<tr class="text-nowrap">
									<td class="text-start"> <?= $b; ?></td>
									<td class="text-start"><?= $row['fullname']; ?></td>
									<td class="text-start"><?= $row['username']; ?></td>
									<td class="text-start"><?= $row['email']; ?></td>
									<td class="text-start"><?= $row['phone']; ?></td>
									<td class="text-start"><button class='btn btn-sm btn-rounded btn-danger' onclick="del('<?= $row['mem_id']; ?>', '<?= $row['username']; ?>', '<?= $row['photo']; ?>')">Delete</button></td>
									<td class="text-start"><a class='btn btn-sm btn-rounded btn-primary' href="user?user=<?= $row['mem_id']; ?>">View</a></td>
							<?php $b++;
										endwhile;
									} ?>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<div class="card py-4 mt-3 mb-5 z-depth-2 shadow-3">
				<div class="card-body">
					<h4 class="font-weight-bold">Crypto Market Prices</h4>
					<div class="cryptohopper-web-widget" data-id="1" data-numcoins="14" data-realtime="on" data-table_length="10"></div>
				</div>
			</div>
		</div>
	</div>
</main>
<!--Main layout-->
</body>

<?php include 'footer.php'; ?>
<script src="../../assets/js/jquery-redirect.js"></script>
<script src="https://www.cryptohopper.com/widgets/js/script"></script>

<script>
	$(document).ready(function() {
		$("#errorshow1").hide();

		var one = $('#alluser').DataTable({
			"pagingType": 'simple_numbers',
			"lengthChange": true,
			"pageLength": 10,
			dom: 'Bfrtip'
		});
	});

	function redir(link, params) {
		$.redirect(link, params);
	}

	function email(mem_id, username, email) {
		$.ajax({
			type: 'POST',
			url: '../../ops/adminauth',
			data: {
				request: 'emailverify',
				'mem_id': mem_id,
				'username': username,
				'email': email
			},
			beforeSend: function() {
				$('#errorshow1').html("Verifying Email <span class='far fa-spinner fa-pulse'></span>").show();
			},
			success: function(data) {
				if (data == "success") {
					$("#errorshow1").html("User email verified successfully <span class='fas fa-check-circle'></span>").show();
					setTimeout(() => {
						location.reload();
					}, 2000);
				} else {
					$("#errorshow1").html(data).show();
					setTimeout(() => {
						$("#errorshow1").hide();
					}, 6000);
				}
			},
			error: function() {
				$("#errorshow1").html("An error occured. <br> Try again.").show();
			}
		});
	}

	function del(mem_id, username, photo) {
		$.ajax({
			type: 'POST',
			url: '../../ops/adminauth',
			data: {
				request: 'deleteuser',
				'mem_id': mem_id,
				'username': username
			},
			beforeSend: function() {
				$('#errorshow1').html("Deleting user <span class='far fa-spinner fa-pulse'></span>").show();
			},
			success: function(data) {
				if (data == "success") {
					$("#errorshow1").html("User Deleted Successfully <span class='fas fa-check-circle'></span>").show();
					setTimeout(() => {
						location.reload();
					}, 2000);
				} else {
					$("#errorshow1").html(data).show();
					setTimeout(() => {
						$("#errorshow1").hide();
					}, 6000);
				}
			},
			error: function() {
				$("#errorshow1").html("An error occured. <br> Try again.").show();
			}
		});
	}
</script>