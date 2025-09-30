<?php
include("../../ops/connect.php");
if (!isset($_SESSION['mem_id'])) {
	header("Location: signin.php");
	exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['investment_id'])) {
	$investment_id = intval($_POST['investment_id']);
	$mem_id = intval($_SESSION['mem_id']);

	// Fetch investment
	$stmt = $db_conn->prepare("SELECT * FROM investment WHERE id = :id AND uid = :uid AND status = 1");
	$stmt->bindParam(':id', $investment_id, PDO::PARAM_INT);
	$stmt->bindParam(':uid', $mem_id, PDO::PARAM_INT);
	$stmt->execute();
	$inv = $stmt->fetch(PDO::FETCH_ASSOC);

	if (!$inv) {
		$_SESSION['error'] = "Invalid or already closed investment.";
		header("Location: my-investments");
		exit();
	}

	$total = floatval($inv['amount']) + floatval($inv['profit']);

	// Credit to user's balance
	$upd = $db_conn->prepare("UPDATE balances SET available = available + :total WHERE mem_id = :uid");
	$upd->bindParam(':total', $total);
	$upd->bindParam(':uid', $mem_id, PDO::PARAM_INT);
	$upd->execute();

	// Mark investment as closed (status = 2)
	$close = $db_conn->prepare("UPDATE investment SET status = 2 WHERE id = :id");
	$close->bindParam(':id', $investment_id, PDO::PARAM_INT);
	$close->execute();

	$_SESSION['success'] = "Cashout successful. Amount credited: " . number_format($total, 2);
	header("Location: my-investments");
	exit();
}

header("Location: my-investments");
exit();
