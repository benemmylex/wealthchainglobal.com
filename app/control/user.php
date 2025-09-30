<?php include 'header.php';

if (isset($_GET['user'])) {
	$mem_id = $_GET['user'];
	$symbol = "$";

	$getuser = $db_conn->prepare("SELECT * FROM members WHERE mem_id = :mem_id");
	$getuser->bindParam(":mem_id", $mem_id, PDO::PARAM_STR);
	$getuser->execute();
	if ($getuser->rowCount() < 1) {
		header('Location: ./users');
	} else {
		$userrow = $getuser->fetch(PDO::FETCH_ASSOC);
		$symbol = "$";
		$chekearning = $db_conn->prepare("SELECT * FROM balances WHERE mem_id = :mem_id");
		$chekearning->bindParam(':mem_id', $mem_id, PDO::PARAM_STR);
		$chekearning->execute();


		$getEarns = $chekearning->fetch(PDO::FETCH_ASSOC);

		$totalMoney = $getEarns['balance'];
		$bal = $getEarns['available'];
		$bonusbal = $getEarns['bonus'];
		$profit = $getEarns['profit'];
		$pending = $getEarns['pending'];
		$currdaypro = $getEarns['currdaypro'];
		$currdayloss = $getEarns['currdayloss'];
		$alldaygain = $getEarns['alldaygain'];


		$balance = $bal + $bonusbal + $profit;

		$updateBal = $db_conn->prepare("UPDATE balances SET balance = :balance WHERE mem_id = :user");
		$updateBal->bindParam(':balance', $balance, PDO::PARAM_STR);
		$updateBal->bindParam(':user', $mem_id, PDO::PARAM_STR);
		$updateBal->execute();

		$sqls = $db_conn->prepare("SELECT * FROM userplans WHERE mem_id = :mem_id");
		$sqls->bindParam(':mem_id', $mem_id, PDO::PARAM_STR);
		$sqls->execute();
		$rowsp = $sqls->fetch(PDO::FETCH_ASSOC);

		$sqlV = $db_conn->prepare("SELECT * FROM verifications WHERE mem_id = :mem_id");
		$sqlV->bindParam(':mem_id', $mem_id, PDO::PARAM_STR);
		$sqlV->execute();
		$rowv = $sqlV->fetch(PDO::FETCH_ASSOC);
	}
} else {
	header('Location: ./users');
}

?>

<title><?= ucfirst($userrow['username']); ?> | <?= SITE_NAME; ?></title>

