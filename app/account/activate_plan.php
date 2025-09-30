<?php
include("../../ops/connect.php");

// Check if user is logged in
if (!isset($_SESSION['mem_id'])) {
	header("Location: signin.php");
	exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['plan_id'])) {
	$plan_id = intval($_POST['plan_id']);
	$amount_field = 'amount_' . $plan_id;
	$amount = isset($_POST[$amount_field]) ? floatval($_POST[$amount_field]) : 0;
	$uid = intval($_SESSION['mem_id']);

	// Fetch plan details
	$stmt = $db_conn->prepare("SELECT * FROM plans WHERE id = :id AND status = 1");
	$stmt->bindParam(':id', $plan_id, PDO::PARAM_INT);
	$stmt->execute();
	$plan = $stmt->fetch(PDO::FETCH_ASSOC);

	if (!$plan) {
		$_SESSION['error'] = "Invalid plan selected.";
		header("Location: investments.php");
		exit();
	}

	// Validate amount
	if ($amount < $plan['min_amt'] || $amount > $plan['max_amt']) {
		$_SESSION['error'] = "Amount must be between " . number_format($plan['min_amt']) . " and " . number_format($plan['max_amt']) . ".";
		header("Location: investments.php");
		exit();
	}

	// Check user balance
	$bal_stmt = $db_conn->prepare("SELECT available FROM balances WHERE mem_id = :uid");
	$bal_stmt->bindParam(':uid', $uid, PDO::PARAM_INT);
	$bal_stmt->execute();
	$bal = $bal_stmt->fetch(PDO::FETCH_ASSOC);
	$available = $bal ? floatval($bal['available']) : 0;
	if ($amount > $available) {
		$_SESSION['error'] = "Insufficient balance.";
		header("Location: investments.php");
		exit();
	}

	// Calculate profit and dates
	$roi = floatval($plan['roi']);
	$profit = ($roi / 100.0) * $amount;
	$duration = intval($plan['duration']);
	if ($type === 1) { // Lifetime
		$duration = 3650; // 10 years for lifetime plans
	}
	$now = date('Y-m-d H:i:s');
	$end = date('Y-m-d H:i:s', strtotime("+$duration days"));
	$type = $plan['type'];

	// Insert into investment table
	$inv_stmt = $db_conn->prepare("INSERT INTO investment (uid, plan, type, amount, profit, duration, status, start, end) VALUES (:uid, :plan, :type, :amount, :profit, :duration, :status, :start, :end)");
	$inv_stmt->bindParam(':uid', $uid, PDO::PARAM_INT);
	$inv_stmt->bindParam(':plan', $plan_id, PDO::PARAM_INT);
	$inv_stmt->bindParam(':type', $type, PDO::PARAM_STR);
	$inv_stmt->bindParam(':amount', $amount);
	$inv_stmt->bindParam(':profit', $profit);
	$inv_stmt->bindParam(':duration', $duration, PDO::PARAM_INT);
	$activeStatus = 1;
	$inv_stmt->bindParam(':status', $activeStatus, PDO::PARAM_INT);
	$inv_stmt->bindParam(':start', $now);
	$inv_stmt->bindParam(':end', $end);
	$inv_stmt->execute();

	// Deduct from balance
	$upd_stmt = $db_conn->prepare("UPDATE balances SET available = available - :amount WHERE mem_id = :uid");
	$upd_stmt->bindParam(':amount', $amount);
	$upd_stmt->bindParam(':uid', $uid, PDO::PARAM_INT);
	$upd_stmt->execute();

	$_SESSION['success'] = "Investment plan activated successfully.";
	header("Location: investments.php");
	exit();
}

// If not POST or missing plan_id
header("Location: investments");
exit();
