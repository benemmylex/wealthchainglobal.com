<?php
// This script increments investment profit (not user balance) based on plan ROI and investment amount.
// To be run as a cronjob every 24 hours.
include("../../ops/connect.php");

// Get all active investments
$stmt = $db_conn->prepare("SELECT i.*, p.roi, p.duration FROM investment i JOIN plans p ON i.plan = p.id WHERE i.status = 1");
$stmt->execute();
$investments = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($investments as $inv) {
	$inv_id = $inv['id'];
	$uid = $inv['uid'];
	$amount = $inv['amount'];
	$roi = $inv['roi'];
	$duration = $inv['duration'];
	$profit = $inv['profit'];
	$start = strtotime($inv['start']);
	$date_split = explode(" ", $inv['start']);
	echo "<br> Processing investment ID $inv_id for user $uid: $days_passed days passed.\n<br>";
	if ($duration > 0 && $date_split[0] != date_time('d')) {
		echo $is_days_passed ? "Skipping (not in valid range).\n<br>" : "Valid for ROI increment.\n<br>";
		continue;
	}

	// Calculate daily ROI
	$total_expected_profit = ($roi / 100.0) * $amount;
	$daily_roi = $total_expected_profit /* / $duration */;

	// Check if already incremented for today
	$check = $db_conn->prepare("SELECT COUNT(*) FROM roi_log WHERE investment_id = :inv_id AND DATE(credited_at) = CURDATE()");
	$check->bindParam(':inv_id', $inv_id, PDO::PARAM_INT);
	$check->execute();
	if ($check->fetchColumn() > 0) continue;

	// Increment investment profit
	$upd = $db_conn->prepare("UPDATE investment SET profit = profit + :roi, duration = duration - 1 WHERE mem_id = :inv_id");
	$upd->bindParam(':roi', $daily_roi);
	$upd->bindParam(':inv_id', $inv_id, PDO::PARAM_INT);
	$upd->execute();

	// Increment balances profit
	$upd = $db_conn->prepare("UPDATE balances SET profit = profit + :roi WHERE mem_id = :inv_id");
	$upd->bindParam(':roi', $daily_roi);
	$upd->bindParam(':inv_id', $inv_id, PDO::PARAM_INT);
	$upd->execute();

	// Log the increment
	$log = $db_conn->prepare("INSERT INTO roi_log (investment_id, user_id, amount, credited_at) VALUES (:inv_id, :uid, :amt, NOW())");
	$log->bindParam(':inv_id', $inv_id, PDO::PARAM_INT);
	$log->bindParam(':uid', $uid, PDO::PARAM_INT);
	$log->bindParam(':amt', $daily_roi);
	$log->execute();
}

echo "ROI incremented for active investments.";