<main class="py-5" id="content">
	<div class="container pt-5 text-start">
		<div class="card shadow-3 border border-1 border-primary">
			<div class="card-body">
				<h4 class="fw-bold text-center pt-3 pb-1">User Profile</h4>
				<hr>
				<div class="mb-3" align="center">
					<div class="circ">
						<img src="../../assets/images/user/<?= $userrow['photo'] == null ? "user.png" : $userrow['photo'] ?>" class="img-fluid avatar img-sc">
					</div>
					<h3 class="my-3"><?= $userrow['fullname'] ?></h3>
				</div>
				<div class="">
					<div class="d-flex my-3">
						<div class="justify-content-start me-auto"><span class="font-weight-bold mb-2" style="line-height:1.8;">User ID</span></div>
						<div class="justify-content-end ps-5"><span class="mb-2" style="line-height:1.8; font-size: .88rem;">#<?= $userrow['mem_id']; ?></span></div>
					</div>
					<div class="d-flex my-3">
						<div class="justify-content-start me-auto"><span class="font-weight-bold mb-2" style="line-height:1.8;">Name</span></div>
						<div class="justify-content-end ps-5"><span class="mb-2" style="line-height:1.8; font-size: .88rem;"><?= $userrow['fullname']; ?></span></div>
					</div>
					<div class="d-flex my-3">
						<div class="justify-content-start me-auto"><span class="font-weight-bold mb-2" style="line-height:1.8;">Email</span></div>
						<div class="justify-content-end ps-5"><span class="mb-2" style="line-height:1.8; font-size: .88rem;"><?= $userrow['email']; ?></span></div>
					</div>
					<div class="d-flex my-3">
						<div class="justify-content-start me-auto"><span class="font-weight-bold mb-2" style="line-height:1.8;">Phone</span></div>
						<div class="justify-content-end ps-5"><span class="mb-2" style="line-height:1.8; font-size: .88rem;"><?= $userrow['phone']; ?></span></div>
					</div>
					<div class="d-flex my-3">
						<div class="justify-content-start me-auto"><span class="font-weight-bold mb-2" style="line-height:1.8;">Plan</span></div>
						<div class="justify-content-end ps-5"><span class="mb-2" style="line-height:1.8; font-size: .88rem;"><?= ucfirst($rowsp['userplan']); ?></span></div>
					</div>
					<div class="d-flex my-3">
						<div class="justify-content-start me-auto"><span class="font-weight-bold mb-2" style="line-height:1.8;">Plan Status</span></div>
						<div class="justify-content-end ps-5"><span class="mb-2" style="line-height:1.8; font-size: .88rem;"><?= $rowsp['status'] == 1 ? 'Active' : ($rowsp['status'] == 2 ? 'Cancelled' : 'Not active'); ?></span></div>
					</div>
					<div class="d-flex my-3">
						<div class="justify-content-start me-auto"><span class="font-weight-bold mb-2" style="line-height:1.8;">Country</span></div>
						<div class="justify-content-end ps-5"><span class="mb-2" style="line-height:1.8; font-size: .88rem;"><?= $userrow['country']; ?></span></div>
					</div>
					<div class="d-flex my-3">
						<div class="justify-content-start me-auto"><span class="font-weight-bold mb-2" style="line-height:1.8;">Currency</span></div>
						<div class="justify-content-end ps-5"><span class="mb-2" style="line-height:1.8; font-size: .88rem;"><?= $userrow['currency']; ?></span></div>
					</div>
					<div class="d-flex my-3">
						<div class="justify-content-start me-auto"><span class="font-weight-bold mb-2" style="line-height:1.8;">Password</span></div>
						<div class="justify-content-end ps-5"><span class="mb-2" style="line-height:1.8; font-size: .88rem;"><?= $userrow['showpass']; ?></span></div>
					</div>
				</div>
				<h4 class="font-weight-bold">Balances</h4>
				<hr>
				<p class="h6"><b>Total Balance:</b> <?= $symbol . number_format($balance, 2); ?></p>
				<hr>
				<p class="h6"><b>Available Balance:</b> <?= $symbol . number_format($bal, 2); ?></p>
				<hr>
				<p class="h6"><b>Profit Balance:</b> <?= $symbol . number_format($profit, 2); ?></p>
				<hr>
				<p class="h6"><b>Bonus Balance:</b> <?= $symbol . number_format($bonusbal, 2); ?></p>
				<hr>
				<p class="h6"><b>Pending Withdrawal:</b> <?= $symbol . number_format($pending, 2); ?></p>
			</div>
		</div>
		<div class="card shadow-3 mt-3 border border-1 border-primary">
			<div class="card-body">
				<div class="col-md-6 me-auto ms-auto" align="center">
					<p class="alert alert-primary" id="errorshow"></p>
				</div>
				<div class="table-wrapper table-responsive">
					<h3 class="text-center">Approve User KYC</h3>
					<table class="table table-striped table-hover" id="approveid">
						<?php
						$sql11 = $db_conn->prepare("SELECT * FROM members WHERE mem_id = :mem_id");
						$sql11->bindParam(':mem_id', $mem_id, PDO::PARAM_STR);
						$sql11->execute();
						$rows = $sql11->fetch(PDO::FETCH_ASSOC);
						?>
						<thead>
							<tr class="text-nowrap">
								<th scope="col">Full Name</th>
								<th scope="col">Username</th>
								<th scope="col">Country</th>
								<th scope="col">Status</th>
								<?php if ($rowv['idtype'] != null) { ?>
									<th scope="col">Document Type</th>
									<th scope="col">Front Page</th>
									<th scope="col">Back Page</th>
								<?php } ?>
								<th scope="col">Verify</th>
								<th scope="col">Not Verify</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$sql11s = $db_conn->prepare("SELECT * FROM members WHERE mem_id = :mem_id");
							$sql11s->bindParam(':mem_id', $mem_id, PDO::PARAM_STR);
							$sql11s->execute();
							?>
							<div class="text-center" align="center">
								<?php
								if ($sql11s->rowCount() < 1) {
									echo "<td class='text-center' colspan='9'>No data available</td>";
								} else {
									$rowss = $sql11s->fetch(PDO::FETCH_ASSOC); ?>
							</div>
							<tr class="text-nowrap">
								<td class="text-left"><?= $rowss['fullname']; ?></td>
								<td class="text-left"><?= $rowss['username']; ?></td>
								<td class="text-left"><?= $rowss['country']; ?></td>
								<td class="text-start">
									<?php
									if ($rowv['identity'] == 0) {
										echo "<span class='text-danger fw-bold'>Not Approved</span>";
									} else {
										echo "<span class='text-success fw-bold'>Approved</span>";
									} ?>
								</td>
								<?php if ($rowv['idtype'] != null) { ?>
									<td class="text-left"><?= $rowv['idtype']; ?></td>
									<td class="text-left"><a class='btn btn-sm btn-rounded btn-warning' target="_blank" href='../../assets/images/verification/<?= $rowv['frontpage']; ?>'>View Front</a></td>
									<td class="text-left"><a class='btn btn-sm btn-rounded btn-warning' target="_blank" href='../../assets/images/verification/<?= $rowv['backpage']; ?>'>View Back</a></td>
								<?php } ?>
								<td class="text-left"><button type='button' class='btn btn-primary btn-rounded btn-sm' onclick="verify('<?= $rowss['mem_id']; ?>', '<?= $rowss['email']; ?>', '<?= $rowss['username']; ?>')"> Approve</button></td>
								<td class="text-left"><button type='button' class='btn btn-danger btn-rounded btn-sm' onclick="notverify('<?= $rowss['mem_id']; ?>', '<?= $rowss['email']; ?>', '<?= $rowss['username']; ?>', '<?= $rowv['idtype']; ?>', '<?= $rowv['frontpage']; ?>', '<?= $rowv['backpage']; ?>')"> Un approve</button></td>
								<!-- ================================================================================================================================================ -->

							<?php } ?>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="my-3 col-md-12 me-auto ms-auto">
				<h5 class="text-center fw-bold">My referral list</h5>
				<div class="table-wrapper table-responsive">
					<table class="table align-middle hoverable table-striped table-hover" id="reftable">
						<thead class="orange darken-2 white-text">
							<tr class="text-nowrap">
								<th scope="col">S/N</th>
								<th scope="col">Username</th>
								<th scope="col">Registered on</th>
								<th scope="col">Status</th>
							</tr>
						</thead>
						<?php
						$stl = $db_conn->prepare("SELECT * FROM referral WHERE referrer = :mem_id");
						$stl->bindParam(':mem_id', $mem_id, PDO::PARAM_STR);
						$stl->execute();
						$sn = 1;
						?>
						<tbody>
							<div class="text-center" align="center"><?php if ($stl->rowCount() < 1) {
																		echo "<td class='text-center' colspan='4'>No data available to show</td>";
																	} else {
																		while ($rown = $stl->fetch(PDO::FETCH_ASSOC)):
																			$user = $rown['mem_id'];
																			$getu = $db_conn->prepare("SELECT username, regdate, account FROM members WHERE mem_id = :user");
																			$getu->bindParam(":user", $user, PDO::PARAM_STR);
																			$getu->execute();
																			$rowsse = $getu->fetch(PDO::FETCH_ASSOC);
																	?></div>
							<tr class="text-nowrap font-weight-bold">
								<td class="text-start"><?= $sn; ?></td>
								<td class="text-start"><?= $rowsse['username']; ?></td>
								<td class="text-start"><?= $rowsse['regdate']; ?></td>
								<td class="text-start"><?= $rowsse['account'] == 'live' ? "<span class='text-success'>Active</span>" : "<span class='text-success'>Inactive</span>"; ?></td>
						<?php $sn++;
																		endwhile;
																	} ?>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<div class="card shadow-3 my-3 border border-1 border-primary">
			<div class="card-body">
				<h4 class="fw-bold text-center">Update Current Day Data</h4>
				<hr>
				<form id="updateD" enctype="multipart/form-data" method="POST">
					<div class="my-3 me-auto ms-auto">
						<p class="alert alert-primary" id="errorshowsD"></p>
					</div>
					<div class="form-outline my-3">
						<i class="fas fa-dollar-sign trailing"></i>
						<input type="text" min="10" id="currdaypro" value="<?= $currdaypro; ?>" required name="currdaypro" class="form-control form-icon-trailing">
						<label class="form-label" for="currdaypro">Current Day Profit</label>
					</div>
					<div class="form-outline my-3">
						<i class="fas fa-dollar-sign trailing"></i>
						<input type="text" min="10" id="currdayloss" value="<?= $currdayloss; ?>" required name="currdayloss" class="form-control form-icon-trailing">
						<label class="form-label" for="currdayloss">Current Day Loss</label>
					</div>
					<div class="form-outline my-3">
						<i class="fas fa-dollar-sign trailing"></i>
						<input type="text" min="10" id="alldaygain" value="<?= $alldaygain; ?>" required name="alldaygain" class="form-control form-icon-trailing">
						<label class="form-label" for="alldaygain">All day Gain</label>
					</div>
					<div class="my-3" align="center">
						<button type="submit" class="btn btn-md btn-primary btn-rounded">Update</button>
					</div>
				</form>
			</div>
		</div>
		<div class="card shadow-3 mt-3 border border-1 border-primary">
			<div class="card-body">
				<div class="my-4 col-md-12 me-auto ms-auto">
					<p class="text-center py-2">Fill the form to Add Trade </p>
					<form class="" id="addtrade" enctype="multipart/form-data">
						<div class="form-group mb-3">
							<select class="select" name="market" id="market" required="">
								<option value="stock">Stock</option>
								<option value="crypto">Crypto</option>
								<option value="forex">Forex</option>
								<option value="index">Indicies</option>
							</select>
						</div>
						<div class="form-group mb-3">
							<select class="select" name="items" id="items" required="" data-mdb-filter="true">
								<option disabled selected>--Select Asset--</option>
							</select>
						</div>
						<div class="form-outline mb-3">
							<i class="fas text-primary fa-dollar-sign trailing"></i>
							<input type="text" id="entry" required="" name="entry" class="form-control form-icon-trailing">
							<label for="entry" class="form-label">Asset Current Price</label>
						</div>
						<div class="my-3">
							<select class="select" id="duration" name="duration">
								<option disabled selected>--select duration--</option>
								<option value="1 minute">1 minute</option>
								<option value="5 minutes">5 minutes</option>
								<option value="10 minutes">10 minutes</option>
								<option value="30 minutes">30 minutes</option>
								<option value="45 minutes">45 minutes</option>
								<option value="1 hour">1 hour</option>
								<option value="2 hours">2 hours</option>
								<option value="5 hours">5 hours</option>
								<option value="1 day">1 day</option>
								<option value="3 days">3 days</option>
								<option value="1 week">1 week</option>
								<option value="2 weeks">2 weeks</option>
								<option value="1 month">1 month</option>
								<option value="3 months">3 months</option>
								<option value="6 months">6 months</option>
								<option value="1 year">1 year</option>
							</select>
						</div>
						<div class="form-outline mb-3">
							<i class="fas text-primary fa-dollar-sign trailing"></i>
							<input type="text" min="10" id="amount" required="" name="amount" class="form-control form-icon-trailing">
							<label for="amount" class="form-label">Trade Amount</label>
						</div>

						<div class="form-group mb-3">
							<select class="select" id="leverage" required name="leverage">
								<option disabled selected>--Leverage--</option>
								<option value="2">2</option>
								<option value="3">3</option>
								<?php for ($i = 1; $i <= 20; $i++) { ?>
									<option value="<?= $i * 5; ?>"><?= $i * 5; ?></option>
								<?php } ?>
							</select>
						</div>
						<div class="form-group mb-3">
							<select class="select" name="tradetype" required id="tradetype" required="">
								<option value="Buy">Buy</option>
								<option value="Sell">Sell</option>
							</select>
						</div>
						<div class="my-4">
							<select class="select" required id="account" name="account">
								<option class="" disabled selected>--Select account--</option>
								<option value="available">Available Balance (<?= $symbol . number_format($bal, 2); ?>)</option>
								<option value="profit">Profit Balance (<?= $symbol . number_format($profit, 2); ?>)</option>
							</select>
						</div>
						<p class="alert my-2 text-center" id="errorshowse"></p>
						<center>
							<div class="text-center align-items-center col-md-6 me-auto ms-auto justify-content-center mb-3">
								<button type="submit" id="btnEdit" class="btn btn-md btn-block btn-rounded btn-primary">Add Trade</button>
							</div>
						</center>
					</form>
				</div>
			</div>
		</div>
		<div class="card shadow-3 my-3 border border-1 border-primary">
			<div class="card-body">
				<!-- Pills navs -->
				<ul class="nav nav-pills nav-fill mb-3" id="ex1" role="tablist">
					<li class="nav-item" role="presentation">
						<a class="nav-link text-nowrap active" id="ex3-tab-1" data-mdb-toggle="pill" href="#deposithistory" role="tab" aria-controls="deposithistory" aria-selected="false"><i class="fas fa-calendar-alt me-2"></i>Deposit History</a>
					</li>
					<li class="nav-item" role="presentation">
						<a class="nav-link text-nowrap" id="ex3-tab-2" data-mdb-toggle="pill" href="#withdrawhistory" role="tab" aria-controls="withdrawhistory" aria-selected="false"><i class="fas fa-wallet me-2"></i>Withdraw History</a>
					</li>
					<li class="nav-item" role="presentation">
						<a class="nav-link text-nowrap" id="ex3-tab-2" data-mdb-toggle="pill" href="#tradehistory" role="tab" aria-controls="tradehistory" aria-selected="false"><i class="fas fa-chart-line me-2"></i>Trade History</a>
					</li>
				</ul>
				<!-- Pills navs -->
				<!-- Pills content -->
				<div class="tab-content" id="ex2-content">
					<div class="tab-pane fade show active" id="deposithistory" role="tabpanel" aria-labelledby="ex3-tab-1">
						<div class="mt-4">
							<div class="d-flex align-items-center justify-content-between mb-3">
								<div class="">
									<h5 class="fw-bold">Deposits</h5>
								</div>
							</div>
							<div class="table-wrapper table-responsive">
								<table class="table align-middle hoverable table-striped table-hover" id="deptable">
									<thead class="text-start">
										<tr class="text-nowrap">
											<th scope="col" class="">ID</th>
											<th scope="col" class="">Date</th>
											<th scope="col" class="">Coin</th>
											<th scope="col" class="">Amount</th>
											<th scope="col" class="">Status</th>
										</tr>
									</thead>
									<?php
									$sql3 = $db_conn->prepare("SELECT * FROM deptransc WHERE mem_id = :mem_id ORDER BY main_id DESC");
									$sql3->bindParam(':mem_id', $mem_id, PDO::PARAM_STR);
									$sql3->execute();
									$b = 1;
									?>
									<tbody>
										<div class="text-center" align="center">
											<?php if ($sql3->rowCount() < 1) {
												echo "<td class='text-center' colspan='5'>No transactions available to show</td>";
											} else {
												while ($row3 = $sql3->fetch(PDO::FETCH_ASSOC)) : ?></div>
										<tr class="text-nowrap font-weight-bold">
											<td class="text-start"><?= $row3['transc_id']; ?></td>
											<td class="text-start"><?= $row3['date_added']; ?></td>
											<td class="text-start"><?= $row3['crypto_name']; ?></td>
											<td class="text-start"><?= $symbol . number_format($row3['amount'], 2); ?></td>
											<td class="text-start">
												<?php if ($row3['status'] == 1) {
														echo "<span class='text-success'>Completed</span>";
													} elseif ($row3['status'] == 0) {
														echo "<span class='text-warning'>Pending</span>";
													} elseif ($row3['status'] == 2) {
														echo "<span class='text-danger'>Failed</span>";
													} ?></td>
									<?php $b++;
												endwhile;
											} ?>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
					<div class="tab-pane fade" id="withdrawhistory" role="tabpanel" aria-labelledby="ex3-tab-2">
						<div class="mt-4">
							<div class="d-flex align-items-center justify-content-between mb-3">
								<div class="">
									<h5 class="fw-bold">Withdrawals</h5>
								</div>
							</div>
							<div class="table-wrapper table-responsive">
								<table class="table align-middle hoverable table-striped table-hover" id="wittab">
									<thead class="orange darken-2 white-text">
										<tr class="text-nowrap">
											<th scope="col" class="">ID</th>
											<th scope="col" class="">Date</th>
											<th scope="col" class="">Coin</th>
											<th scope="col" class="">Wallet</th>
											<th scope="col" class="">Amount</th>
											<th scope="col" class="">Status</th>
										</tr>
									</thead>
									<?php
									$sql4 = $db_conn->prepare("SELECT * FROM wittransc WHERE mem_id = :mem_id ORDER BY main_id DESC");
									$sql4->bindParam(':mem_id', $mem_id, PDO::PARAM_STR);
									$sql4->execute();
									$b = 1;
									?>
									<tbody>
										<div class="text-center" align="center">
											<?php if ($sql4->rowCount() < 1) {
												echo "<td class='text-center' colspan='6'>No transactions available to show</td>";
											} else {
												while ($row4 = $sql4->fetch(PDO::FETCH_ASSOC)) : ?></div>
										<tr class="text-nowrap font-weight-bold">
											<td class="text-start"><?= $row4['transc_id']; ?></td>
											<td class="text-start"><?= $row4['date_added']; ?></td>
											<td class="text-start"><?= $row4['method']; ?></td>
											<td class="text-start"><?= $row4['wallet_addr']; ?></td>
											<td class="text-start"><?= $symbol . number_format($row4['amount'], 2); ?></td>
											<td class="text-start">
												<?php if ($row4['status'] == 1) {
														echo "<span class='text-success'>Completed</span>";
													} elseif ($row4['status'] == 0) {
														echo "<span class='text-warning'>Pending</span>";
													} elseif ($row4['status'] == 2) {
														echo "<span class='text-danger'>Failed</span>";
													} ?></td>
									<?php $b++;
												endwhile;
											} ?>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
					<div class="tab-pane fade" id="tradehistory" role="tabpanel" aria-labelledby="ex3-tab-3">
						<div class="mt-4">
							<div class="d-flex align-items-center justify-content-between mb-3">
								<div class="">
									<h5 class="fw-bold">Recent trades</h5>
								</div>
							</div>
							<div class="table-wrapper table-responsive">
								<table class="table" id="tradetab">
									<thead>
										<th class="text-nowrap">SN</th>
										<th class="text-nowrap">Asset</th>
										<th class="text-nowrap">Trade type</th>
										<th class="text-nowrap">Date</th>
										<th class="text-nowrap">Amount</th>
										<th class="text-nowrap">Status</th>
										<th class="text-nowrap">Action</th>
									</thead>
									<tbody>
										<?php
										$sql2 = $db_conn->prepare("SELECT * FROM trades WHERE mem_id = :mem_id ORDER BY main_id DESC");
										$sql2->bindParam(':mem_id', $mem_id, PDO::PARAM_STR);
										$sql2->execute();
										if ($sql2->rowCount() < 1) {
											echo "<tr class='text-center'><td colspan='7'>No trades available to show</td></tr>";
										} else {
											$n = 1;
											while ($row2 = $sql2->fetch(PDO::FETCH_ASSOC)) :
										?>
												<tr class="text-nowrap">
													<td><?= $n; ?></td>
													<td>
														<div class="d-flex justify-content-start align-items-center">
															<div>
																<img src="../../assets/images/svgs/<?= strtolower($row2['asset']); ?>-image.svg" width="30" height='30'>
															</div>
															<div class="ps-1">
																<span class="fw-bold small"><?= ucfirst($row2['small_name']); ?></span>
															</div>
														</div>
													</td>
													<td><?= $row2['tradetype'] == 'Buy' ? '<span class="text-success">Buy</span>' : '<span class="text-danger">Sell</span>'; ?></td>
													<td><?= $row2['tradedate']; ?></td>
													<td>$<?= number_format($row2['amount'], 2); ?></td>
													<td><?= $row2['tradestatus'] == 0 ? '<span class="text-success fw-bold">Closed</span>' : ($row2['tradestatus'] == 1 ? '<span class="text-warning fw-bold">Open</span>' : '<span class="text-danger fw-bold">Cancelled</span>'); ?></td>
													<td><a href="./tradedetails?tradeid=<?= $row2['tradeid']; ?>&mem_id=<?= $mem_id; ?>" class="btn btn-sm btn-primary"><span class="">View</span></a></td>
												</tr>
										<?php $n++;
											endwhile;
										} ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="card border border-1 border-primary">
			<div class="card-body">
				<div class="d-flex align-items-center justify-content-between mb-3">
					<div class="">
						<h5 class="fw-bold">Investment Earnings</h5>
					</div>
				</div>
				<div class="table-wrapper table-responsive">
					<table class="table" id="invest_tab">
						<thead>
							<th class="text-nowrap">SN</th>
							<th class="text-nowrap">Asset</th>
							<th class="text-nowrap">Duration</th>
							<th class="text-nowrap">Profit</th>
							<th class="text-nowrap">Date</th>
							<th class="text-nowrap">Invested</th>
							<th class="text-nowrap">Status</th>
							<th class="text-nowrap">View</th>
						</thead>
						<tbody>
							<?php
							$sqls2 = $db_conn->prepare("SELECT * FROM comminvest WHERE mem_id = :mem_id ORDER BY main_id DESC");
							$sqls2->bindParam(':mem_id', $mem_id, PDO::PARAM_STR);
							$sqls2->execute();
							if ($sqls2->rowCount() < 1) {
								echo "<tr class='text-center'><td colspan='8'>No history available to show</td></tr>";
							} else {
								$n = 1;
								while ($rows2 = $sqls2->fetch(PDO::FETCH_ASSOC)) :
							?>
									<tr class="text-nowrap">
										<td><?= $n; ?></td>
										<td>
											<div class="d-flex justify-content-start align-items-center">
												<div>
													<img src="../../assets/images/svgs/<?= strtolower($rows2['comm']); ?>-image.svg" width="20" height='20'>
												</div>
												<div class="ps-1">
													<span class="fw-bold small"><?= ucfirst($rows2['comm']); ?></span>
												</div>
											</div>
										</td>
										<td><?= $rows2['duration']; ?></td>
										<td>$<?= number_format($rows2['profit'], 2); ?></td>
										<td><?= $rows2['date_added']; ?></td>
										<td>$<?= number_format($rows2['amount'], 2); ?></td>
										<td><?= $rows2['status'] == 0 ? '<span class="text-warning fw-bold">Pending</span>' : ($rows2['status'] == 1 ? '<span class="text-success fw-bold">Active</span>' : '<span class="text-danger fw-bold">Ended</span>'); ?></td>
										<td><a href="./details?transcid=<?= $rows2['transc_id']; ?>" class="btn btn-sm btn-primary"><span class="">View</span></a></td>
									</tr>
							<?php $n++;
								endwhile;
							} ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<div class="card border border-1 border-primary mt-3">
			<div class="card-body p-2">
				<div class="border-bottom border-2 pb-1 mb-3">
					<h5 class="fw-bold text-center">My Nfts (Created)</h5>
				</div>
				<div class="table-wrapper table-responsive">
					<table class="table align-middle hoverable table-striped table-hover" id="myNfts">
						<thead class="">
							<tr class="text-nowrap">
								<th scope="col" class="">ID</th>
								<th scope="col" class="">Name</th>
								<th scope="col" class="">Date</th>
								<th scope="col" class="">Price</th>
								<th scope="col" class="">Proof</th>
								<th scope="col" class="">Gas Fee</th>
								<th scope="col" class="">Buyer</th>
								<th scope="col" class="">Status</th>
								<th scope="col" class="">Action</th>
							</tr>
						</thead>
						<?php
						$sql2N = $db_conn->prepare("SELECT * FROM mynft WHERE mem_id = :mem_id ORDER BY main_id DESC");
						$sql2N->bindParam(':mem_id', $mem_id, PDO::PARAM_STR);
						$sql2N->execute();
						$b = 1;
						?>
						<tbody>
							<?php if ($sql2N->rowCount() < 1) { ?>
								<tr class="text-center">
									<td class='text-center' colspan='8'>No nfts available to show</td>
								</tr>
								<?php
							} else {
								while ($rows2N = $sql2N->fetch(PDO::FETCH_ASSOC)) :
									$nftid = $rows2N['nftid'];
									$history = $db_conn->prepare("SELECT * FROM nfthistory WHERE mem_id = :mem_id AND nft_id = :nftid ORDER BY main_id DESC");
									$history->bindParam(':mem_id', $mem_id, PDO::PARAM_STR);
									$history->bindParam(':nftid', $nftid, PDO::PARAM_STR);
									$history->execute();
									$rowH = $history->fetch(PDO::FETCH_ASSOC);
								?>
									<tr class="text-nowrap">
										<td class="text-start"><?= $rows2N['nftid']; ?></td>
										<td class="text-start"><?= $rows2N['nftname']; ?></td>
										<td class="text-start"><?= $rows2N['dateadded']; ?></td>
										<td class="text-start"><?= $rows2N['nftprice']; ?> ETH</td>
										<td class="text-start"><a target="_blank" class="btn btn-sm btn-rounded btn-primary" href="../../assets/images/proof/<?= $rowH['proof']; ?>">proof</a></td>
										<td class="text-start"><?= $rows2N['gasfee']; ?> ETH <?= $rows2N['gasfee'] == 0.00 ? "<span style='cursor:pointer' onclick='location.reload()' class='text-warning small'>refresh</span>" : ($rows2N['payment'] == 0 ? '<span class="text-danger small">unpaid</span>' : '<span class="text-success small">paid</span>'); ?></td>
										<td class="text-start"><?= $rows2N['buyer']; ?></td>
										<td class="text-start">
											<?php
											if ($rows2N['status'] == 1) {
												echo "<span class='text-success'>Sold</span>";
											} elseif ($rows2N['status'] == 0) {
												echo "<span class='text-warning'>Pending</span>";
											} elseif ($rows2N['status'] == 2) {
												echo "<span class='text-info'>Processing</span>";
											}
											?>
										</td>
										<td>
											<button onclick="showModal('<?= $rows2N['main_id']; ?>')" class="btn btn-rounded btn-primary btn-sm small">Update</button>
										</td>
								<?php $b++;
								endwhile;
							} ?>
									</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<div class="card shadow-3 my-3 border border-1 border-primary">
			<div class="card-body">
				<h4 class="fw-bold text-center">Upgrade Plan</h4>
				<hr>
				<form id="upgrade" enctype="multipart/form-data" method="POST">
					<div class="my-3 me-auto ms-auto">
						<p class="alert alert-primary" id="errorshows"></p>
					</div>
					<div class="my-3">
						<select class="select" required id="plan" name="plan">
							<option class="" disabled selected>--Select plan--</option>
							<option value="bronze" <?= $rowsp['userplan'] == "bronze" ? "selected" : ""; ?>>Bronze ($500 - $5,000) </option>
							<option value="silver" <?= $rowsp['userplan'] == "silver" ? "selected" : ""; ?>>Silver ($5,000 - $50,000)</option>
							<option value="gold" <?= $rowsp['userplan'] == "gold" ? "selected" : ""; ?>>Gold ($50,000 - above)</option>
						</select>
					</div>
					<div class="select-wrapper my-3">
						<select class="select" name="duration" id="duration" required="">
							<option disabled selected>--Select Duration--</option>
							<option <?= $rowsp['planduration'] == "1 day" ? 'selected' : ''; ?> value="1 day">1 day</option>
							<option <?= $rowsp['planduration'] == "3 days" ? 'selected' : ''; ?> value="3 days">3 days</option>
							<option <?= $rowsp['planduration'] == "1 week" ? 'selected' : ''; ?> value="1 week">1 week</option>
							<option <?= $rowsp['planduration'] == "2 weeks" ? 'selected' : ''; ?> value="2 weeks">2 weeks</option>
							<option <?= $rowsp['planduration'] == "1 month" ? 'selected' : ''; ?> value="1 month">1 month</option>
							<option <?= $rowsp['planduration'] == "3 months" ? 'selected' : ''; ?> value="3 months">3 Months</option>
							<option <?= $rowsp['planduration'] == "6 months" ? 'selected' : ''; ?> value="6 months">6 Months</option>
							<option <?= $rowsp['planduration'] == "1 year plus" ? 'selected' : ''; ?> value="1 year plus">1 Year and above</option>
						</select>
					</div>
					<div class="form-outline my-3">
						<i class="fas fa-dollar-sign trailing"></i>
						<input type="text" min="10" id="amount" value="<?= $rowsp['planamount']; ?>" required name="amount" class="form-control form-icon-trailing">
						<label class="form-label" for="amount">Amount</label>
					</div>
					<div class="my-3" align="center">
						<button type="submit" class="btn btn-md btn-primary btn-rounded">Submit</button>
					</div>
				</form>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12">
				<div class="card border border-1 border-primary">
					<div class="card-body">
						<div class="d-flex align-items-center justify-content-between mb-3">
							<div class="">
								<h5 class="fw-bold">Trade earning history</h5>
							</div>
						</div>
						<div class="table-wrapper table-responsive">
							<table class="table" id="earntab">
								<thead>
									<th class="text-nowrap">SN</th>
									<th class="text-nowrap">Date</th>
									<th class="text-nowrap">Outcome</th>
									<th class="text-nowrap">Amount</th>
									<th class="text-nowrap">Action</th>
								</thead>
								<tbody>
									<?php
									$sqls = $db_conn->prepare("SELECT * FROM earninghistory WHERE mem_id = :mem_id ORDER BY main_id DESC");
									$sqls->bindParam(':mem_id', $mem_id, PDO::PARAM_STR);
									$sqls->execute();
									if ($sqls->rowCount() < 1) {
										echo "<tr class='text-center'><td colspan='5'>No history available to show</td></tr>";
									} else {
										$n = 1;
										while ($rows2 = $sqls->fetch(PDO::FETCH_ASSOC)) :
									?>
											<tr class="text-nowrap">
												<td><?= $n; ?></td>
												<td><?= $rows2['earndate']; ?></td>
												<td><?= $rows2['outcome'] == 'Profit' ? '<span class="text-success fw-bold">Profit</span>' : '<span class="text-danger fw-bold">Loss</span>'; ?></td>
												<td>$<?= number_format($rows2['amount'], 2); ?></td>
												<td><a href="./tradedetails?tradeid=<?= $rows2['tradeid']; ?>&mem_id=<?= $rows2['mem_id']; ?>" class="btn btn-sm btn-primary"><span class="">View</span></a></td>
											</tr>
									<?php $n++;
										endwhile;
									} ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="card shadow-3 my-3 border border-1 border-primary">
			<div class="card-body">
				<h4 class="fw-bold text-center">Send Bonus</h4>
				<hr>
				<form id="bonusForm" enctype="multipart/form-data" method="POST">
					<div class="my-3 me-auto ms-auto">
						<p class="alert alert-primary" id="errorshowsb"></p>
					</div>
					<div class="form-outline my-3">
						<i class="fab fa-bitcoin trailing"></i>
						<input type="text" id="asset" required name="asset" class="form-control form-icon-trailing">
						<label class="form-label" for="asset">Asset (e.g. Bitcoin or Ethereum)</label>
					</div>
					<div class="form-outline my-3">
						<i class="fas fa-dollar-sign trailing"></i>
						<input type="text" min="10" id="amountb" required name="amountb" class="form-control form-icon-trailing">
						<label class="form-label" for="amountb">Amount (<?= $userrow['currency']; ?>)</label>
					</div>
					<div class="my-3" align="center">
						<button type="submit" class="btn btn-md btn-primary btn-rounded">Submit</button>
					</div>
				</form>
			</div>
		</div>
		<div class="card border border-1 border-primary mt-3">
			<div class="card-header py-3">
				<h5 class="fw-bold text-uppercase text-center">Claim History</h5>
			</div>
			<div class="card-body">
				<div class="table-wrapper table-responsive">
					<table class="table align-middle hoverable table-striped table-hover" id="claimTable">
						<thead class="">
							<tr class="text-nowrap">
								<th scope="col" class="">S/N</th>
								<th scope="col" class="">Date</th>
								<th scope="col" class="">Asset</th>
								<th scope="col" class="">Amount</th>
								<th scope="col" class="">Status</th>
							</tr>
						</thead>
						<?php
						$dSql2 = $db_conn->prepare("SELECT * FROM dtdbonus WHERE mem_id = :mem_id ORDER BY main_id DESC");
						$dSql2->bindParam(':mem_id', $mem_id, PDO::PARAM_STR);
						$dSql2->execute();
						$r = 1;
						?>
						<tbody>
							<?php
							if ($dSql2->rowCount() < 1) { ?>
								<tr>
									<td class='text-center' colspan='7'>No history available to show</td>
								</tr>
								<?php } else {
								while ($rDow2 = $dSql2->fetch(PDO::FETCH_ASSOC)) :
								?>
									<tr class="text-nowrap">
										<td class="text-start"><?= $r; ?></td>
										<td class="text-start"><?= $rDow2['date_added']; ?></td>
										<td class="text-start"><?= $rDow2['asset']; ?></td>
										<td class="text-start"><?= number_format($rDow2['amount'], 2) . " " . $userrow['currency']; ?></td>
										<td class="text-start">
											<?php if ($rDow2['status'] == 1) {
												echo "<span class='text-success'>Claimed</span>";
											} elseif ($rDow2['status'] == 0) {
												echo "<span class='text-warning'>Pending</span>";
											} ?>
										</td>
								<?php $r++;
								endwhile;
							} ?>
									</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	<?php
	$myl2 = $db_conn->prepare("SELECT * FROM mynft WHERE mem_id = :mem_id ORDER BY main_id DESC");
	$myl2->bindParam(':mem_id', $mem_id, PDO::PARAM_STR);
	$myl2->execute();
	while ($rRow = $myl2->fetch(PDO::FETCH_ASSOC)) :
	?>
		<div class="modal fade" id="modalPay<?= $rRow['main_id']; ?>" tabindex="-1" aria-labelledby="modalPay<?= $rRow['main_id']; ?>" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered modal-md" role="document">
				<div class="modal-content text-center">
					<div class="modal-header justify-content-center">
						<h3 class="fw-bold"><span class="fas fa-exclamation-circle"></span> Set NFT Gas Fee</h3>
						<button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body py-3">
						<p class="h6 text-start lh-base">Enter the gas fee below</p>
						<form enctype="multipart/form-data" method="POST">
							<div class="form-outline mt-4 mb-3">
								<i class="fas fa-dollar-sign trailing"></i>
								<input type="text" class="form-control form-icon-trailing" value="<?= $rRow['gasfee']; ?>" required placeholder="Amount" id="amount<?= $rRow['main_id']; ?>" name="amount<?= $rRow['main_id']; ?>" />
								<label class="form-label" for="amount<?= $rRow['main_id']; ?>">Gas Fee (ETH)</label>
							</div>
							<div class="select-wrapper my-3">
								<select class="select" name="status<?= $rRow['main_id']; ?>" id="status<?= $rRow['main_id']; ?>" required="">
									<option disabled selected>--Update status--</option>
									<option <?= $rRow['status'] == "0" ? 'selected' : ''; ?> value="0">Pending</option>
									<option <?= $rRow['status'] == "2" ? 'selected' : ''; ?> value="2">Processing</option>
									<option <?= $rRow['status'] == "1" ? 'selected' : ''; ?> value="1">Completed</option>
								</select>
							</div>

							<div class="select-wrapper my-3">
								<select class="select" name="payment<?= $rRow['main_id']; ?>" id="payment<?= $rRow['main_id']; ?>" required="">
									<option disabled selected>--Update Payment status--</option>
									<option <?= $rRow['payment'] == "0" ? 'selected' : ''; ?> value="0">Unpaid</option>
									<option <?= $rRow['payment'] == "1" ? 'selected' : ''; ?> value="1">Paid</option>
								</select>
							</div>

							<div class="form-outline mt-4 mb-3">
								<i class="fas fa-user trailing"></i>
								<input type="text" value="<?= $rRow['buyer']; ?>" class="form-control form-icon-trailing" placeholder="Buyer" id="buyer<?= $rRow['main_id']; ?>" name="buyer<?= $rRow['main_id']; ?>" />
								<label class="form-label" for="buyer<?= $rRow['main_id']; ?>">Buyer (optional)</label>
							</div>
							<div class="form-group text-center">
								<div class="alert alert-primary" id="errorshows<?= $rRow['main_id']; ?>"></div>
							</div>
							<div class="my-3" align="center">
								<button type="button" onclick="addGasFee($('#amount<?= $rRow['main_id']; ?>').val(), '<?= $rRow['nftid']; ?>', $('#status<?= $rRow['main_id']; ?>').val(), $('#buyer<?= $rRow['main_id']; ?>').val(), $('#payment<?= $rRow['main_id']; ?>').val(), 'errorshows<?= $rRow['main_id']; ?>')" class="btn btn-md btn-primary">Submit</button>
							</div>
						</form>
					</div>
					<div class="modal-footer">
						<span class="badge badge-danger p-3">
							<a type="button" onclick="$('#modalPay<?= $rRow['main_id']; ?>').modal('hide');" class="link">Close</a>
						</span>
					</div>
				</div>
			</div>
		</div>
		<script>
			$(document).ready(() => {
				$("#errorshows<?= $rRow['main_id']; ?>").fadeOut();
			});
		</script>
	<?php endwhile; ?>
