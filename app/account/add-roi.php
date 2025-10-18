<?php
// This script increments investment profit (not user balance) based on plan ROI and investment amount.
// To be run as a cronjob every 24 hours.
error_reporting(E_ALL);
ini_set('display_errors', 1);
include("../../ops/connect.php");
$today = date_time();
echo "\n\n\n<br><br><br>Starting ROI increment process... on $today\n<br>";
// Get all active investments
$stmt = $db_conn->prepare("SELECT i.*, p.roi, p.duration, i.duration AS inv_duration FROM investment i JOIN plans p ON i.plan = p.id WHERE i.status = 1");
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
	echo "<br> Processing investment ID $inv_id for user $uid: $inv[inv_duration] days remaining. Started on $inv[start]\n<br>";
	if ($duration <= 0 || $inv['inv_duration'] <= 0) {
		echo "Skipping (not in valid range).\n<br>";
		// Send completion email to user
		$mem_stmt = $db_conn->prepare("SELECT mem_email, mem_fname, mem_lname FROM members WHERE id = :uid");
		$mem_stmt->bindParam(':uid', $uid, PDO::PARAM_INT);
		$mem_stmt->execute();
		$mem = $mem_stmt->fetch(PDO::FETCH_ASSOC);
		if ($mem) {
			$mail->clearAllRecipients();
			$mail->setFrom(SITE_EMAIL, SITE_NAME);
			$mail->addAddress($mem['mem_email'], $mem['mem_fname'] . ' ' . $mem['mem_lname']);
			$mail->Subject = "Investment Plan Completed";
			$mail->isHTML(true);
			$message_user = "<p>Dear " . htmlspecialchars($mem['mem_fname']) . ",</p>";
			$message_user .= "<p>Your investment ID #" . $inv_id . " has completed its plan duration.</p>";
			$message_user .= "<p>Total Profit Earned: <strong>" . number_format($profit, 2) . "</strong></p>";
			$message_user .= "<p>You can choose to activate a new plan or cash out your investment.</p>";
			$message_user .= "<p>Thank you for investing with " . SITE_NAME . ".</p>";
			$message_user .= "<p>Best regards,<br>" . SITE_NAME . " Team</p>";
			$mail->Body = $message_user;
			if (!$mail->send()) {
				error_log("User mail error: " . $mail->ErrorInfo);
			} else {
				// user mail sent
			}
		}
		continue;
	}
	if ($date_split[0] == date_time('d')) {
		echo "Skipping (activated today).\n<br>";
		continue;
	}
	if (time() < $start) {
		echo "Skipping (not started yet).\n<br>";
		continue;
	}
	echo "Valid for ROI increment.\n<br>";
	// Calculate daily ROI
	$total_expected_profit = ($roi / 100.0) * $amount;
	$daily_roi = $total_expected_profit /* / $duration */;

	// Check if already incremented for today
	$check = $db_conn->prepare("SELECT COUNT(*) FROM roi_log WHERE investment_id = :inv_id AND DATE(credited_at) = CURDATE()");
	$check->bindParam(':inv_id', $inv_id, PDO::PARAM_INT);
	$check->execute();
	if ($check->fetchColumn() > 0) {
		echo "Already incremented today. Skipping.\n<br>";
		continue;
	}

	// Increment investment profit
	$upd = $db_conn->prepare("UPDATE investment SET profit = profit + :roi, duration = duration - 1 WHERE id = :inv_id");
	$upd->bindParam(':roi', $daily_roi);
	$upd->bindParam(':inv_id', $inv_id, PDO::PARAM_INT);
	$upd->execute();

	// Increment balances profit
	$upd = $db_conn->prepare("UPDATE balances SET profit = profit + :roi WHERE mem_id = :uid");
	$upd->bindParam(':roi', $daily_roi);
	$upd->bindParam(':uid', $uid, PDO::PARAM_INT);
	$upd->execute();

	// Log the increment
	$log = $db_conn->prepare("INSERT INTO roi_log (investment_id, user_id, amount, credited_at) VALUES (:inv_id, :uid, :amt, NOW())");
	$log->bindParam(':inv_id', $inv_id, PDO::PARAM_INT);
	$log->bindParam(':uid', $uid, PDO::PARAM_INT);
	$log->bindParam(':amt', $daily_roi);
	$log->execute();
}

echo "<br><br>\n\nROI incremented for active investments.";
