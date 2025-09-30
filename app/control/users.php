<?php include 'header.php'; ?>
<title>Users | <?= SITE_NAME; ?></title>
<main class="py-5 px-2" id="content">
	<div class="container text-start pt-5">
		<div class="card">
			<div class="card-body">
				<div class="col-md-6 me-auto ms-auto">
					<p class="alert alert-primary" id="errorshow1"></p>
				</div>
				<div class="table-wrapper table-responsive">
					<table class="table table-striped table-hover" id="alluser">
						<thead>
							<tr class="text-nowrap">
								<th scope="col-sm">S/N</th>
								<th scope="col">Full Name</th>
								<th scope="col">Username</th>
								<th scope="col">Email</th>
								<th scope="col">Phone</th>
								<th scope="col">Email Verify</th>
								<th scope="col">Send notification</th>
								<th scope="col">Delete</th>
								<th scope="col">View</th>
							</tr>
						</thead>
						<?php
						$sql = $db_conn->prepare("SELECT * FROM members ORDER BY main_id DESC");
						$sql->execute();
						$b = 1;
						?>
						<tbody>
							<div class="text-center" align="center">
								<?php if ($sql->rowCount() < 1) {
									echo "<td class='text-center' colspan='8'>No data available</td>";
								} else {
									while ($row = $sql->fetch(PDO::FETCH_ASSOC)) : ?></div>
							<tr class="text-nowrap">
								<td scope="row"><?= $b; ?></td>
								<td class="text-start"><?= $row['fullname']; ?></td>
								<td class="text-start"><?= $row['username']; ?></td>
								<td class="text-start"><?= $row['email']; ?></td>
								<td class="text-start"><?= $row['phone']; ?></td>
								<td class="text-start"><button class='btn btn-sm btn-rounded btn-success' id="btnEmail<?= $row['mem_id']; ?>" onclick="email<?= $row['mem_id']; ?>()">Email Activate</button></td>
								<td class="text-start"><a class='btn btn-sm btn-rounded btn-primary' href="./sendpopup?user=<?= $row['mem_id']; ?>">Send</a></td>
								<td class="text-start"><button class='btn btn-sm btn-rounded btn-danger' onclick="$('#delModal<?= $row['mem_id']; ?>').modal('show');">Delete</button></td>
								<td class="text-start"><a class='btn btn-sm btn-rounded btn-primary' href="user?user=<?= $row['mem_id']; ?>">View</a></td>
								<script>
									// function suspend<?= $row['mem_id']; ?>() {
									// 	var mem_id = "<?= $row['mem_id']; ?>";
									// 	var username = "<?= $row['username']; ?>";
									// 	var email = "<?= $row['email']; ?>";
									// 	$.ajax({
									// 		type: 'POST',
									// 		url: '../../ops/adminauth',
									// 		data: {
									// 			request: 'suspenduser',
									// 			'mem_id': mem_id,
									// 			'username': username,
									// 			'email': email
									// 		},
									// 		beforeSend: function() {
									// 			$('#errorshow1').html("Suspending user <span class='far fa-spinner fa-pulse'></span>").fadeIn();
									// 			$('#btnSuspend<?= $row['mem_id']; ?>').html("Suspending <span class='far fa-spinner fa-pulse'></span>");
									// 		},
									// 		success: function(data) {
									// 			if (data == "success") {
									// 				$("#errorshow1").html("User Suspend Successfully <span class='fas fa-check-circle'></span>").fadeIn();
									// 				setTimeout(' window.location.href = "users"; ', 4000);
									// 			} else {
									// 				$("#errorshow1").html(data).fadeIn();
									// 			}
									// 		},
									// 		error: function() {
									// 			$("#errorshow1").html("An error occured. <br> Try again.").fadeIn();
									// 		}
									// 	});
									// }

									// function activate<?= $row['mem_id']; ?>() {
									// 	var mem_id = "<?= $row['mem_id']; ?>";
									// 	var username = "<?= $row['username']; ?>";
									// 	var email = "<?= $row['email']; ?>";
									// 	$.ajax({
									// 		type: 'POST',
									// 		url: '../../ops/adminauth',
									// 		data: {
									// 			request: 'activateuser',
									// 			'mem_id': mem_id,
									// 			'username': username,
									// 			'email': email
									// 		},
									// 		beforeSend: function() {
									// 			$('#errorshow1').html("Activating user <span class='far fa-spinner fa-pulse'></span>").fadeIn();
									// 			$('#btnActivate<?= $row['mem_id']; ?>').html("Activating <span class='far fa-spinner fa-pulse'></span>");
									// 		},
									// 		success: function(data) {
									// 			if (data == "success") {
									// 				$("#errorshow1").html("User Unsuspended Successfully <span class='fas fa-check-circle'></span>").fadeIn();
									// 				setTimeout(' window.location.href = "users"; ', 4000);
									// 			} else {
									// 				$("#errorshow1").html(data).fadeIn();
									// 			}
									// 		},
									// 		error: function() {
									// 			$("#errorshow1").html("An error occured. <br> Try again.").fadeIn();
									// 		}
									// 	});
									// }

									function email<?= $row['mem_id']; ?>() {
										var mem_id = "<?= $row['mem_id']; ?>";
										var username = "<?= $row['username']; ?>";
										var email = "<?= $row['email']; ?>";
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
												$('#errorshow1').html("Verifying Email <span class='far fa-spinner fa-pulse'></span>").fadeIn();
											},
											success: function(data) {
												if (data == "success") {
													$("#errorshow1").html("User email verified successfully <span class='fas fa-check-circle'></span>").fadeIn();
													setTimeout(' window.location.href = "users"; ', 4000);
												} else {
													$("#errorshow1").html(data).fadeIn();
												}
											},
											error: function() {
												$("#errorshow1").html("An error occured. <br> Try again.").fadeIn();
											}
										});
									}
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
</main>
<?php
$sql2 = $db_conn->prepare("SELECT * FROM members");
$sql2->execute();
while ($rows = $sql2->fetch(PDO::FETCH_ASSOC)) :
?>
	<div class="modal fade" id="delModal<?= $rows['mem_id']; ?>" tabindex="-1" aria-labelledby="delModal<?= $rows['mem_id']; ?>" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-md" role="document">
			<div class="modal-content text-center">
				<div class="modal-header justify-content-center">
					<h3 class="fw-bold"><span class="fas fa-exclamation-circle"></span> Delete user</h3>
					<button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body py-3">
					<p class="text-center">You about to delete user. Are you sure you want to proceed?</p>
					<p class="alert alert-primary" id="errorS<?= $rows['mem_id']; ?>"></p>
					<button class="btn btn-primary" onclick="delUser('<?= $rows['mem_id']; ?>', '<?= $rows['photo']; ?>', 'errorS<?= $rows['mem_id']; ?>')" type="button" data-mdb-ripple-init aria-expanded="false">
						Yes
					</button>
					<button class="btn btn-danger" onclick="$('#delModal<?= $rows['mem_id']; ?>').modal('hide');" type="button" data-mdb-ripple-init aria-expanded="false">
						No
					</button>
				</div>
			</div>
		</div>
	</div>
	<script>
		$('#errorS<?= $rows['mem_id']; ?>').fadeOut('slow');
	</script>
<?php endwhile; ?>
</body>
<?php include 'footer.php'; ?>
<script>
	$(document).ready(function() {
		$("#errorshow1").fadeOut();
		$("#errorshow2").fadeOut();

		var one = $('#alluser').DataTable({
			"pagingType": 'simple_numbers',
			"lengthChange": true,
			"pageLength": 6,
			dom: 'Bfrtip'
		});
	});

	function delUser(mem_id, photo, span) {
		$.ajax({
			type: 'POST',
			url: '../../ops/adminauth',
			data: {
				request: 'deleteuser',
				mem_id,
				photo
			},
			beforeSend: function() {
				$('#' + span).html("Deleting user <span class='fas fa-spinner fa-pulse'></span>").fadeIn();
			},
			success: function(data) {
				if (data == "success") {
					$("#" + span).html("User Deleted Successfully <span class='fas fa-check-circle'></span>").fadeIn();
					setTimeout(() => {
						location.reload();
					}, 4000);
				} else {
					$("#" + span).html(data).fadeIn();
				}
			},
			error: function() {
				$("#" + span).html("An error occured. <br> Try again.").fadeIn();
			}
		});
	}
</script>