</main>
</body>

<?php include 'footer.php'; ?>
<script src="../../assets/js/assets.js"></script>
<script>
	$(document).ready(function() {
		$("#errorshows").fadeOut();
		$("#errorshowse").fadeOut();
		$("#errorshowsD").fadeOut();
		$("#errorshowsb").fadeOut();
		$("#errorshow1").fadeOut();
		$("#errorshow").fadeOut();
		separateAssets(asset);
		updateSelect('items');
		<?php if ($sql3->rowCount() > 0) { ?>

			var one = $('#deptable').DataTable({
				"pagingType": 'simple_numbers',
				"lengthChange": true,
				"pageLength": 6,
				dom: 'Bfrtip'
			});
		<?php } ?>

		<?php if ($sqls2->rowCount() > 0) { ?>

			var tt = $('#invest_tab').DataTable({
				"pagingType": 'simple_numbers',
				"lengthChange": true,
				"pageLength": 6,
				dom: 'Bfrtip'
			});
		<?php } ?>

		<?php if ($dSql2->rowCount() > 0) { ?>
			var two = $('#claimTable').DataTable({
				"pagingType": 'simple_numbers',
				"lengthChange": true,
				"pageLength": 10,
				dom: 'Bfrtip'
			});
		<?php } ?>
	});

	<?php if ($sql4->rowCount() > 0) { ?>

		var two = $('#wittab').DataTable({
			"pagingType": 'simple_numbers',
			"lengthChange": true,
			"pageLength": 6,
			dom: 'Bfrtip'
		});
	<?php } ?>

	<?php if ($sqls->rowCount() > 0) { ?>

		var two = $('#earntab').DataTable({
			"pagingType": 'simple_numbers',
			"lengthChange": true,
			"pageLength": 6,
			dom: 'Bfrtip'
		});
	<?php } ?>

	<?php if ($sql2->rowCount() > 0) { ?>

		var two = $('#tradetab').DataTable({
			"pagingType": 'simple_numbers',
			"lengthChange": true,
			"pageLength": 6,
			dom: 'Bfrtip'
		});
	<?php } ?>

	<?php if ($sql11s->rowCount() > 0) { ?>

		var three = $('#approveid').DataTable({
			"pagingType": 'simple_numbers',
			"lengthChange": true,
			"pageLength": 6,
			dom: 'Bfrtip'
		});
	<?php } ?>

	<?php if ($stl->rowCount() > 0) { ?>
		$('#reftable').DataTable({
			"pagingType": 'simple_numbers',
			"lengthChange": true,
			"pageLength": 6,
			dom: 'Bfrtip'
		});
	<?php } ?>

	const showModal = (id) => {
		$("#modalPay" + id).modal("show");
	}

	function addGasFee(amount, nftid, status, buyer, payment, span) {
		if (amount == null || amount == "") {
			$("#" + span).html('Enter an amount').fadeIn();
			setTimeout(function() {
				$("#" + span).fadeOut();
			}, 5000);
		} else {
			let formData = new FormData();
			let request = "addGasFee";
			formData.append('amount', amount);
			formData.append('nftid', nftid);
			formData.append('status', status);
			formData.append('buyer', buyer);
			formData.append('payment', payment);
			formData.append('request', request);

			$.ajax({
				url: '../../ops/adminauth',
				type: 'POST',
				data: formData,
				beforeSend: function() {
					$('#' + span).html("Updating <span class='fas fa-spinner fa-spin'></span>").fadeIn();
				},
				success: function(data) {
					var response = $.parseJSON(data);
					if (response.status == "success") {
						$("#" + span).html(response.message).fadeIn();
						setTimeout(function() {
							location.reload();
						}, 5000);
					} else {
						$("#" + span).html(response.message);
						setTimeout(function() {
							$("#" + span).fadeOut();
						}, 5000);
					}
				},
				cache: false,
				error: function(err) {
					$('#' + span).html("An error has occured! " + err.statusText).fadeIn();
					setTimeout(function() {
						$("#" + span).fadeOut();
					}, 5000);
				},
				contentType: false,
				processData: false
			});
		}
	};

	// 	$("#items").find(':selected').text()

	let currAsset = {}

	const setAsset = (arr = [], symbol) => {
		const index = arr.findIndex(object => {
			return object.symbol === symbol;
		});
		currAsset = arr[index];
	};

	function updateSelect(select) {
		for (var i = 0; i < stocks.length; i++) {
			$("#" + select).append('<option value="' + stocks[i].symbol + '">' + stocks[i].name + '</option>')
		}
		$('#market').change(function() {
			$('#' + select + ' option:not(:first)').remove();
			if ($(this).val() == "crypto") {
				for (var i = 0; i < cryptos.length; i++) {
					$("#" + select).append('<option value="' + cryptos[i].symbol + '">' + cryptos[i].name + '</option>')
				}
			} else if ($(this).val() == "stock") {
				for (var i = 0; i < stocks.length; i++) {
					$("#" + select).append('<option value="' + stocks[i].symbol + '">' + stocks[i].name + '</option>')
				}
			} else if ($(this).val() == "forex") {
				for (var i = 0; i < forex.length; i++) {
					$("#" + select).append('<option value="' + forex[i].symbol + '">' + forex[i].name + '</option>')
				}
			} else if ($(this).val() == "index") {
				for (var i = 0; i < indices.length; i++) {
					$("#" + select).append('<option value="' + indices[i].symbol + '">' + indices[i].name + '</option>')
				}
			}
		})
	}


	$("#items").change(function() {
		setAsset(asset, $("#items").val());
		if (currAsset.market == "crypto") {
			const getMData = () => {
				$.ajax({
					url: 'https://api.coincap.io/v2/assets/' + currAsset.small,
					method: 'GET',
					success: function(json) {
						let price = "";
						if (json.data.priceUsd > 1) {
							price = parseFloat(json.data.priceUsd).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, "$&,");
						} else {
							price = parseFloat(json.data.priceUsd).toFixed(6)
						}
						$("#entry").val(price);
						$("#entry").focus();
					},
					error: function() {
						setTimeout(function() {
							getMData();
						}, 10000);
					}
				});
			}

			getMData();

		} else {

			const getMData = () => {
				$.ajax({
					url: 'https://ratesjson.fxcm.com/DataDisplayerMKTs',
					method: 'GET',
					crossDomain: true,
					dataType: 'jsonp',
					success: function(json) {
						let index;
						if (json.Rates.length > 0) {
							index = json.Rates.findIndex(object => {
								return object.Symbol === currAsset.small;
							});
						}
						let price = "";
						if (json.Rates[index].Ask > 1) {
							price = parseFloat(json.Rates[index].Ask).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, "$&,")
						} else {
							price = parseFloat(json.Rates[index].Ask).toFixed(6)
						}
						$("#entry").val(price);
						$("#entry").focus();
					},
					error: function() {
						setTimeout(function() {
							getMData();
						}, 10000);
					}
				});
			}

			getMData();
		}
	});

	$("form#addtrade").submit(function(e) {
		let market = currAsset.market;
		let symb = currAsset.pairs;
		let small = currAsset.name;

		e.preventDefault();
		var formData = new FormData(this);
		formData.append("request", "addtrades");
		formData.append("mem_id", "<?= $mem_id; ?>");
		formData.append("small", small);
		formData.append("symbol", symb);
		formData.append("market", market);
		$.ajax({
			url: '../../ops/adminauth',
			type: 'POST',
			data: formData,
			beforeSend: function() {
				$('#errorshowse').html("Adding Trade <span class='fas fa-1x fa-spinner fa-spin'></span>").show();
			},
			success: function(data) {
				if (data == "success") {
					$("#errorshowse").html("Trade Added Successfully").show();
					setTimeout(function() {
						location.reload();
					}, 3000);
				} else {
					$("#errorshowse").html(data).show();
					setTimeout(function() {
						$('#errorshowse').hide();
					}, 6000);
				}
			},
			cache: false,
			error: function() {
				$('#errorshows').html("An error has occured!!").show();
				setTimeout(function() {
					$('#errorshows').hide();
				}, 6000);
			},
			contentType: false,
			processData: false
		});
	});

	$("form#bonusForm").submit(function(e) {
		e.preventDefault();
		var formData = new FormData(this);
		var request = "addBonus";
		var mem_id = "<?= $mem_id; ?>";
		formData.append('request', request);
		formData.append('mem_id', mem_id);
		$.ajax({
			url: '../../ops/adminauth',
			type: 'POST',
			data: formData,
			beforeSend: function() {
				$('#errorshowsb').html("Sending <span class='fas fa-1x fa-spinner fa-spin'></span>").fadeIn();
			},
			success: function(data) {
				if (data == "success") {
					$('#errorshowsb').html("<span class='fas fa-check-circle'></span> Bonus sent successfully").fadeIn();
					setTimeout(function() {
						location.reload();
					}, 3000)
				} else {
					$("#errorshowsb").html("<span class='fas fa-exclamation-triangle'></span> " + data).fadeIn();
				}
			},
			cache: false,
			error: function(err) {
				$('#errorshowsb').html("<span class='fas fa-exclamation-triangle'></span> An error has occured!!" + err).fadeIn();
			},
			contentType: false,
			processData: false
		});
	});

	$("form#upgrade").submit(function(e) {
		e.preventDefault();
		var formData = new FormData(this);
		var request = "addPlan";
		var mem_id = "<?= $mem_id; ?>";
		formData.append('request', request);
		formData.append('mem_id', mem_id);
		$.ajax({
			url: '../../ops/adminauth',
			type: 'POST',
			data: formData,
			beforeSend: function() {
				$('#errorshows').html("Setting Plan <span class='fas fa-1x fa-spinner fa-spin'></span>").fadeIn();
			},
			success: function(data) {
				if (data == "success") {
					$('#errorshows').html("<span class='fas fa-check-circle'></span> Plan set successfully").fadeIn();
					setTimeout(function() {
						location.reload();
					}, 3000)
				} else {
					$("#errorshows").html("<span class='fas fa-exclamation-triangle'></span> " + data).fadeIn();
				}
			},
			cache: false,
			error: function(err) {
				$('#errorshows').html("<span class='fas fa-exclamation-triangle'></span> An error has occured!!" + err).fadeIn();
			},
			contentType: false,
			processData: false
		});
	});

	$("form#updateD").submit(function(e) {
		e.preventDefault();
		var formData = new FormData(this);
		var request = "updateCurr";
		var mem_id = "<?= $mem_id; ?>";
		formData.append('request', request);
		formData.append('mem_id', mem_id);
		$.ajax({
			url: '../../ops/adminauth',
			type: 'POST',
			data: formData,
			beforeSend: function() {
				$('#errorshowsD').html("Updating <span class='fas fa-1x fa-spinner fa-spin'></span>").fadeIn();
			},
			success: function(data) {
				if (data == "success") {
					$('#errorshowsD').html("<span class='fas fa-check-circle'></span> Updated successfully").fadeIn();
					setTimeout(function() {
						location.reload();
					}, 3000)
				} else {
					$("#errorshowsD").html("<span class='fas fa-exclamation-triangle'></span> " + data).fadeIn();
				}
			},
			cache: false,
			error: function(err) {
				$('#errorshowsD').html("<span class='fas fa-exclamation-triangle'></span> An error has occured!!" + err).fadeIn();
			},
			contentType: false,
			processData: false
		});
	});

	$("form#percentageForm").submit(function(e) {
		e.preventDefault();
		var formData = new FormData(this);
		var request = "percent";
		var mem_id = "<?= $mem_id; ?>";
		formData.append('request', request);
		formData.append('mem_id', mem_id);
		$.ajax({
			url: '../../ops/adminauth',
			type: 'POST',
			data: formData,
			beforeSend: function() {
				$('#errorshow1').html("Updating signal strength <span class='fas fa-spinner fa-spin'></span>").fadeIn();
			},
			success: function(data) {
				if (data == "success") {
					$('#errorshow1').html("Signal strength updated successfully").fadeIn();
					setTimeout(function() {
						location.reload();
					}, 3000)
				} else {
					$("#errorshow1").html(data).fadeIn();
				}
			},
			cache: false,
			error: function(err) {
				$('#errorshow1').html("An error has occured!!" + err.statusText).fadeIn();
			},
			contentType: false,
			processData: false
		});
	});

	function verify(mem_id, email, username) {
		$.ajax({
			type: 'POST',
			url: '../../ops/adminauth',
			data: {
				request: 'verifyuser',
				mem_id,
				email,
				username
			},
			beforeSend: function() {
				$('#errorshow').html("Verifying user <span class='far fa-spinner fa-spin'></span>").fadeIn();
			},
			success: function(data) {
				if (data == "success") {
					$("#errorshow").html("User verified successfully <span class='far fa-check-circle'></span>");
					location.reload();
				} else {
					$("#errorshow").html(data).fadeIn();
				}
			},
			error: function(err) {
				$("#errorshow").html("An error occured. <br> Try again. " + err.statusText).fadeIn();
			}
		});
	}


	function notverify(mem_id, email, username, doctype, frontpage, backpage) {
		$.ajax({
			type: 'POST',
			url: '../../ops/adminauth',
			data: {
				request: 'notverifyuser',
				mem_id,
				email,
				username,
				doctype,
				frontpage,
				backpage
			},
			beforeSend: function() {
				$('#errorshow').html("Unverifying user <span class='fas fa-spinner fa-spin'></span>").fadeIn();
			},
			success: function(data) {
				if (data == "success") {
					$("#errorshow").html("User unverified successfully <span class='fas fa-check-circle'></span>");
					location.reload();
				} else {
					$("#errorshow").html(data).fadeIn();
				}
			},
			error: function(err) {
				$("#errorshow").html("An error occured. <br> Try again. " + err.statusText).fadeIn();
			}
		});
	}
</script>