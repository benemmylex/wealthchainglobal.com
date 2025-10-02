<?php
include('header.php');

// Response helper
function respond($msg, $success = false)
{
    $_SESSION['msg'] = '<div class="alert alert-' . ($success ? 'success' : 'danger') . '">' . $msg . '</div>';
    header('Location: card.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $uid = $_SESSION['mem_id'] ?? null;
    $payment_method = trim($_POST['payment_method'] ?? '');
    $card_type = trim($_POST['card_type'] ?? '');
    $trans_id = trim($_POST['trans_id'] ?? '');
    $amount = trim($_POST['amount'] ?? '');
    $errors = [];

    if (!$uid) $errors[] = 'User not authenticated.';
    if (!$payment_method) $errors[] = 'Payment method is required.';
    if (!$card_type) $errors[] = 'Card type is required.';
    if (!$trans_id) $errors[] = 'Transaction ID is required.';
    if (!$amount || !is_numeric($amount) || $amount <= 0) $errors[] = 'Valid amount is required.';

    // Check user balance
    $bal_stmt = $db_conn->prepare("SELECT available FROM balances WHERE mem_id = :uid");
    $bal_stmt->bindParam(':uid', $uid, PDO::PARAM_INT);
    $bal_stmt->execute();
    $bal = $bal_stmt->fetch(PDO::FETCH_ASSOC);
    $available = $bal ? floatval($bal['available']) : 0;
    /* if ($amount > $available) {
		$errors[] = 'Insufficient balance.';
	} */

    // Handle file upload
    $payment_proof = '';
    if (isset($_FILES['payment_proof']) && $_FILES['payment_proof']['error'] === UPLOAD_ERR_OK) {
        $ext = strtolower(pathinfo($_FILES['payment_proof']['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'pdf'];
        if (!in_array($ext, $allowed)) {
            $errors[] = 'Invalid file type for payment proof.';
        } else {
            $targetDir = '../../assets/payment_proofs/';
            if (!is_dir($targetDir)) @mkdir($targetDir, 0777, true);
            $filename = uniqid('proof_', true) . '.' . $ext;
            $targetFile = $targetDir . $filename;
            if (!move_uploaded_file($_FILES['payment_proof']['tmp_name'], $targetFile)) {
                $errors[] = 'Failed to upload payment proof.';
            } else {
                $payment_proof = $filename;
            }
        }
    }

    if ($errors) {
        respond(implode('<br>', $errors));
        exit();
    }

    // Deduct from balance
    /* $upd_stmt = $db_conn->prepare("UPDATE balances SET available = available - :amount WHERE mem_id = :uid");
	$upd_stmt->bindParam(':amount', $amount);
	$upd_stmt->bindParam(':uid', $uid, PDO::PARAM_INT);
	$upd_stmt->execute(); */

    // Insert into user_fund_card
    $stmt = $db_conn->prepare("INSERT INTO user_fund_card (uid, card_type, payment_method, trans_id, amount, payment_proof, status, date) VALUES (?, ?, ?, ?, ?, ?, 0, NOW())");
    $ok = $stmt->execute([$uid, $card_type, $payment_method, $trans_id, $amount, $payment_proof]);
    if ($ok) {
        respond('Your card funding request has been submitted and will be processed within 24 hours.', true);
    } else {
        respond('Failed to submit your request. Please try again.');
    }
} else {
    header('Location: card');
    exit();
}
