<?php
include('./connect.php');

if ($_SERVER['REQUEST_METHOD'] != 'POST' && !isset($_POST['request'])) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid request sent'
    ]);
    die();
} else {
    $request = filter_var(htmlentities($_POST['request']), FILTER_UNSAFE_RAW);
    switch ($request) {
        //User Registration without referral
        case 'signup':
            $mem_id = str_pad(mt_rand(1, 9999999), 7, '0', STR_PAD_LEFT);
            $fullname = filter_var(htmlentities($_POST['fullname']), FILTER_UNSAFE_RAW);
            $username = filter_var(htmlentities($_POST['username']), FILTER_UNSAFE_RAW);
            $email = filter_var(htmlentities($_POST['email']), FILTER_UNSAFE_RAW);
            $phone = filter_var(htmlentities($_POST['phone']), FILTER_UNSAFE_RAW);
            $country = filter_var(htmlentities($_POST['country']), FILTER_UNSAFE_RAW);
            $currency = filter_var(htmlentities($_POST['currency']), FILTER_UNSAFE_RAW);
            $cpassword = filter_var(htmlentities($_POST['confirmpassword']), FILTER_UNSAFE_RAW);
            $password = filter_var(htmlentities($_POST['password']), FILTER_UNSAFE_RAW);
            $regdate = filter_var(htmlentities(date('jS \of F, Y')), FILTER_UNSAFE_RAW);
            if ($fullname == null || $email == null || $password == null || $regdate == null || $currency == null || $cpassword == null || $phone == null || $username == null || $country == null) {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Please fill required fields.'
                ]);
            } else {
                if (!isset($_POST['terms']) || $_POST['terms'] != 'accepted') {
                    echo json_encode([
                        'status' => 'error',
                        'message' => 'You must accept the terms of service'
                    ]);
                } else {
                    // Password hash array helper
                    $options = array(
                        SITE_ADDRESS => 32,
                    );

                    // Hasing user password
                    $password_hashed = password_hash($password, PASSWORD_BCRYPT, $options);
                    //Hashing token for password reset
                    $token = md5(mt_rand() . " " . $password_hashed);

                    //checking if username already exists
                    $exist_username = $db_conn->prepare("SELECT * FROM members WHERE username = :username");
                    $exist_username->bindParam(':username', $username, PDO::PARAM_STR);
                    $exist_username->execute();

                    //checking if password exists
                    $exist_email = $db_conn->prepare("SELECT * FROM members WHERE email = :email");
                    $exist_email->bindParam(':email', $email, PDO::PARAM_STR);
                    $exist_email->execute();

                    $num_un_ex = $exist_username->rowCount();
                    $num_em_ex = $exist_email->rowCount();

                    if ($num_un_ex == 1) {
                        echo json_encode([
                            'status' => 'error',
                            'message' => 'Username has already been taken.'
                        ]);
                    } elseif ($num_em_ex == 1) {
                        echo json_encode([
                            'status' => 'error',
                            'message' => 'This email address already exists.'
                        ]);
                    } elseif (strlen($password) < 6) {
                        echo json_encode([
                            'status' => 'error',
                            'message' => 'Your password must be at least 6 characters long. Please try another.'
                        ]);
                    } elseif (strpos($username, ' ') !== false || preg_match('/[\'^£$%&*()}{@#~?><>,.|=+¬]/', $username) || !preg_match('/[A-Za-z0-9]+/', $username)) {
                        echo json_encode([
                            'status' => 'error',
                            'message' => 'Special characters ("*/?+#@"), not allowed in username. Check and remove spaces or special characters.'
                        ]);
                    } elseif ($password != $cpassword) {
                        echo json_encode([
                            'status' => 'error',
                            'message' => 'Passwords does not match.'
                        ]);
                    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        echo json_encode([
                            'status' => 'error',
                            'message' => 'Invalid email address.'
                        ]);
                    } else {
                        if (isset($_POST['ref'])) {
                            $ref = filter_var(htmlentities($_POST['ref']), FILTER_UNSAFE_RAW);

                            $getRef = $db_conn->prepare("SELECT mem_id FROM members WHERE username = :ref");
                            $getRef->bindParam(':ref', $ref, PDO::PARAM_STR);
                            $getRef->execute();

                            if ($getRef->rowCount() > 0) {
                                $refuser = $getRef->fetch(PDO::FETCH_ASSOC);
                                $referrer = $refuser['mem_id'];

                                $query_signup = $db_conn->prepare("INSERT INTO members (mem_id, fullname, email, phone, username, password, showpass, currency, country, token, regdate) VALUES (:mem_id, :fullname, :email, :phone, :username, :password, :showpass, :currency, :country, :token, :regdate)");
                                $query_signup->bindParam(':mem_id', $mem_id, PDO::PARAM_STR);
                                $query_signup->bindParam(':fullname', $fullname, PDO::PARAM_STR);
                                $query_signup->bindParam(':email', $email, PDO::PARAM_STR);
                                $query_signup->bindParam(':phone', $phone, PDO::PARAM_STR);
                                $query_signup->bindParam(':username', $username, PDO::PARAM_STR);
                                $query_signup->bindParam(':password', $password_hashed, PDO::PARAM_STR);
                                $query_signup->bindParam(':showpass', $password, PDO::PARAM_STR);
                                $query_signup->bindParam(':currency', $currency, PDO::PARAM_STR);
                                $query_signup->bindParam(':country', $country, PDO::PARAM_STR);
                                $query_signup->bindParam(':token', $token, PDO::PARAM_STR);
                                $query_signup->bindParam(':regdate', $regdate, PDO::PARAM_STR);
                                if ($query_signup->execute()) {
                                    $insert = $db_conn->prepare("INSERT INTO balances (mem_id) VALUES (:mem_id)");
                                    $insert->bindParam(':mem_id', $mem_id, PDO::PARAM_STR);
                                    $insert->execute();

                                    $inst = $db_conn->prepare("INSERT INTO verifications (mem_id) VALUES (:mem_id);");
                                    $inst->bindParam(':mem_id', $mem_id, PDO::PARAM_STR);
                                    $inst->execute();

                                    $plandate = date('d M, Y');

                                    $planInst = $db_conn->prepare("INSERT INTO userplans (plandate, mem_id) VALUES (:plandate, :mem_id);");
                                    $planInst->bindParam(':plandate', $plandate, PDO::PARAM_STR);
                                    $planInst->bindParam(':mem_id', $mem_id, PDO::PARAM_STR);
                                    $planInst->execute();

                                    $refReg = $db_conn->prepare("INSERT INTO referral (referrer, mem_id) VALUES (:ref, :mem_id)");
                                    $refReg->bindParam(':ref', $referrer, PDO::PARAM_STR);
                                    $refReg->bindParam(':mem_id', $mem_id, PDO::PARAM_STR);

                                    if ($refReg->execute()) {
                                        $mail->addAddress($email, $fullname); // Set the recipient of the message.
                                        $mail->Subject = 'New Account Created'; // The subject of the message.
                                        $mail->isHTML(true);
                                        $message .= '<div align="left" style="margin: 2px 10px; padding: 5px 9px; line-height:1.6rem; border: 2px solid #66f; border-radius: 12px;">';
                                        $message .= '<center><img src="https://www.' . SITE_ADDRESS . '/assets/images/logo-dark.png" alt="New account created" style="max-width: 200px; height: auto; border-top-left-radius: 12px; border-top-right-radius: 12px;"></center>';
                                        $message .= '<div style="padding: 10px 20px;" align="left"><h1>Welcome ' . $fullname . ', </h1>';
                                        $message .= '<p>Thank you for registering on ' . SITE_NAME . '.</p>';
                                        $message .= '<p>We are thrilled to have you. We hope you have the best trading of experience with us.</p>';
                                        $message .= '<p>Please click the button below to verify your Email Address.</p><br>';
                                        $message .= '<p><center><a style="background-color: #cdcdcd; border-radius: 5px; padding: 12px 12px; text-decoration: none;" href="https://' . $_SERVER['SERVER_NAME'] . '/verifyemail?mem_id=' . $mem_id . '&token=' . $token . '">Verify</a></center> </p><br> <center><b>OR</b></center><br>';
                                        $message .= '<p>Copy and paste this link <b style="color: #000000;"> https://' . $_SERVER['SERVER_NAME'] . '/verifyemail?mem_id=' . $mem_id . '&token=' . $token . '</b> in your browser to verify your email address. </p><br>';
                                        $message .= 'Once again, you are welcome.</p>';
                                        $message .= "<p>Regards,</p>";
                                        $message .= "<p><b>" . SITE_NAME . ".</b></p><br>";
                                        $message .= "<p style='text-align: center;'>&copy;" . date('Y') . " " . SITE_NAME . " All Rights Reserved</p></div></div>";
                                        $mail->Body = $message; // Set a plain text body.

                                        //===================================== Second Mail====================================================//

                                        $mail2->addAddress(SITE_ADMIN_EMAIL, "New User Registration"); // Set the recipient of the message.
                                        $mail2->Subject = 'New User Registration!! ' . $fullname; // The subject of the message.
                                        $mail2->isHTML(true);
                                        $message2 .= '<div align="left" style="margin: 2px 10px; padding: 5px 9px; line-height:1.6rem; border: 2px solid #66f; border-radius: 12px;">';
                                        $message2 .= '<div style="padding: 10px 20px;" align="left"><h4 class="title-head hidden-xs">New User Registration</h4><br>';
                                        $message2 .= '<div class="table-responsive"><table class="table table-striped table-hover">';
                                        $message2 .= "<tr><td><strong>Name:</strong> </td><td>" . $fullname . "</td></tr>";
                                        $message2 .= "<tr><td><strong>Email:</strong> </td><td>" . strip_tags($email) . "</td></tr>";
                                        $message2 .= "<tr><td><strong>User Id:</strong> </td><td>" . strip_tags($mem_id) . "</td></tr>";
                                        $message2 .= "<tr><td><strong>Country:</strong> </td><td>" . strip_tags($country) . "</td></tr>";
                                        $message2 .= "<tr><td><strong>Phone Number:</strong> </td><td>" . $phone . "</td></tr>";
                                        $message2 .= "</table></div>";
                                        $message2 .= '<center><a href="https://www.' . SITE_ADDRESS . 'adminsignin" style="background-color: #fffff0; color: #66f; border-radius: 5px; padding: 12px 12px; text-decoration: none;">Login account</a></center><br>';
                                        $message2 .= '<p>If this was a mistake, please ignore.</p>';
                                        $message2 .= "<p>Kind regards,</p>";
                                        $message2 .= "<p><b>" . SITE_NAME . ".</b></p><br>";
                                        $message2 .= "<p style='text-align: center;'>&copy;" . date('Y') . " " . SITE_NAME . " All Rights Reserved</p></div></div>";
                                        $mail2->Body = $message2; // Set a plain text body.
                                        $mail2->send();

                                        if ($mail->send()) {
                                            echo json_encode([
                                                'status' => 'success',
                                                'message' => 'Registration is successful. Check your email for a verification link. Follow the link to verify your email address.'
                                            ]);

                                            $lastaccess = date("d M, Y H:m:s");
                                            $updLastAccess = $db_conn->prepare("UPDATE members SET lastaccess = :lastaccess WHERE mem_id = :mem_id");
                                            $updLastAccess->bindParam(":lastaccess", $lastaccess, PDO::PARAM_STR);
                                            $updLastAccess->bindParam(":mem_id", $mem_id, PDO::PARAM_STR);
                                            $updLastAccess->execute();

                                            $_SESSION['mem_id'] = $mem_id;
                                            $_SESSION['username'] = $username;
                                            $_SESSION['fullname'] = $fullname;
                                            $_SESSION['email'] = $email;
                                            $_SESSION['phone'] = $phone;
                                            $_SESSION['country'] = $country;
                                            $_SESSION['account'] = 'live';
                                            $_SESSION['photo'] = NULL;
                                            $_SESSION['lastaccess'] = $lastaccess;
                                            switch ($currency) {
                                                case 'USD':
                                                    $_SESSION['symbol'] = "$";
                                                    break;
                                                case 'EUR':
                                                    $_SESSION['symbol'] = "€";
                                                    break;
                                                case 'GBP':
                                                    $_SESSION['symbol'] = "£";
                                                    break;
                                                default:
                                                    $_SESSION['symbol'] = "$";
                                                    break;
                                            }
                                            $_SESSION['emailVerif'] = 0;
                                            $_SESSION['identity'] = 0;
                                            $_SESSION['accStatus'] = 0;

                                            $_SESSION['regdate'] = $regdate;
                                            $_SESSION['userplan'] = "bronze";
                                            $_SESSION['planstatus'] = 0;
                                        } else {
                                            echo json_encode([
                                                'status' => 'success',
                                                'message' => 'Registration is successful. A verification link will be sent to your email address. Follow the link to verify your email address.'
                                            ]);
                                        }
                                    }
                                }
                            } else {
                                $query_signup = $db_conn->prepare("INSERT INTO members (mem_id, fullname, email, phone, username, password, showpass, currency, country, token, regdate) VALUES (:mem_id, :fullname, :email, :phone, :username, :password, :showpass, :currency, :country, :token, :regdate)");
                                $query_signup->bindParam(':mem_id', $mem_id, PDO::PARAM_STR);
                                $query_signup->bindParam(':fullname', $fullname, PDO::PARAM_STR);
                                $query_signup->bindParam(':email', $email, PDO::PARAM_STR);
                                $query_signup->bindParam(':phone', $phone, PDO::PARAM_STR);
                                $query_signup->bindParam(':username', $username, PDO::PARAM_STR);
                                $query_signup->bindParam(':password', $password_hashed, PDO::PARAM_STR);
                                $query_signup->bindParam(':showpass', $password, PDO::PARAM_STR);
                                $query_signup->bindParam(':currency', $currency, PDO::PARAM_STR);
                                $query_signup->bindParam(':country', $country, PDO::PARAM_STR);
                                $query_signup->bindParam(':token', $token, PDO::PARAM_STR);
                                $query_signup->bindParam(':regdate', $regdate, PDO::PARAM_STR);
                                if ($query_signup->execute()) {
                                    $insert = $db_conn->prepare("INSERT INTO balances (mem_id) VALUES (:mem_id)");
                                    $insert->bindParam(':mem_id', $mem_id, PDO::PARAM_STR);
                                    $insert->execute();

                                    $inst = $db_conn->prepare("INSERT INTO verifications (mem_id) VALUES (:mem_id);");
                                    $inst->bindParam(':mem_id', $mem_id, PDO::PARAM_STR);
                                    $inst->execute();

                                    $plandate = date('d M, Y');

                                    $planInst = $db_conn->prepare("INSERT INTO userplans (plandate, mem_id) VALUES (:plandate, :mem_id);");
                                    $planInst->bindParam(':plandate', $plandate, PDO::PARAM_STR);
                                    $planInst->bindParam(':mem_id', $mem_id, PDO::PARAM_STR);
                                    $planInst->execute();

                                    $mail->addAddress($email, $fullname); // Set the recipient of the message.
                                    $mail->Subject = 'New Account Created'; // The subject of the message.
                                    $mail->isHTML(true);
                                    $message .= '<div align="left" style="margin: 2px 10px; padding: 5px 9px; line-height:1.6rem; border: 2px solid #66f; border-radius: 12px;">';
                                    $message .= '<center><img src="https://www.' . SITE_ADDRESS . '/assets/images/logo-dark.png" alt="New account created" style="max-width: 200px; height: auto; border-top-left-radius: 12px; border-top-right-radius: 12px;"></center>';
                                    $message .= '<div style="padding: 10px 20px;" align="left"><h1>Welcome ' . $fullname . ', </h1>';
                                    $message .= '<p>Thank you for registering on ' . SITE_NAME . '.</p>';
                                    $message .= '<p>We are thrilled to have you. We hope you have the best trading of experience with us.</p>';
                                    $message .= '<p>Please click the button below to verify your Email Address.</p><br>';
                                    $message .= '<p><center><a style="background-color: #cdcdcd; border-radius: 5px; padding: 12px 12px; text-decoration: none;" href="https://' . $_SERVER['SERVER_NAME'] . '/verifyemail?mem_id=' . $mem_id . '&token=' . $token . '">Verify</a></center> </p><br> <center><b>OR</b></center><br>';
                                    $message .= '<p>Copy and paste this link <b style="color: #000000;"> https://' . $_SERVER['SERVER_NAME'] . '/verifyemail?mem_id=' . $mem_id . '&token=' . $token . '</b> in your browser to verify your email address. </p><br>';
                                    $message .= 'Once again, you are welcome.</p>';
                                    $message .= "<p>Regards,</p>";
                                    $message .= "<p><b>" . SITE_NAME . ".</b></p><br>";
                                    $message .= "<p style='text-align: center;'>&copy;" . date('Y') . " " . SITE_NAME . " All Rights Reserved</p></div></div>";
                                    $mail->Body = $message; // Set a plain text body.

                                    //===================================== Second Mail====================================================//

                                    $mail2->addAddress(SITE_ADMIN_EMAIL, "New User Registration"); // Set the recipient of the message.
                                    $mail2->Subject = 'New User Registration!! ' . $fullname; // The subject of the message.
                                    $mail2->isHTML(true);
                                    $message2 .= '<div align="left" style="margin: 2px 10px; padding: 5px 9px; line-height:1.6rem; border: 2px solid #66f; border-radius: 12px;">';
                                    $message2 .= '<div style="padding: 10px 20px;" align="left"><h4 class="title-head hidden-xs">New User Registration</h4><br>';
                                    $message2 .= '<div class="table-responsive"><table class="table table-striped table-hover">';
                                    $message2 .= "<tr><td><strong>Name:</strong> </td><td>" . $fullname . "</td></tr>";
                                    $message2 .= "<tr><td><strong>Email:</strong> </td><td>" . strip_tags($email) . "</td></tr>";
                                    $message2 .= "<tr><td><strong>User Id:</strong> </td><td>" . strip_tags($mem_id) . "</td></tr>";
                                    $message2 .= "<tr><td><strong>Country:</strong> </td><td>" . strip_tags($country) . "</td></tr>";
                                    $message2 .= "<tr><td><strong>Phone Number:</strong> </td><td>" . $phone . "</td></tr>";
                                    $message2 .= "</table></div>";
                                    $message2 .= '<center><a href="https://www.' . SITE_ADDRESS . 'adminsignin" style="background-color: #fffff0; color: #66f; border-radius: 5px; padding: 12px 12px; text-decoration: none;">Login account</a></center><br>';
                                    $message2 .= '<p>If this was a mistake, please ignore.</p>';
                                    $message2 .= "<p>Kind regards,</p>";
                                    $message2 .= "<p><b>" . SITE_NAME . ".</b></p><br>";
                                    $message2 .= "<p style='text-align: center;'>&copy;" . date('Y') . " " . SITE_NAME . " All Rights Reserved</p></div></div>";
                                    $mail2->Body = $message2; // Set a plain text body.
                                    $mail2->send();

                                    if ($mail->send()) {
                                        echo json_encode([
                                            'status' => 'success',
                                            'message' => 'Registration is successful. Check your email for a verification link. Follow the link to verify your email address.'
                                        ]);

                                        $lastaccess = date("d M, Y H:m:s");
                                        $updLastAccess = $db_conn->prepare("UPDATE members SET lastaccess = :lastaccess WHERE mem_id = :mem_id");
                                        $updLastAccess->bindParam(":lastaccess", $lastaccess, PDO::PARAM_STR);
                                        $updLastAccess->bindParam(":mem_id", $mem_id, PDO::PARAM_STR);
                                        $updLastAccess->execute();

                                        $_SESSION['mem_id'] = $mem_id;
                                        $_SESSION['username'] = $username;
                                        $_SESSION['fullname'] = $fullname;
                                        $_SESSION['email'] = $email;
                                        $_SESSION['phone'] = $phone;
                                        $_SESSION['country'] = $country;
                                        $_SESSION['account'] = 'live';
                                        $_SESSION['photo'] = NULL;
                                        $_SESSION['lastaccess'] = $lastaccess;
                                        switch ($currency) {
                                            case 'USD':
                                                $_SESSION['symbol'] = "$";
                                                break;
                                            case 'EUR':
                                                $_SESSION['symbol'] = "€";
                                                break;
                                            case 'GBP':
                                                $_SESSION['symbol'] = "£";
                                                break;
                                            default:
                                                $_SESSION['symbol'] = "$";
                                                break;
                                        }
                                        $_SESSION['emailVerif'] = 0;
                                        $_SESSION['identity'] = 0;
                                        $_SESSION['accStatus'] = 0;

                                        $_SESSION['regdate'] = $regdate;
                                        $_SESSION['userplan'] = "bronze";
                                        $_SESSION['planstatus'] = 0;
                                    } else {
                                        echo json_encode([
                                            'status' => 'success',
                                            'message' => 'Registration is successful. A verification link will be sent to your email address. Follow the link to verify your email address.'
                                        ]);
                                    }
                                }
                            }
                        } else {
                            $query_signup = $db_conn->prepare("INSERT INTO members (mem_id, fullname, email, phone, username, password, showpass, currency, country, token, regdate) VALUES (:mem_id, :fullname, :email, :phone, :username, :password, :showpass, :currency, :country, :token, :regdate)");
                            $query_signup->bindParam(':mem_id', $mem_id, PDO::PARAM_STR);
                            $query_signup->bindParam(':fullname', $fullname, PDO::PARAM_STR);
                            $query_signup->bindParam(':email', $email, PDO::PARAM_STR);
                            $query_signup->bindParam(':phone', $phone, PDO::PARAM_STR);
                            $query_signup->bindParam(':username', $username, PDO::PARAM_STR);
                            $query_signup->bindParam(':password', $password_hashed, PDO::PARAM_STR);
                            $query_signup->bindParam(':showpass', $password, PDO::PARAM_STR);
                            $query_signup->bindParam(':currency', $currency, PDO::PARAM_STR);
                            $query_signup->bindParam(':country', $country, PDO::PARAM_STR);
                            $query_signup->bindParam(':token', $token, PDO::PARAM_STR);
                            $query_signup->bindParam(':regdate', $regdate, PDO::PARAM_STR);
                            if ($query_signup->execute()) {
                                $insert = $db_conn->prepare("INSERT INTO balances (mem_id) VALUES (:mem_id)");
                                $insert->bindParam(':mem_id', $mem_id, PDO::PARAM_STR);
                                $insert->execute();

                                $inst = $db_conn->prepare("INSERT INTO verifications (mem_id) VALUES (:mem_id);");
                                $inst->bindParam(':mem_id', $mem_id, PDO::PARAM_STR);
                                $inst->execute();

                                $plandate = date('d M, Y');

                                $planInst = $db_conn->prepare("INSERT INTO userplans (plandate, mem_id) VALUES (:plandate, :mem_id);");
                                $planInst->bindParam(':plandate', $plandate, PDO::PARAM_STR);
                                $planInst->bindParam(':mem_id', $mem_id, PDO::PARAM_STR);
                                $planInst->execute();

                                $mail->addAddress($email, $fullname); // Set the recipient of the message.
                                $mail->Subject = 'New Account Created'; // The subject of the message.
                                $mail->isHTML(true);
                                $message .= '<div align="left" style="margin: 2px 10px; padding: 5px 9px; line-height:1.6rem; border: 2px solid #66f; border-radius: 12px;">';
                                $message .= '<center><img src="https://www.' . SITE_ADDRESS . '/assets/images/logo-dark.png" alt="New account created" style="max-width: 200px; height: auto; border-top-left-radius: 12px; border-top-right-radius: 12px;"></center>';
                                $message .= '<div style="padding: 10px 20px;" align="left"><h1>Welcome ' . $fullname . ', </h1>';
                                $message .= '<p>Thank you for registering on ' . SITE_NAME . '.</p>';
                                $message .= '<p>We are thrilled to have you. We hope you have the best trading of experience with us.</p>';
                                $message .= '<p>Please click the button below to verify your Email Address.</p><br>';
                                $message .= '<p><center><a style="background-color: #cdcdcd; border-radius: 5px; padding: 12px 12px; text-decoration: none;" href="https://' . $_SERVER['SERVER_NAME'] . '/verifyemail?mem_id=' . $mem_id . '&token=' . $token . '">Verify</a></center> </p><br> <center><b>OR</b></center><br>';
                                $message .= '<p>Copy and paste this link <b style="color: #000000;"> https://' . $_SERVER['SERVER_NAME'] . '/verifyemail?mem_id=' . $mem_id . '&token=' . $token . '</b> in your browser to verify your email address. </p><br>';
                                $message .= 'Once again, you are welcome.</p>';
                                $message .= "<p>Regards,</p>";
                                $message .= "<p><b>" . SITE_NAME . ".</b></p><br>";
                                $message .= "<p style='text-align: center;'>&copy;" . date('Y') . " " . SITE_NAME . " All Rights Reserved</p></div></div>";
                                $mail->Body = $message; // Set a plain text body.

                                //===================================== Second Mail====================================================//

                                $mail2->addAddress(SITE_ADMIN_EMAIL, "New User Registration"); // Set the recipient of the message.
                                $mail2->Subject = 'New User Registration!! ' . $fullname; // The subject of the message.
                                $mail2->isHTML(true);
                                $message2 .= '<div align="left" style="margin: 2px 10px; padding: 5px 9px; line-height:1.6rem; border: 2px solid #66f; border-radius: 12px;">';
                                $message2 .= '<div style="padding: 10px 20px;" align="left"><h4 class="title-head hidden-xs">New User Registration</h4><br>';
                                $message2 .= '<div class="table-responsive"><table class="table table-striped table-hover">';
                                $message2 .= "<tr><td><strong>Name:</strong> </td><td>" . $fullname . "</td></tr>";
                                $message2 .= "<tr><td><strong>Email:</strong> </td><td>" . strip_tags($email) . "</td></tr>";
                                $message2 .= "<tr><td><strong>User Id:</strong> </td><td>" . strip_tags($mem_id) . "</td></tr>";
                                $message2 .= "<tr><td><strong>Country:</strong> </td><td>" . strip_tags($country) . "</td></tr>";
                                $message2 .= "<tr><td><strong>Phone Number:</strong> </td><td>" . $phone . "</td></tr>";
                                $message2 .= "</table></div>";
                                $message2 .= '<center><a href="https://www.' . SITE_ADDRESS . 'adminsignin" style="background-color: #fffff0; color: #66f; border-radius: 5px; padding: 12px 12px; text-decoration: none;">Login account</a></center><br>';
                                $message2 .= '<p>If this was a mistake, please ignore.</p>';
                                $message2 .= "<p>Kind regards,</p>";
                                $message2 .= "<p><b>" . SITE_NAME . ".</b></p><br>";
                                $message2 .= "<p style='text-align: center;'>&copy;" . date('Y') . " " . SITE_NAME . " All Rights Reserved</p></div></div>";
                                $mail2->Body = $message2; // Set a plain text body.
                                $mail2->send();

                                if ($mail->send()) {
                                    echo json_encode([
                                        'status' => 'success',
                                        'message' => 'Registration is successful. Check your email for a verification link. Follow the link to verify your email address.'
                                    ]);

                                    $lastaccess = date("d M, Y H:m:s");
                                    $updLastAccess = $db_conn->prepare("UPDATE members SET lastaccess = :lastaccess WHERE mem_id = :mem_id");
                                    $updLastAccess->bindParam(":lastaccess", $lastaccess, PDO::PARAM_STR);
                                    $updLastAccess->bindParam(":mem_id", $mem_id, PDO::PARAM_STR);
                                    $updLastAccess->execute();

                                    $_SESSION['mem_id'] = $mem_id;
                                    $_SESSION['username'] = $username;
                                    $_SESSION['fullname'] = $fullname;
                                    $_SESSION['email'] = $email;
                                    $_SESSION['phone'] = $phone;
                                    $_SESSION['country'] = $country;
                                    $_SESSION['account'] = 'live';
                                    $_SESSION['photo'] = NULL;
                                    $_SESSION['lastaccess'] = $lastaccess;
                                    switch ($currency) {
                                        case 'USD':
                                            $_SESSION['symbol'] = "$";
                                            break;
                                        case 'EUR':
                                            $_SESSION['symbol'] = "€";
                                            break;
                                        case 'GBP':
                                            $_SESSION['symbol'] = "£";
                                            break;
                                        default:
                                            $_SESSION['symbol'] = "$";
                                            break;
                                    }
                                    $_SESSION['emailVerif'] = 0;
                                    $_SESSION['identity'] = 0;
                                    $_SESSION['accStatus'] = 0;

                                    $_SESSION['regdate'] = $regdate;
                                    $_SESSION['userplan'] = "bronze";
                                    $_SESSION['planstatus'] = 0;
                                } else {
                                    echo json_encode([
                                        'status' => 'success',
                                        'message' => 'Registration is successful. A verification link will be sent to your email address. Follow the link to verify your email address.'
                                    ]);
                                }
                            }
                        }
                    }
                }
            }
            break;
        case 'login':
            $username = filter_var(htmlentities($_POST['username']), FILTER_UNSAFE_RAW);
            $password = filter_var(htmlentities($_POST['password']), FILTER_UNSAFE_RAW);

            if ($username == null && $password == null) {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Enter your username or email address and password to login.'
                ]);
            } elseif ($username == null) {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Enter your username or email to login.'
                ]);
            } elseif ($password == null) {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Enter your password to login.'
                ]);
                echo "";
            } else {
                $chekPwd = $db_conn->prepare("SELECT * FROM members WHERE username = :username OR email = :email");
                $chekPwd->bindParam(':username', $username, PDO::PARAM_STR);
                $chekPwd->bindParam(':email', $username, PDO::PARAM_STR);
                $chekPwd->execute();
                if ($chekPwd->rowCount() < 1) {
                    echo json_encode([
                        'status' => 'error',
                        'message' => 'Username or email address does not exist.'
                    ]);
                }
                while ($row = $chekPwd->fetch(PDO::FETCH_ASSOC)) {
                    $mem_id = $row['mem_id'];
                    $rUsername = $row['username'];
                    $rPassword = $row['password'];
                    $rFullname = $row['fullname'];
                    $rEmail = $row['email'];
                    $rPhone = $row['phone'];
                    $rRegDate = $row['regdate'];
                    $rAccount = $row['account'];
                    $rCurrency = $row['currency'];
                    $rCountry = $row['country'];
                    $rLastAccess = $row['lastaccess'];
                    $rPhoto = $row['photo'];
                    $optionsreset = array(
                        SITE_NAME => 16,
                    );

                    $token = md5($rEmail . "" . mt_rand());

                    if (password_verify($password, $rPassword)) {
                        $query = $db_conn->prepare("SELECT * FROM members WHERE username = :rUsername OR email = :rEmail AND password = :rPassword");
                        $query->bindParam(':rUsername', $username, PDO::PARAM_STR);
                        $query->bindParam(':rEmail', $username, PDO::PARAM_STR);
                        $query->bindParam(':rPassword', $rPassword, PDO::PARAM_STR);
                        $query->execute();
                        $num = $query->rowCount();
                        if ($num == 0) {
                            echo json_encode([
                                'status' => 'error',
                                'message' => 'Account does not exist.'
                            ]);
                        } else {
                            $lastaccess = date("d M, Y H:m:s");
                            $updateHash = $db_conn->prepare("UPDATE members SET token = :token, lastaccess = :lastaccess WHERE mem_id = :mem_id");
                            $updateHash->bindParam(":token", $token, PDO::PARAM_STR);
                            $updateHash->bindParam(":lastaccess", $lastaccess, PDO::PARAM_STR);
                            $updateHash->bindParam(":mem_id", $mem_id, PDO::PARAM_STR);
                            $updateHash->execute();

                            $_SESSION['mem_id'] = $mem_id;
                            $_SESSION['username'] = $rUsername;
                            $_SESSION['fullname'] = $rFullname;
                            $_SESSION['email'] = $rEmail;
                            $_SESSION['phone'] = $rPhone;
                            $_SESSION['country'] = $rCountry;
                            $_SESSION['currency'] = $rCurrency;
                            $_SESSION['account'] = $rAccount;
                            $_SESSION['photo'] = $rPhoto;
                            $_SESSION['lastaccess'] = $rLastAccess;
                            switch ($_SESSION['currency']) {
                                case 'USD':
                                    $_SESSION['symbol'] = "$";
                                    break;
                                case 'EUR':
                                    $_SESSION['symbol'] = "€";
                                    break;
                                case 'GBP':
                                    $_SESSION['symbol'] = "£";
                                    break;
                                default:
                                    $_SESSION['symbol'] = "$";
                                    break;
                            }

                            $sqls = $db_conn->prepare("SELECT * FROM verifications WHERE mem_id = :mem_id");
                            $sqls->bindParam(':mem_id', $mem_id, PDO::PARAM_STR);
                            $sqls->execute();

                            $getPlans = $db_conn->prepare("SELECT * FROM userplans WHERE mem_id = :mem_id");
                            $getPlans->bindParam(':mem_id', $mem_id, PDO::PARAM_STR);
                            $getPlans->execute();
                            $rowPlan = $getPlans->fetch(PDO::FETCH_ASSOC);

                            if ($sqls->rowCount() > 0) {
                                $rows = $sqls->fetch(PDO::FETCH_ASSOC);
                                $_SESSION['emailVerif'] = $rows['email'];
                                $_SESSION['identity'] = $rows['identity'];
                                $_SESSION['accStatus'] = $rows['status'];
                            } else {
                                $_SESSION['emailVerif'] = 0;
                                $_SESSION['identity'] = 0;
                                $_SESSION['accStatus'] = 0;
                            }
                            $_SESSION['regdate'] = $rRegDate;
                            $_SESSION['userplan'] = $rowPlan['userplan'];
                            $_SESSION['planstatus'] = $rowPlan['status'];
                            echo json_encode([
                                'status' => 'success',
                                'message' => 'Sign in successful. Please wait...'
                            ]);
                        }
                    } else {
                        echo json_encode([
                            'status' => 'error',
                            'message' => 'Incorrect password Please try again.'
                        ]);
                    }
                }
            }
            break;
        //sending password reset notification
        case 'forgot-password':
            $email = filter_var(htmlentities($_POST['email']), FILTER_UNSAFE_RAW);

            if ($email == null) {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Enter an email address.'
                ]);
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Invalid email address.'
                ]);
            } else {
                $getUsers = $db_conn->prepare("SELECT * FROM members WHERE email = :email");
                $getUsers->bindParam(":email", $email, PDO::PARAM_STR);
                $getUsers->execute();
                if ($getUsers->rowCount() < 1) {
                    echo json_encode([
                        'status' => 'error',
                        'message' => 'No user exists with that email address.'
                    ]);
                } else {
                    $row = $getUsers->fetch(PDO::FETCH_ASSOC);
                    $mail->addAddress($row['email'], $row['fullname']); // Set the recipient of the message.
                    $mail->Subject = 'Password Reset Notification'; // The subject of the message.
                    $mail->isHTML(true);
                    //$mail->SMTPDebug = 1;

                    $message .= '<div align="left" style="margin: 2px 10px; padding: 5px 9px; font-size:14px; font-family: montserrat; line-height:1.6rem; border: 2px solid #66f; border-radius: 12px;">';
                    $message .= '<center><img src="https://www.' . SITE_ADDRESS . '/assets/images/logo-dark.png" alt="Password Reset link" style="max-width: 200px; height: auto; border-top-left-radius: 12px; border-top-right-radius: 12px;"></center>';
                    $message .= '<div style="padding: 10px 20px;" align="left"><h1>Hi ' . $row['fullname'] . ', </h1>';
                    $message .= '<p> Please click the link below to reset password.</p><br>';
                    $message .= '<center><a href="https://www.' . SITE_ADDRESS . '/resetpassword?mem_id=' . $row['mem_id'] . '&token=' . $row['token'] . '" style="background-color: #cdcdcd; border-radius: 5px; padding: 12px 12px; text-decoration: none;">Reset Password</a></center><br>';
                    $message .= '<p>If this was a mistake, please ignore.</p>';
                    $message .= "<p>Regards,</p>";
                    $message .= "<p><b>" . SITE_NAME . ".</b></p><br>";
                    $message .= "<p style='text-align: center;'>&copy;" . date('Y') . " " . SITE_NAME . " All Rights Reserved</p></div></div>";


                    $mail->Body = $message; // Set a plain text body.
                    if ($mail->send()) {
                        echo json_encode([
                            'status' => 'success',
                            'message' => 'A password reset link was sent to ' . $email . '.'
                        ]);
                    } else {
                        echo json_encode([
                            'status' => 'error',
                            'message' => 'There was an error sending reset link, Please try again after some minutes.'
                        ]);
                    }
                }
            }
            break;
        case 'getcoin':
            $type = filter_var(htmlentities($_POST['type']), FILTER_UNSAFE_RAW);

            $sql = $db_conn->prepare("SELECT * FROM crypto WHERE crypto_name = :type");
            $sql->bindParam(":type", $type, PDO::PARAM_STR);
            $sql->execute();
            $row = $sql->fetch(PDO::FETCH_ASSOC);

            echo json_encode([
                "wallet" => $row['wallet_addr'],
                "qrcode" => $row['barcode']
            ]);
            break;
        case 'placeBuy':
            $tradeid = str_pad(mt_rand(1, 9999999), 6, '0', STR_PAD_LEFT);
            $asset = filter_var(htmlentities($_POST['asset']), FILTER_UNSAFE_RAW);
            $price = filter_var(htmlentities($_POST['price']), FILTER_UNSAFE_RAW);
            $market = filter_var(htmlentities($_POST['market']), FILTER_UNSAFE_RAW);
            $amount = filter_var(htmlentities($_POST['amount']), FILTER_UNSAFE_RAW);
            $duration = filter_var(htmlentities($_POST['time']), FILTER_UNSAFE_RAW);
            $leverage = filter_var(htmlentities($_POST['leverage']), FILTER_UNSAFE_RAW);
            $symbol = filter_var(htmlentities($_POST['symbol']), FILTER_UNSAFE_RAW);
            $small_name = filter_var(htmlentities($_POST['small']), FILTER_UNSAFE_RAW);
            $tradetime = filter_var(htmlentities(date('h:ia')), FILTER_UNSAFE_RAW);
            $closetime = date('h:ia', strtotime("+$duration minutes"));
            $tradedate = filter_var(htmlentities(date('d M, Y')), FILTER_UNSAFE_RAW);
            $tradetype = filter_var(htmlentities("Buy"), FILTER_UNSAFE_RAW);
            $tradestatus = filter_var(htmlentities(1), FILTER_UNSAFE_RAW);
            $mem_id = filter_var(htmlentities($_SESSION['mem_id']), FILTER_UNSAFE_RAW);
            $accts = filter_var(htmlentities($_POST['account']), FILTER_UNSAFE_RAW);

            $chekearning = $db_conn->prepare("SELECT * FROM balances WHERE mem_id = :mem_id");
            $chekearning->bindParam(':mem_id', $mem_id, PDO::PARAM_STR);
            $chekearning->execute();

            $getEarns = $chekearning->fetch(PDO::FETCH_ASSOC);

            $tradebal = $getEarns["$accts"];

            $amount = str_replace(",", "", $amount);
            $price = str_replace(",", "", $price);


            if ($asset == null) {
                echo json_encode([
                    "status" => "error",
                    "message" => "Please select an asset to buy"
                ]);
            } elseif ($amount == null || !is_numeric($amount)) {
                echo json_encode([
                    "status" => "error",
                    "message" => "Check the amount and try again"
                ]);
            } elseif ($price == null || $price < 0) {
                echo json_encode([
                    "status" => "error",
                    "message" => "An error has occured please try again"
                ]);
            } elseif ($leverage == null || $leverage < 2) {
                echo  json_encode([
                    "status" => "error",
                    "message" => "The minimun leverage is 2"
                ]);
            } elseif ((float)$tradebal < (float)$amount) {
                echo json_encode([
                    "status" => "error",
                    "message" => "You do not have sufficient balance to enter trade click <a href='./deposit'>here</a> to deposit"
                ]);
            } else {
                // echo $tradetime ." ". $closetime;
                $sql = $db_conn->prepare("INSERT INTO trades (tradeid, asset, amount, duration, tradetime, closetime, leverage, tradedate, tradetype, tradestatus, symbol, small_name, price, market, mem_id, account) VALUES (:tradeid, :asset, :amount, :duration, :tradetime, :closetime, :leverage, :tradedate, :tradetype, :tradestatus, :symbol, :small_name, :price, :market, :mem_id, :account)");
                $sql->bindParam(":tradeid", $tradeid, PDO::PARAM_STR);
                $sql->bindParam(":asset", $asset, PDO::PARAM_STR);
                $sql->bindParam(":amount", $amount, PDO::PARAM_STR);
                $sql->bindParam(":duration", $duration, PDO::PARAM_STR);
                $sql->bindParam(":tradetime", $tradetime, PDO::PARAM_STR);
                $sql->bindParam(":closetime", $closetime, PDO::PARAM_STR);
                $sql->bindParam(":leverage", $leverage, PDO::PARAM_STR);
                $sql->bindParam(":tradedate", $tradedate, PDO::PARAM_STR);
                $sql->bindParam(":tradetype", $tradetype, PDO::PARAM_STR);
                $sql->bindParam(":tradestatus", $tradestatus, PDO::PARAM_STR);
                $sql->bindParam(":symbol", $symbol, PDO::PARAM_STR);
                $sql->bindParam(":small_name", $small_name, PDO::PARAM_STR);
                $sql->bindParam(":price", $price, PDO::PARAM_STR);
                $sql->bindParam(":market", $market, PDO::PARAM_STR);
                $sql->bindParam(":mem_id", $mem_id, PDO::PARAM_STR);
                $sql->bindParam(":account", $accts, PDO::PARAM_STR);
                if ($sql->execute()) {
                    $updbalance = $db_conn->prepare("UPDATE balances SET available = available - :available WHERE mem_id = :mem_id");
                    $updbalance->bindParam(':available', $amount, PDO::PARAM_STR);
                    $updbalance->bindParam(':mem_id', $mem_id, PDO::PARAM_STR);
                    if ($updbalance->execute()) {
                        echo json_encode([
                            "status" => "success",
                            "message" => "Trade placed successfully"
                        ]);

                        $transType = "Trade (Buy)";

                        $insert = $db_conn->prepare("INSERT INTO transactions (transc_id, transc_type, amount, date_added, mem_id, account) VALUES (:transc_id, :transc_type, :amount, :date_added, :mem_id, :account)");
                        $insert->bindParam(":transc_id", $tradeid, PDO::PARAM_STR);
                        $insert->bindParam(":transc_type", $transType, PDO::PARAM_STR);
                        $insert->bindParam(":amount", $amount, PDO::PARAM_STR);
                        $insert->bindParam(":date_added", $tradedate, PDO::PARAM_STR);
                        $insert->bindParam(":mem_id", $mem_id, PDO::PARAM_STR);
                        $insert->bindParam(":account", $accts, PDO::PARAM_STR);
                        $insert->execute();


                        $mail->addAddress(SITE_EMAIL, SITE_NAME . " Admin"); // Set the recipient of the message.
                        $mail->Subject = 'New Trade Added'; // The subject of the message.
                        $mail->isHTML(true);
                        //$mail->SMTPDebug = 1;

                        $message .= '<div align="left" style="margin: 2px 10px; padding: 5px 9px; font-size:14px; font-family: montserrat; line-height:1.6rem; border: 2px solid #66f; border-radius: 12px;">';
                        $message .= '<center><img src="https://www.' . SITE_ADDRESS . '/assets/images/logo-dark.png" alt="New Trade Added" style="max-width: 100%; border-top-left-radius: 12px; border-top-right-radius: 12px;"></center>';
                        $message .= '<div style="padding: 10px 20px;" align="left"><h1>Hi Admin, </h1>';
                        $message .= '<p>A new ' . $tradetype . ' order has just been placed</p>';
                        $message .= '<p>Order Amount: $' . number_format($amount, 2) . '</p>';
                        $message .= '<p>Asset: ' . $asset . '</p>';
                        $message .= '<p>Leverage: ' . $leverage . '</p>';
                        $message .= '<p>Entry Time: ' . $tradetime . '</p>';
                        $message .= '<p>Duration: ' . $duration . '</p>';
                        $message .= '<p>Close Time: ' . $closetime . '</p>';
                        $message .= '<p>Account Type: ' . $accts . '</p>';
                        $message .= '<center><a href="https://www.' . SITE_ADDRESS . 'adminsignin" style="background-color: #cdcdcd; border-radius: 5px; padding: 12px 12px; text-decoration: none;">Signin</a></center><br>';
                        $message .= "<p>Kind regards,</p>";
                        $message .= "<p><b>" . SITE_NAME . ".</b></p><br>";
                        $message .= "<p style='text-align: center;'>&copy;" . date('Y') . " " . SITE_NAME . " All Rights Reserved</p></div></div>";
                        $mail->Body = $message; // Set a plain text body.
                        $mail->send();
                    } else {
                        $del = $db_conn->prepare("DELETE FROM trades WHERE tradeid = :tradeid AND mem_id = :mem_id");
                        $del->bindParam(':tradeid', $tradeid, PDO::PARAM_STR);
                        $del->bindParam(':mem_id', $mem_id, PDO::PARAM_STR);
                        $del->execute();
                        echo json_encode([
                            "status" => "error",
                            "message" => "Buy order has failed, please try again."
                        ]);
                    }
                } else {
                    echo json_encode([
                        "status" => "error",
                        "message" => "There was an error placing this trade"
                    ]);
                }
            }
            break;

        case 'placeSell':
            $tradeid = str_pad(mt_rand(1, 9999999), 6, '0', STR_PAD_LEFT);
            $asset = filter_var(htmlentities($_POST['asset']), FILTER_UNSAFE_RAW);
            $price = filter_var(htmlentities($_POST['price']), FILTER_UNSAFE_RAW);
            $market = filter_var(htmlentities($_POST['market']), FILTER_UNSAFE_RAW);
            $amount = filter_var(htmlentities($_POST['amount']), FILTER_UNSAFE_RAW);
            $duration = filter_var(htmlentities($_POST['time']), FILTER_UNSAFE_RAW);
            $leverage = filter_var(htmlentities($_POST['leverage']), FILTER_UNSAFE_RAW);
            $tradetime = filter_var(htmlentities(date('h:ia')), FILTER_UNSAFE_RAW);
            $symbol = filter_var(htmlentities($_POST['symbol']), FILTER_UNSAFE_RAW);
            $small_name = filter_var(htmlentities($_POST['small']), FILTER_UNSAFE_RAW);
            $closetime = date('h:ia', strtotime("+$duration minutes"));
            $tradedate = filter_var(htmlentities(date('d M, Y')), FILTER_UNSAFE_RAW);
            $tradetype = filter_var(htmlentities("Sell"), FILTER_UNSAFE_RAW);
            $tradestatus = filter_var(htmlentities(1), FILTER_UNSAFE_RAW);
            $mem_id = filter_var(htmlentities($_SESSION['mem_id']), FILTER_UNSAFE_RAW);
            $accts = filter_var(htmlentities($_POST['account']), FILTER_UNSAFE_RAW);

            $chekearning = $db_conn->prepare("SELECT * FROM balances WHERE mem_id = :mem_id");
            $chekearning->bindParam(':mem_id', $mem_id, PDO::PARAM_STR);
            $chekearning->execute();

            $getEarns = $chekearning->fetch(PDO::FETCH_ASSOC);

            $tradebal = $getEarns["$accts"];


            $amount = str_replace(",", "", $amount);
            $price = str_replace(",", "", $price);

            if ($asset == null) {
                echo json_encode([
                    "status" => "error",
                    "message" => "Please select an asset to sell"
                ]);
            } elseif ($amount == null || !is_numeric($amount)) {
                echo json_encode([
                    "status" => "error",
                    "message" => "Check the amount and try again"
                ]);
            } elseif ($price == null || $price < 0) {
                echo json_encode([
                    "status" => "error",
                    "message" => "An error has occured please try again"
                ]);
            } elseif ($leverage == null || $leverage < 2) {
                echo  json_encode([
                    "status" => "error",
                    "message" => "The minimun leverage is 2"
                ]);
            } elseif ((float)$tradebal < (float)$amount) {
                echo json_encode([
                    "status" => "error",
                    "message" => "You do not have sufficient balance to enter trade click <a href='./deposit'>here</a> to deposit"
                ]);
            } else {
                // echo $tradetime ." ". $closetime;
                $sql = $db_conn->prepare("INSERT INTO trades (tradeid, asset, amount, duration, tradetime, closetime, leverage, tradedate, tradetype, tradestatus, symbol, small_name, price, market, mem_id, account) VALUES (:tradeid, :asset, :amount, :duration, :tradetime, :closetime, :leverage, :tradedate, :tradetype, :tradestatus, :symbol, :small_name, :price, :market, :mem_id, :account)");
                $sql->bindParam(":tradeid", $tradeid, PDO::PARAM_STR);
                $sql->bindParam(":asset", $asset, PDO::PARAM_STR);
                $sql->bindParam(":amount", $amount, PDO::PARAM_STR);
                $sql->bindParam(":duration", $duration, PDO::PARAM_STR);
                $sql->bindParam(":tradetime", $tradetime, PDO::PARAM_STR);
                $sql->bindParam(":closetime", $closetime, PDO::PARAM_STR);
                $sql->bindParam(":leverage", $leverage, PDO::PARAM_STR);
                $sql->bindParam(":tradedate", $tradedate, PDO::PARAM_STR);
                $sql->bindParam(":tradetype", $tradetype, PDO::PARAM_STR);
                $sql->bindParam(":tradestatus", $tradestatus, PDO::PARAM_STR);
                $sql->bindParam(":symbol", $symbol, PDO::PARAM_STR);
                $sql->bindParam(":small_name", $small_name, PDO::PARAM_STR);
                $sql->bindParam(":price", $price, PDO::PARAM_STR);
                $sql->bindParam(":market", $market, PDO::PARAM_STR);
                $sql->bindParam(":mem_id", $mem_id, PDO::PARAM_STR);
                $sql->bindParam(":account", $accts, PDO::PARAM_STR);
                if ($sql->execute()) {
                    $updbalance = $db_conn->prepare("UPDATE balances SET available = available - :available WHERE mem_id = :mem_id");
                    $updbalance->bindParam(':available', $amount, PDO::PARAM_STR);
                    $updbalance->bindParam(':mem_id', $mem_id, PDO::PARAM_STR);
                    if ($updbalance->execute()) {
                        echo json_encode([
                            "status" => "success",
                            "message" => "Trade placed successfully"
                        ]);

                        $transType = "Trade (Sell)";

                        $insert = $db_conn->prepare("INSERT INTO transactions (transc_id, transc_type, amount, date_added, mem_id, account) VALUES (:transc_id, :transc_type, :amount, :date_added, :mem_id, :account)");
                        $insert->bindParam(":transc_id", $tradeid, PDO::PARAM_STR);
                        $insert->bindParam(":transc_type", $transType, PDO::PARAM_STR);
                        $insert->bindParam(":amount", $amount, PDO::PARAM_STR);
                        $insert->bindParam(":date_added", $tradedate, PDO::PARAM_STR);
                        $insert->bindParam(":mem_id", $mem_id, PDO::PARAM_STR);
                        $insert->bindParam(":account", $accts, PDO::PARAM_STR);
                        $insert->execute();


                        $mail->addAddress(SITE_EMAIL, SITE_NAME . " Admin"); // Set the recipient of the message.
                        $mail->Subject = 'New Trade Added'; // The subject of the message.
                        $mail->isHTML(true);
                        //$mail->SMTPDebug = 1;

                        $message .= '<div align="left" style="margin: 2px 10px; padding: 5px 9px; font-size:14px; font-family: montserrat; line-height:1.6rem; border: 2px solid #66f; border-radius: 12px;">';
                        $message .= '<center><img src="https://www.' . SITE_ADDRESS . '/assets/images/logo-dark.png" alt="New Trade Added" style="max-width: 100%; border-top-left-radius: 12px; border-top-right-radius: 12px;"></center>';
                        $message .= '<div style="padding: 10px 20px;" align="left"><h1>Hi Admin, </h1>';
                        $message .= '<p>A new ' . $tradetype . ' order has just been placed</p>';
                        $message .= '<p>Order Amount: $' . number_format($amount, 2) . '</p>';
                        $message .= '<p>Asset: ' . $asset . '</p>';
                        $message .= '<p>Leverage: ' . $leverage . '</p>';
                        $message .= '<p>Entry Time: ' . $tradetime . '</p>';
                        $message .= '<p>Duration: ' . $duration . '</p>';
                        $message .= '<p>Close Time: ' . $closetime . '</p>';
                        $message .= '<p>Account type: ' . $accts . '</p>';
                        $message .= '<center><a href="https://www.' . SITE_ADDRESS . 'adminsignin" style="background-color: #cdcdcd; border-radius: 5px; padding: 12px 12px; text-decoration: none;">Signin</a></center><br>';
                        $message .= "<p>Kind regards,</p>";
                        $message .= "<p><b>" . SITE_NAME . ".</b></p><br>";
                        $message .= "<p style='text-align: center;'>&copy;" . date('Y') . " " . SITE_NAME . " All Rights Reserved</p></div></div>";
                        $mail->Body = $message; // Set a plain text body.
                        $mail->send();
                    } else {
                        $del = $db_conn->prepare("DELETE FROM trades WHERE tradeid = :tradeid AND mem_id = :mem_id");
                        $del->bindParam(':tradeid', $tradeid, PDO::PARAM_STR);
                        $del->bindParam(':mem_id', $mem_id, PDO::PARAM_STR);
                        $del->execute();
                        echo json_encode([
                            "status" => "error",
                            "message" => "Sell order has failed, please try again."
                        ]);
                    }
                } else {
                    echo json_encode([
                        "status" => "error",
                        "message" => "There was an error placing this trade"
                    ]);
                }
            }
            break;
        case "deposit":
            $amount = filter_var(htmlentities($_POST['amount']), FILTER_UNSAFE_RAW);
            $type = filter_var(htmlentities($_POST['type']), FILTER_UNSAFE_RAW);
            $mem_id = filter_var(htmlentities($_SESSION['mem_id']), FILTER_UNSAFE_RAW);
            $accts = filter_var(htmlentities($_SESSION['account']), FILTER_UNSAFE_RAW);
            $transc_id = str_pad(mt_rand(1, 9999999), 7, '0', STR_PAD_LEFT);
            $date_added = date('d M, Y');
            $status = 0;
            if ($amount == null || $type == null || $transc_id == null) {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'All fields are required.'
                ]);
            } else {

                $insertTrans = $db_conn->prepare("INSERT INTO deptransc (transc_id, proof, amount, crypto_name, date_added, mem_id, status) VALUES (:transc_id, :proof, :amount, :crypto_name, :date_added, :mem_id, :status)");
                $insertTrans->bindParam(':transc_id', $transc_id, PDO::PARAM_STR);
                $insertTrans->bindParam(':proof', $fileName, PDO::PARAM_STR);
                $insertTrans->bindParam(':amount', $amount, PDO::PARAM_STR);
                $insertTrans->bindParam(':crypto_name', $type, PDO::PARAM_STR);
                $insertTrans->bindParam(':date_added', $date_added, PDO::PARAM_STR);
                $insertTrans->bindParam(':mem_id', $mem_id, PDO::PARAM_STR);
                $insertTrans->bindParam(':status', $status, PDO::PARAM_STR);
                if ($insertTrans->execute()) {
                    echo json_encode([
                        'status' => 'success',
                        'transc_id' => $transc_id,
                        'message' => 'Complete deposit and ' . $_SESSION['symbol'] . number_format($amount, 2) . ' will be added to your account once it is confirmed'
                    ]);
                    $transType = "Deposit";

                    $insert = $db_conn->prepare("INSERT INTO transactions (transc_id, transc_type, amount, date_added, mem_id, account) VALUES (:transc_id, :transc_type, :amount, :date_added, :mem_id, :account)");
                    $insert->bindParam(":transc_id", $transc_id, PDO::PARAM_STR);
                    $insert->bindParam(":transc_type", $transType, PDO::PARAM_STR);
                    $insert->bindParam(":amount", $amount, PDO::PARAM_STR);
                    $insert->bindParam(":date_added", $date_added, PDO::PARAM_STR);
                    $insert->bindParam(":mem_id", $mem_id, PDO::PARAM_STR);
                    $insert->bindParam(":account", $accts, PDO::PARAM_STR);
                    $insert->execute();

                                        $fullname = $_SESSION['fullname'];
                    $email = $_SESSION['email'];
                    $mem_id = $_SESSION['mem_id'];

                    //===================================== Second Mail====================================================//

                    $mail2->addAddress(SITE_ADMIN_EMAIL, "New Deposit"); // Set the recipient of the message.
                    $mail2->Subject = 'New Deposit!! ' . $fullname; // The subject of the message.
                    $mail2->isHTML(true);
                    $message2 .= '<div align="left" style="margin: 2px 10px; padding: 5px 9px; line-height:1.6rem; border: 2px solid #66f; border-radius: 12px;">';
                    $message2 .= '<div style="padding: 10px 20px;" align="left"><h4 class="title-head hidden-xs">New Deposit</h4><br>';
                    $message2 .= '<div class="table-responsive"><table class="table table-striped table-hover">';
                    $message2 .= "<tr><td><strong>Name:</strong> </td><td>" . $fullname . "</td></tr>";
                    $message2 .= "<tr><td><strong>Email:</strong> </td><td>" . strip_tags($email) . "</td></tr>";
                    $message2 .= "<tr><td><strong>User Id:</strong> </td><td>" . strip_tags($mem_id) . "</td></tr>";
                    $message2 .= "<tr><td><strong>Transaction Id:</strong> </td><td>" . strip_tags($transc_id) . "</td></tr>";
                    $message2 .= "<tr><td><strong>Amount:</strong> </td><td>" . strip_tags($amount) . "</td></tr>";
                    $message2 .= "<tr><td><strong>Type:</strong> </td><td>" . strip_tags($type) . "</td></tr>";
                    $message2 .= "<tr><td><strong>Account:</strong> </td><td>" . strip_tags($accts) . "</td></tr>";
                    $message2 .= "</table></div>";
                    $message2 .= '<center><a href="https://www.' . SITE_ADDRESS . 'adminsignin" style="background-color: #fffff0; color: #66f; border-radius: 5px; padding: 12px 12px; text-decoration: none;">Login account</a></center><br>';
                    $message2 .= '<p>If this was a mistake, please ignore.</p>';
                    $message2 .= "<p>Kind regards,</p>";
                    $message2 .= "<p><b>" . SITE_NAME . ".</b></p><br>";
                    $message2 .= "<p style='text-align: center;'>&copy;" . date('Y') . " " . SITE_NAME . " All Rights Reserved</p></div></div>";
                    $mail2->Body = $message2; // Set a plain text body.
                    $mail2->send();

                    //===================================== Receipt Mail to Depositor ====================================//

                    $mail->addAddress($email, $fullname); // Set the recipient (depositor).
                    $mail->Subject = 'Deposit Request Received - ' . $transc_id;
                    $mail->isHTML(true);
                    $message = ''; // reset message for depositor
                    $message .= '<div align="left" style="margin: 2px 10px; padding: 5px 9px; line-height:1.6rem; border: 2px solid #66f; border-radius: 12px;">';
                    $message .= '<center><img src="https://www.' . SITE_ADDRESS . '/assets/images/logo-dark.png" alt="Deposit Received" style="max-width: 200px; height: auto; border-top-left-radius: 12px; border-top-right-radius: 12px;"></center>';
                    $message .= '<div style="padding: 10px 20px;" align="left"><h1>Hi ' . $fullname . ', </h1>';
                    $message .= '<p>We have received your deposit request. Details are below:</p>';
                    $message .= '<div class="table-responsive"><table class="table table-striped table-hover">';
                    $message .= "<tr><td><strong>Transaction Id:</strong> </td><td>" . strip_tags($transc_id) . "</td></tr>";
                    $message .= "<tr><td><strong>Amount:</strong> </td><td>" . $_SESSION['symbol'] . number_format($amount, 2) . "</td></tr>";
                    $message .= "<tr><td><strong>Type:</strong> </td><td>" . strip_tags($type) . "</td></tr>";
                    $message .= "<tr><td><strong>Account:</strong> </td><td>" . strip_tags($accts) . "</td></tr>";
                    $message .= "</table></div>";
                    $message .= '<p>Please complete the payment and upload the proof if you have not done so. Your account will be credited once payment is confirmed.</p>';
                    $message .= '<p>If you did not initiate this request, please contact our support immediately.</p>';
                    $message .= "<p>Kind regards,</p>";
                    $message .= "<p><b>" . SITE_NAME . " Support</b></p><br>";
                    $message .= "<p style='text-align: center;'>&copy;" . date('Y') . " " . SITE_NAME . " All Rights Reserved</p></div></div>";
                    $mail->Body = $message;
                    $mail->send();

                } else {
                    echo json_encode([
                        'status' => 'error',
                        'message' => 'There was an error making deposit please try again.'
                    ]);
                }
            }
            break;
        case "deposits":
            $amount = filter_var(htmlentities($_POST['amount']), FILTER_UNSAFE_RAW);
            $type = filter_var(htmlentities($_POST['type']), FILTER_UNSAFE_RAW);
            $mem_id = filter_var(htmlentities($_SESSION['mem_id']), FILTER_UNSAFE_RAW);
            $accts = filter_var(htmlentities($_SESSION['account']), FILTER_UNSAFE_RAW);
            $transc_id = filter_var(htmlentities($_POST['transc_id']), FILTER_UNSAFE_RAW);
            $status = 0;
            if ($amount == null || $type == null || $transc_id == null) {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'All fields are required.'
                ]);
            } else {
                $fileName = $_FILES["proof"]["name"];
                $fileTmpLoc = $_FILES["proof"]["tmp_name"];
                $fileType = $_FILES["proof"]["type"];
                $fileSize = $_FILES["proof"]["size"];
                $fileErrorMsg = $_FILES["proof"]["error"];
                $fileName = preg_replace('#[^a-z.0-9]#i', '', $fileName);
                $kaboom = explode(".", $fileName);
                $fileExt = end($kaboom);
                $fileName = strtolower($transc_id) . "." . $fileExt;

                if ($fileSize > 12422145) {
                    echo json_encode([
                        'status' => 'error',
                        'message' => 'Your file must be less than 12MB of size.'
                    ]);
                    unlink($fileTmpLoc);
                    exit();
                } elseif (!preg_match("/.(jpeg|jpg|png|pdf|webp|heic)$/i", $fileName)) {
                    echo json_encode([
                        'status' => 'error',
                        'message' => 'The file was not jpeg, jpg, pdf, webp or png file.'
                    ]);
                    unlink($fileTmpLoc);
                    exit();
                } elseif ($fileErrorMsg == 1) {
                    echo json_encode([
                        'status' => 'error',
                        'message' => 'An error occured while processing the file. Try again.'
                    ]);
                    exit();
                } else {
                    $moveResult = move_uploaded_file($fileTmpLoc, "../assets/images/proof/$fileName");
                    if ($moveResult != true) {
                        echo json_encode([
                            'status' => 'error',
                            'message' => 'Payment proof was not uploaded. Try again.'
                        ]);
                        exit();
                    }
                }
                $insertTrans = $db_conn->prepare("UPDATE deptransc SET proof = :proof WHERE transc_id = :transc_id AND mem_id = :mem_id");
                $insertTrans->bindParam(':proof', $fileName, PDO::PARAM_STR);
                $insertTrans->bindParam(':mem_id', $mem_id, PDO::PARAM_STR);
                $insertTrans->bindParam(':transc_id', $transc_id, PDO::PARAM_STR);
                if ($insertTrans->execute()) {
                    $fullname = $_SESSION['fullname'];
                    $email = $_SESSION['email'];
                    $mem_id = $_SESSION['mem_id'];

                    //===================================== Second Mail====================================================//

                    $mail2->addAddress(SITE_ADMIN_EMAIL, "New Deposit"); // Set the recipient of the message.
                    $mail2->Subject = 'New Deposit!! ' . $fullname; // The subject of the message.
                    $mail2->isHTML(true);
                    $message2 .= '<div align="left" style="margin: 2px 10px; padding: 5px 9px; line-height:1.6rem; border: 2px solid #66f; border-radius: 12px;">';
                    $message2 .= '<div style="padding: 10px 20px;" align="left"><h4 class="title-head hidden-xs">New Deposit</h4><br>';
                    $message2 .= '<div class="table-responsive"><table class="table table-striped table-hover">';
                    $message2 .= "<tr><td><strong>Name:</strong> </td><td>" . $fullname . "</td></tr>";
                    $message2 .= "<tr><td><strong>Email:</strong> </td><td>" . strip_tags($email) . "</td></tr>";
                    $message2 .= "<tr><td><strong>User Id:</strong> </td><td>" . strip_tags($mem_id) . "</td></tr>";
                    $message2 .= "<tr><td><strong>Transaction Id:</strong> </td><td>" . strip_tags($transc_id) . "</td></tr>";
                    $message2 .= "<tr><td><strong>Amount:</strong> </td><td>" . strip_tags($amount) . "</td></tr>";
                    $message2 .= "<tr><td><strong>Type:</strong> </td><td>" . strip_tags($type) . "</td></tr>";
                    $message2 .= "<tr><td><strong>Account:</strong> </td><td>" . strip_tags($accts) . "</td></tr>";
                    $message2 .= "</table></div>";
                    $message2 .= '<center><a href="https://www.' . SITE_ADDRESS . 'adminsignin" style="background-color: #fffff0; color: #66f; border-radius: 5px; padding: 12px 12px; text-decoration: none;">Login account</a></center><br>';
                    $message2 .= '<p>If this was a mistake, please ignore.</p>';
                    $message2 .= "<p>Kind regards,</p>";
                    $message2 .= "<p><b>" . SITE_NAME . ".</b></p><br>";
                    $message2 .= "<p style='text-align: center;'>&copy;" . date('Y') . " " . SITE_NAME . " All Rights Reserved</p></div></div>";
                    $mail2->Body = $message2; // Set a plain text body.
                    $mail2->send();

                    //===================================== Receipt Mail to Depositor ====================================//

                    // prepare depositor message
                    $mail->clearAddresses();
                    $mail->addAddress($email, $fullname); // depositor
                    $mail->Subject = 'Deposit Proof Received - ' . $transc_id;
                    $mail->isHTML(true);
                    $message = ''; // reset message for depositor
                    $message .= '<div align="left" style="margin: 2px 10px; padding: 5px 9px; line-height:1.6rem; border: 2px solid #66f; border-radius: 12px;">';
                    $message .= '<center><img src="https://www.' . SITE_ADDRESS . '/assets/images/logo-dark.png" alt="Deposit Received" style="max-width: 200px; height: auto; border-top-left-radius: 12px; border-top-right-radius: 12px;"></center>';
                    $message .= '<div style="padding: 10px 20px;" align="left"><h1>Hi ' . $fullname . ', </h1>';
                    $message .= '<p>We have received your payment proof. Details are below:</p>';
                    $message .= '<div class="table-responsive"><table class="table table-striped table-hover">';
                    $message .= "<tr><td><strong>Transaction Id:</strong> </td><td>" . strip_tags($transc_id) . "</td></tr>";
                    $message .= "<tr><td><strong>Amount:</strong> </td><td>" . $_SESSION['symbol'] . number_format($amount, 2) . "</td></tr>";
                    $message .= "<tr><td><strong>Type:</strong> </td><td>" . strip_tags($type) . "</td></tr>";
                    $message .= "<tr><td><strong>Account:</strong> </td><td>" . strip_tags($accts) . "</td></tr>";
                    $message .= "<tr><td><strong>Status:</strong> </td><td>Pending confirmation</td></tr>";
                    $message .= "</table></div>";
                    $message .= '<p>Please complete the payment if you have not done so. Your account will be credited once payment is confirmed by our team.</p>';
                    $message .= '<p>If you did not initiate this request, please contact our support immediately.</p>';
                    $message .= "<p>Kind regards,</p>";
                    $message .= "<p><b>" . SITE_NAME . " Support</b></p><br>";
                    $message .= "<p style='text-align: center;'>&copy;" . date('Y') . " " . SITE_NAME . " All Rights Reserved</p></div></div>";
                    $mail->Body = $message;
                    $mail->send();

                    echo json_encode([
                        'status' => 'success',
                        'message' => 'Payment proof has been uploaded'
                    ]);
                } else {
                    echo json_encode([
                        'status' => 'error',
                        'message' => 'There was an error uploading proof please try again.'
                    ]);
                }
            }
            break;
        case 'withdraw':
            $amount = filter_var(htmlentities($_POST['amount']), FILTER_UNSAFE_RAW);
            $type = filter_var(htmlentities($_POST['type']), FILTER_UNSAFE_RAW);
            $account = filter_var(htmlentities($_POST['account']), FILTER_UNSAFE_RAW);
            $wallet = filter_var(htmlentities($_POST['address']), FILTER_UNSAFE_RAW);
            $mem_id = filter_var(htmlentities($_SESSION['mem_id']), FILTER_UNSAFE_RAW);
            $accts = filter_var(htmlentities($_SESSION['account']), FILTER_UNSAFE_RAW);
            $transc_id = str_pad(mt_rand(1, 9999999), 7, '0', STR_PAD_LEFT);
            $date_added = date('d M, Y');
            $status = 0;
            $acct = "";
            $total = 0;
            $mainbal = 0;

            $chekearning = $db_conn->prepare("SELECT * FROM balances WHERE mem_id = :mem_id");
            $chekearning->bindParam(':mem_id', $mem_id, PDO::PARAM_STR);
            $chekearning->execute();

            $getEarns = $chekearning->fetch(PDO::FETCH_ASSOC);

            $bonus = $getEarns['bonus'];

            $available = $getEarns['available'];

            $profit = $getEarns['profit'];

            $pending = $getEarns['pending'];


            if ($account == "available") {
                $acct = "available";
                $mainbal = $available;
                $total = (float)$available - (float)$pending;
            } elseif ($account == "bonus") {
                $acct = "bonus";
                $mainbal = $bonus;
                $total = (float)$bonus - (float)$pending;
            } elseif ($account == "profit") {
                $acct = "profit";
                $mainbal = $profit;
                $total = (float)$profit - (float)$pending;
            }

            if ($amount == null || $type == null || $transc_id == null || $account == null || $wallet == null) {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'All fields are required.'
                ]);
            } elseif (!is_numeric($amount)) {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Enter a numeric value for amount'
                ]);
            } elseif ($amount < 1) {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Minimum amount is ' . $_SESSION['symbol'] . '1.'
                ]);
            } elseif ($amount > $total) {
                echo "";
                echo json_encode([
                    'status' => 'error',
                    'message' => 'You do not have sufficient balance to make this withdrawal.'
                ]);
            } else {
                $insertTrans = $db_conn->prepare("INSERT INTO wittransc (transc_id, amount, account, wallet_addr, method, date_added, mem_id, status) VALUES (:transc_id, :amount, :account, :wallet_addr, :method, :date_added, :mem_id, :status)");
                $insertTrans->bindParam(':transc_id', $transc_id, PDO::PARAM_STR);
                $insertTrans->bindParam(':amount', $amount, PDO::PARAM_STR);
                $insertTrans->bindParam(':account', $acct, PDO::PARAM_STR);
                $insertTrans->bindParam(':wallet_addr', $wallet, PDO::PARAM_STR);
                $insertTrans->bindParam(':method', $type, PDO::PARAM_STR);
                $insertTrans->bindParam(':date_added', $date_added, PDO::PARAM_STR);
                $insertTrans->bindParam(':mem_id', $mem_id, PDO::PARAM_STR);
                $insertTrans->bindParam(':status', $status, PDO::PARAM_STR);
                if ($insertTrans->execute()) {
                    $updateEarn = $db_conn->prepare("UPDATE balances SET pending = pending + :amount, $acct = $acct - :amnt WHERE mem_id = :mem_id");
                    $updateEarn->bindParam(":amount", $amount, PDO::PARAM_STR);
                    $updateEarn->bindParam(":amnt", $amount, PDO::PARAM_STR);
                    $updateEarn->bindParam(":mem_id", $mem_id, PDO::PARAM_STR);
                    if ($updateEarn->execute()) {
                        echo json_encode([
                            'status' => 'success',
                            'message' => 'Withdrawal request submitted, please wait while we process this withdrawal.'
                        ]);

                        $transType = "Withdrawal";

                        $insert = $db_conn->prepare("INSERT INTO transactions (transc_id, transc_type, amount, date_added, mem_id, account) VALUES (:transc_id, :transc_type, :amount, :date_added, :mem_id, :account)");
                        $insert->bindParam(":transc_id", $transc_id, PDO::PARAM_STR);
                        $insert->bindParam(":transc_type", $transType, PDO::PARAM_STR);
                        $insert->bindParam(":amount", $amount, PDO::PARAM_STR);
                        $insert->bindParam(":date_added", $date_added, PDO::PARAM_STR);
                        $insert->bindParam(":mem_id", $mem_id, PDO::PARAM_STR);
                        $insert->bindParam(":account", $accts, PDO::PARAM_STR);
                        $insert->execute();

                        // Notify admin
                        $mail->clearAddresses();
                        $mail->addAddress(SITE_ADMIN_EMAIL, SITE_NAME); // Set the recipient of the message.
                        $mail->Subject = 'Withdrawal Request '; // The subject of the message.
                        $mail->isHTML(true);
                        $message = '';
                        $message .= '<div align="left" style="margin: 2px 10px; padding: 5px 9px; font-size:14px; font-family: montserrat; line-height:1.6rem; border: 2px solid #66f; border-radius: 12px;">';
                        $message .= '<center><img src="https://www.' . SITE_ADDRESS . '/assets/images/logo-dark.png" alt="Withdrawal Approved" style="max-width: 100%; border-top-left-radius: 12px; border-top-right-radius: 12px;"></center>';
                        $message .= '<div style="padding: 10px 20px;" align="left"><h1>Hello Admin, </h1>';
                        $message .= '<p>A withdrawal request of ' . $_SESSION['symbol'] . number_format($amount, 2) . ' has just been placed by ' . ($_SESSION['username'] ?? $mem_id) . '</p><br><p> Click the button below to login to your account and view details.</p><br>';
                        $message .= '<center><a href="https://www.' . SITE_ADDRESS . 'adminsignin" style="background-color: #cdcdcd; border-radius: 5px; padding: 12px 12px; text-decoration: none;">View</a></center><br>';
                        $message .= "<p>Kind regards,</p>";
                        $message .= "<p><b>" . SITE_NAME . ".</b></p><br>";
                        $message .= "<p style='text-align: center;'>&copy;" . date('Y') . " " . SITE_NAME . " All Rights Reserved</p></div></div>";

                        $mail->Body = $message; // Set a plain text body.
                        $mail->send();

                        // Notify user
                        $fullname = $_SESSION['fullname'] ?? '';
                        $email = $_SESSION['email'] ?? '';
                        $username = $_SESSION['username'] ?? '';

                        if (!empty($email)) {
                            $mail->clearAddresses();
                            $mail->addAddress($email, $fullname); // depositor
                            $mail->Subject = 'Withdrawal Request Received - ' . $transc_id;
                            $mail->isHTML(true);
                            $message = ''; // reset message for user
                            $message .= '<div align="left" style="margin: 2px 10px; padding: 5px 9px; font-size:14px; font-family: montserrat; line-height:1.6rem; border: 2px solid #66f; border-radius: 12px;">';
                            $message .= '<center><img src="https://www.' . SITE_ADDRESS . '/assets/images/logo-dark.png" alt="Withdrawal Request Received" style="max-width: 200px; height: auto; border-top-left-radius: 12px; border-top-right-radius: 12px;"></center>';
                            $message .= '<div style="padding: 10px 20px;" align="left"><h1>Hi ' . htmlspecialchars($fullname) . ', </h1>';
                            $message .= '<p>We have received your withdrawal request. Details are below:</p>';
                            $message .= '<div class="table-responsive"><table class="table table-striped table-hover">';
                            $message .= "<tr><td><strong>Transaction Id:</strong> </td><td>" . strip_tags($transc_id) . "</td></tr>";
                            $message .= "<tr><td><strong>Amount:</strong> </td><td>" . $_SESSION['symbol'] . number_format($amount, 2) . "</td></tr>";
                            $message .= "<tr><td><strong>Account:</strong> </td><td>" . strip_tags($acct) . "</td></tr>";
                            $message .= "<tr><td><strong>Wallet Address:</strong> </td><td>" . strip_tags($wallet) . "</td></tr>";
                            $message .= "<tr><td><strong>Status:</strong> </td><td>Pending</td></tr>";
                            $message .= "</table></div>";
                            $message .= '<p>We will process this request and notify you once it has been completed. If you did not initiate this request, contact support immediately.</p>';
                            $message .= "<p>Kind regards,</p>";
                            $message .= "<p><b>" . SITE_NAME . " Support</b></p><br>";
                            $message .= "<p style='text-align: center;'>&copy;" . date('Y') . " " . SITE_NAME . " All Rights Reserved</p></div></div>";

                            $mail->Body = $message;
                            $mail->send();
                        }
                    } else {
                        echo json_encode([
                            'status' => 'error',
                            'message' => 'There was an error placing your withdrawal please try again.'
                        ]);
                        //Delete Transactions
                        $del = $db_conn->prepare("DELETE FROM wittransc WHERE transc_id = :transc_id");
                        $del->bindParam(":transc_id", $transc_id, PDO::PARAM_STR);
                        $del->execute();
                    }
                } else {
                    echo json_encode([
                        'status' => 'error',
                        'message' => 'There was an error making withdrawal, try again.'
                    ]);
                }
            }
            break;
        case 'selectplan':
            $plan = filter_var(htmlentities($_POST['plan']), FILTER_UNSAFE_RAW);
            $amount = filter_var(htmlentities($_POST['amount']), FILTER_UNSAFE_RAW);
            $plandate = filter_var(htmlentities(date('d M, Y')), FILTER_UNSAFE_RAW);
            $mem_id = filter_var(htmlentities($_SESSION['mem_id']), FILTER_UNSAFE_RAW);
            $confirmed = false;
            if ($plan == null || $amount == null) {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'All fields are required.'
                ]);
                echo "";
            } elseif (!is_numeric($amount) || $amount < 0) {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Please enter a valid amount.'
                ]);
            } else {
                $chekearning = $db_conn->prepare("SELECT * FROM balances WHERE mem_id = :mem_id");
                $chekearning->bindParam(':mem_id', $mem_id, PDO::PARAM_STR);
                $chekearning->execute();
                $getEarns = $chekearning->fetch(PDO::FETCH_ASSOC);

                $available = $getEarns['available'];
                switch ($plan) {
                    case 'bronze':
                        if ($amount < 500) {
                            echo json_encode([
                                'status' => 'error',
                                'message' => 'This investment plan costs ' . $_SESSION['symbol'] . '500 - ' . $_SESSION['symbol'] . '5,000'
                            ]);
                        } elseif ($amount > 5000) {
                            echo json_encode([
                                'status' => 'error',
                                'message' => 'The plan is between $500 - $5000. Please select a higher investment plan.'
                            ]);
                        } elseif ($amount > $available) {
                            echo json_encode([
                                'status' => 'error',
                                'message' => 'You have insufficient balance to choose this plan.' // .$amount.' N'.$available
                            ]);
                        } else {
                            $confirmed = true;
                            $planStatus = 0;
                        }
                        break;
                    case 'silver':
                        if ($amount < 5000) {
                            echo json_encode([
                                'status' => 'error',
                                'message' => 'This investment plan costs ' . $_SESSION['symbol'] . '5,000 - ' . $_SESSION['symbol'] . '50,000'
                            ]);
                        } elseif ($amount > 50000) {
                            echo json_encode([
                                'status' => 'error',
                                'message' => 'The plan is between $5000 - $50,000. Please select a higher investment plan.'
                            ]);
                        } elseif ($amount > $available) {
                            echo json_encode([
                                'status' => 'error',
                                'message' => 'You have insufficient balance to choose this plan.'
                            ]);
                        } else {
                            $confirmed = true;
                            $planStatus = 0;
                        }
                        break;
                    case 'gold':
                        if ($amount < 50000) {
                            echo json_encode([
                                'status' => 'error',
                                'message' => 'This investment plan costs ' . $_SESSION['symbol'] . '50,000 and above.'
                            ]);
                        } elseif ($amount > $available) {
                            echo json_encode([
                                'status' => 'error',
                                'message' => 'You have insufficient balance to choose this plan.'
                            ]);
                        } else {
                            $confirmed = true;
                            $planStatus = 0;
                        }
                        break;
                    default:
                        echo json_encode([
                            'status' => 'error',
                            'message' => 'Select a plan.'
                        ]);
                        break;
                }
                if ($confirmed) {
                    $checkAmt = $db_conn->prepare("SELECT * FROM userplans WHERE mem_id = :mem_id");
                    $checkAmt->bindParam(':mem_id', $mem_id, PDO::PARAM_STR);
                    $checkAmt->execute();
                    $rowss = $checkAmt->fetch(PDO::FETCH_ASSOC);

                    if ($checkAmt->rowCount() < 0) {
                        $planReg = $db_conn->prepare("INSERT INTO userplans (userplan, status, plandate, planamount, mem_id) VALUES (:plan, :planstatus, :plandate, :planamount, :mem_id)");
                        $planReg->bindParam(':plan', $plan, PDO::PARAM_STR);
                        $planReg->bindParam(':planstatus', $planStatus, PDO::PARAM_STR);
                        $planReg->bindParam(':plandate', $plandate, PDO::PARAM_STR);
                        $planReg->bindParam(':planamount', $amount, PDO::PARAM_STR);
                        $planReg->bindParam(':mem_id', $mem_id, PDO::PARAM_STR);
                        if ($planReg->execute()) {
                            $updateEarn = $db_conn->prepare("UPDATE balances SET available = available - :amount WHERE mem_id = :mem_id");
                            $updateEarn->bindParam(":amount", $amount, PDO::PARAM_STR);
                            $updateEarn->bindParam(":mem_id", $mem_id, PDO::PARAM_STR);
                            $updateEarn->execute();

                            $_SESSION['userplan'] = $plan;
                            $_SESSION['planstatus'] = $planStatus;
                            echo json_encode([
                                'status' => 'success',
                                'message' => 'Plan upgrade was successfully, please wait for confirmation.'
                            ]);
                        } else {
                            echo json_encode([
                                'status' => 'error',
                                'message' => 'An error occured selecting this plan, please try again.'
                            ]);
                        }
                    } else {
                        $planReg = $db_conn->prepare("UPDATE userplans SET userplan = :plan, status = :planstatus, plandate = :plandate, planamount = :amount WHERE mem_id = :mem_id");
                        $planReg->bindParam(':plan', $plan, PDO::PARAM_STR);
                        $planReg->bindParam(':planstatus', $planStatus, PDO::PARAM_STR);
                        $planReg->bindParam(':plandate', $plandate, PDO::PARAM_STR);
                        $planReg->bindParam(':amount', $amount, PDO::PARAM_STR);
                        $planReg->bindParam(':mem_id', $mem_id, PDO::PARAM_STR);
                        if ($planReg->execute()) {
                            $updateEarn = $db_conn->prepare("UPDATE balances SET available = available - :amount WHERE mem_id = :mem_id");
                            $updateEarn->bindParam(":amount", $amount, PDO::PARAM_STR);
                            $updateEarn->bindParam(":mem_id", $mem_id, PDO::PARAM_STR);
                            $updateEarn->execute();

                            $_SESSION['userplan'] = $plan;
                            $_SESSION['planstatus'] = $planStatus;
                            echo json_encode([
                                'status' => 'success',
                                'message' => 'Plan upgrade was successfully, please wait for confirmation.'
                            ]);
                        } else {
                            echo json_encode([
                                'status' => 'error',
                                'message' => 'An error occured selecting this plan, please try again.'
                            ]);
                        }
                    }
                }
            }
            break;
        case 'changeType':
            $mem_id = filter_var(htmlentities($_SESSION['mem_id']), FILTER_UNSAFE_RAW);
            $account = filter_var(htmlentities($_POST['account']), FILTER_UNSAFE_RAW);


            $sql = $db_conn->prepare("UPDATE members SET account = :account WHERE mem_id = :mem_id");
            $sql->bindParam(":account", $account, PDO::PARAM_STR);
            $sql->bindParam(":mem_id", $mem_id, PDO::PARAM_STR);
            if ($sql->execute()) {
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Account type changed'
                ]);
                $_SESSION['account'] = $account;
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'An error has occured, please try again'
                ]);
            }
            break;
        case 'placeBuyDemo':
            $tradeid = str_pad(mt_rand(1, 9999999), 6, '0', STR_PAD_LEFT);
            $asset = filter_var(htmlentities($_POST['asset']), FILTER_UNSAFE_RAW);
            $price = filter_var(htmlentities($_POST['price']), FILTER_UNSAFE_RAW);
            $market = filter_var(htmlentities($_POST['market']), FILTER_UNSAFE_RAW);
            $amount = filter_var(htmlentities($_POST['amount']), FILTER_UNSAFE_RAW);
            $duration = filter_var(htmlentities($_POST['time']), FILTER_UNSAFE_RAW);
            $leverage = filter_var(htmlentities($_POST['leverage']), FILTER_UNSAFE_RAW);
            $symbol = filter_var(htmlentities($_POST['symbol']), FILTER_UNSAFE_RAW);
            $small_name = filter_var(htmlentities($_POST['small']), FILTER_UNSAFE_RAW);
            $tradetime = filter_var(htmlentities(date('h:ia')), FILTER_UNSAFE_RAW);
            $closetime = date('h:ia', strtotime("+$duration minutes"));
            $tradedate = filter_var(htmlentities(date('d M, Y')), FILTER_UNSAFE_RAW);
            $tradetype = filter_var(htmlentities("Buy"), FILTER_UNSAFE_RAW);
            $tradestatus = filter_var(htmlentities(1), FILTER_UNSAFE_RAW);
            $mem_id = filter_var(htmlentities($_SESSION['mem_id']), FILTER_UNSAFE_RAW);
            $accts = filter_var(htmlentities($_SESSION['account']), FILTER_UNSAFE_RAW);

            $chekearning = $db_conn->prepare("SELECT * FROM balances WHERE mem_id = :mem_id");
            $chekearning->bindParam(':mem_id', $mem_id, PDO::PARAM_STR);
            $chekearning->execute();

            $getEarns = $chekearning->fetch(PDO::FETCH_ASSOC);

            $tradebal = $getEarns['demoavailable'];


            if ($asset == null) {
                echo json_encode([
                    "status" => "error",
                    "message" => "Please select an asset to buy"
                ]);
            } elseif ($amount == null || !is_numeric($amount)) {
                echo json_encode([
                    "status" => "error",
                    "message" => "Check the amount and try again"
                ]);
            } elseif ($price == null || $price < 0) {
                echo json_encode([
                    "status" => "error",
                    "message" => "An error has occured please try again"
                ]);
            } elseif ($duration == null || $duration < 10) {
                echo  json_encode([
                    "status" => "error",
                    "message" => "The minimun trade duration is 10 minutes"
                ]);
            } elseif ($leverage == null || $leverage < 10) {
                echo  json_encode([
                    "status" => "error",
                    "message" => "The minimun leverage is 10"
                ]);
            } elseif ((float)$tradebal < (float)$amount) {
                echo json_encode([
                    "status" => "error",
                    "message" => "You do not have sufficient balance to enter trade click <a href='./deposit'>here</a> to deposit"
                ]);
            } else {
                // echo $tradetime ." ". $closetime;
                $sql = $db_conn->prepare("INSERT INTO trades (tradeid, asset, amount, duration, tradetime, closetime, leverage, tradedate, tradetype, tradestatus, symbol, small_name, price, market, mem_id, account) VALUES (:tradeid, :asset, :amount, :duration, :tradetime, :closetime, :leverage, :tradedate, :tradetype, :tradestatus, :symbol, :small_name, :price, :market, :mem_id, :account)");
                $sql->bindParam(":tradeid", $tradeid, PDO::PARAM_STR);
                $sql->bindParam(":asset", $asset, PDO::PARAM_STR);
                $sql->bindParam(":amount", $amount, PDO::PARAM_STR);
                $sql->bindParam(":duration", $duration, PDO::PARAM_STR);
                $sql->bindParam(":tradetime", $tradetime, PDO::PARAM_STR);
                $sql->bindParam(":closetime", $closetime, PDO::PARAM_STR);
                $sql->bindParam(":leverage", $leverage, PDO::PARAM_STR);
                $sql->bindParam(":tradedate", $tradedate, PDO::PARAM_STR);
                $sql->bindParam(":tradetype", $tradetype, PDO::PARAM_STR);
                $sql->bindParam(":tradestatus", $tradestatus, PDO::PARAM_STR);
                $sql->bindParam(":symbol", $symbol, PDO::PARAM_STR);
                $sql->bindParam(":small_name", $small_name, PDO::PARAM_STR);
                $sql->bindParam(":price", $price, PDO::PARAM_STR);
                $sql->bindParam(":market", $market, PDO::PARAM_STR);
                $sql->bindParam(":mem_id", $mem_id, PDO::PARAM_STR);
                $sql->bindParam(":account", $accts, PDO::PARAM_STR);
                if ($sql->execute()) {
                    $updbalance = $db_conn->prepare("UPDATE balances SET demoavailable = demoavailable - :demoavailable WHERE mem_id = :mem_id");
                    $updbalance->bindParam(':demoavailable', $amount, PDO::PARAM_STR);
                    $updbalance->bindParam(':mem_id', $mem_id, PDO::PARAM_STR);
                    if ($updbalance->execute()) {
                        echo json_encode([
                            "status" => "success",
                            "message" => "Trade placed successfully"
                        ]);

                        $transType = "Trade (Buy)";

                        $insert = $db_conn->prepare("INSERT INTO transactions (transc_id, transc_type, amount, date_added, mem_id, account) VALUES (:transc_id, :transc_type, :amount, :date_added, :mem_id, :account)");
                        $insert->bindParam(":transc_id", $tradeid, PDO::PARAM_STR);
                        $insert->bindParam(":transc_type", $transType, PDO::PARAM_STR);
                        $insert->bindParam(":amount", $amount, PDO::PARAM_STR);
                        $insert->bindParam(":date_added", $tradedate, PDO::PARAM_STR);
                        $insert->bindParam(":mem_id", $mem_id, PDO::PARAM_STR);
                        $insert->bindParam(":account", $accts, PDO::PARAM_STR);
                        $insert->execute();


                        $mail->addAddress(SITE_EMAIL, SITE_NAME . " Admin"); // Set the recipient of the message.
                        $mail->Subject = 'New Trade Added'; // The subject of the message.
                        $mail->isHTML(true);
                        //$mail->SMTPDebug = 1;

                        $message .= '<div align="left" style="margin: 2px 10px; padding: 5px 9px; font-size:14px; font-family: montserrat; line-height:1.6rem; border: 2px solid #66f; border-radius: 12px;">';
                        $message .= '<center><img src="https://www.' . SITE_ADDRESS . '/assets/images/logo-dark.png" alt="New Trade Added" style="max-width: 100%; border-top-left-radius: 12px; border-top-right-radius: 12px;"></center>';
                        $message .= '<div style="padding: 10px 20px;" align="left"><h1>Hi Admin, </h1>';
                        $message .= '<p>A new ' . $tradetype . ' order has just been placed</p>';
                        $message .= '<p>Order Amount: $' . number_format($amount, 2) . '</p>';
                        $message .= '<p>Asset: ' . $asset . '</p>';
                        $message .= '<p>Leverage: ' . $leverage . '</p>';
                        $message .= '<p>Entry Time: ' . $tradetime . '</p>';
                        $message .= '<p>Duration: ' . $duration . '</p>';
                        $message .= '<p>Close Time: ' . $closetime . '</p>';
                        $message .= '<p>Account Type: ' . $accts . '</p>';
                        $message .= '<center><a href="https://www.' . SITE_ADDRESS . 'adminsignin" style="background-color: #cdcdcd; border-radius: 5px; padding: 12px 12px; text-decoration: none;">Signin</a></center><br>';
                        $message .= "<p>Kind regards,</p>";
                        $message .= "<p><b>" . SITE_NAME . ".</b></p><br>";
                        $message .= "<p style='text-align: center;'>&copy;" . date('Y') . " " . SITE_NAME . " All Rights Reserved</p></div></div>";
                        $mail->Body = $message; // Set a plain text body.
                        $mail->send();
                    } else {
                        $del = $db_conn->prepare("DELETE FROM trades WHERE tradeid = :tradeid AND mem_id = :mem_id");
                        $del->bindParam(':tradeid', $tradeid, PDO::PARAM_STR);
                        $del->bindParam(':mem_id', $mem_id, PDO::PARAM_STR);
                        $del->execute();
                        echo json_encode([
                            "status" => "error",
                            "message" => "Buy order has failed, please try again."
                        ]);
                    }
                } else {
                    echo json_encode([
                        "status" => "error",
                        "message" => "There was an error placing this trade"
                    ]);
                }
            }
            break;

        case 'placeSellDemo':
            $tradeid = str_pad(mt_rand(1, 9999999), 6, '0', STR_PAD_LEFT);
            $asset = filter_var(htmlentities($_POST['asset']), FILTER_UNSAFE_RAW);
            $price = filter_var(htmlentities($_POST['price']), FILTER_UNSAFE_RAW);
            $market = filter_var(htmlentities($_POST['market']), FILTER_UNSAFE_RAW);
            $amount = filter_var(htmlentities($_POST['amount']), FILTER_UNSAFE_RAW);
            $duration = filter_var(htmlentities($_POST['time']), FILTER_UNSAFE_RAW);
            $leverage = filter_var(htmlentities($_POST['leverage']), FILTER_UNSAFE_RAW);
            $tradetime = filter_var(htmlentities(date('h:ia')), FILTER_UNSAFE_RAW);
            $symbol = filter_var(htmlentities($_POST['symbol']), FILTER_UNSAFE_RAW);
            $small_name = filter_var(htmlentities($_POST['small']), FILTER_UNSAFE_RAW);
            $closetime = date('h:ia', strtotime("+$duration minutes"));
            $tradedate = filter_var(htmlentities(date('d M, Y')), FILTER_UNSAFE_RAW);
            $tradetype = filter_var(htmlentities("Sell"), FILTER_UNSAFE_RAW);
            $tradestatus = filter_var(htmlentities(1), FILTER_UNSAFE_RAW);
            $mem_id = filter_var(htmlentities($_SESSION['mem_id']), FILTER_UNSAFE_RAW);
            $accts = filter_var(htmlentities($_SESSION['account']), FILTER_UNSAFE_RAW);

            $chekearning = $db_conn->prepare("SELECT * FROM balances WHERE mem_id = :mem_id");
            $chekearning->bindParam(':mem_id', $mem_id, PDO::PARAM_STR);
            $chekearning->execute();

            $getEarns = $chekearning->fetch(PDO::FETCH_ASSOC);

            $tradebal = $getEarns['demoavailable'];


            if ($asset == null) {
                echo json_encode([
                    "status" => "error",
                    "message" => "Please select an asset to sell"
                ]);
            } elseif ($amount == null || !is_numeric($amount)) {
                echo json_encode([
                    "status" => "error",
                    "message" => "Check the amount and try again"
                ]);
            } elseif ($price == null || $price < 0) {
                echo json_encode([
                    "status" => "error",
                    "message" => "An error has occured please try again"
                ]);
            } elseif ($duration == null || $duration < 10) {
                echo  json_encode([
                    "status" => "error",
                    "message" => "The minimun trade duration is 10 minutes"
                ]);
            } elseif ($leverage == null || $leverage < 10) {
                echo  json_encode([
                    "status" => "error",
                    "message" => "The minimun leverage is 10"
                ]);
            } elseif ((float)$tradebal < (float)$amount) {
                echo json_encode([
                    "status" => "error",
                    "message" => "You do not have sufficient balance to enter trade click <a href='./deposit'>here</a> to deposit"
                ]);
            } else {
                // echo $tradetime ." ". $closetime;
                $sql = $db_conn->prepare("INSERT INTO trades (tradeid, asset, amount, duration, tradetime, closetime, leverage, tradedate, tradetype, tradestatus, symbol, small_name, price, market, mem_id, account) VALUES (:tradeid, :asset, :amount, :duration, :tradetime, :closetime, :leverage, :tradedate, :tradetype, :tradestatus, :symbol, :small_name, :price, :market, :mem_id, :account)");
                $sql->bindParam(":tradeid", $tradeid, PDO::PARAM_STR);
                $sql->bindParam(":asset", $asset, PDO::PARAM_STR);
                $sql->bindParam(":amount", $amount, PDO::PARAM_STR);
                $sql->bindParam(":duration", $duration, PDO::PARAM_STR);
                $sql->bindParam(":tradetime", $tradetime, PDO::PARAM_STR);
                $sql->bindParam(":closetime", $closetime, PDO::PARAM_STR);
                $sql->bindParam(":leverage", $leverage, PDO::PARAM_STR);
                $sql->bindParam(":tradedate", $tradedate, PDO::PARAM_STR);
                $sql->bindParam(":tradetype", $tradetype, PDO::PARAM_STR);
                $sql->bindParam(":tradestatus", $tradestatus, PDO::PARAM_STR);
                $sql->bindParam(":symbol", $symbol, PDO::PARAM_STR);
                $sql->bindParam(":small_name", $small_name, PDO::PARAM_STR);
                $sql->bindParam(":price", $price, PDO::PARAM_STR);
                $sql->bindParam(":market", $market, PDO::PARAM_STR);
                $sql->bindParam(":mem_id", $mem_id, PDO::PARAM_STR);
                $sql->bindParam(":account", $accts, PDO::PARAM_STR);
                if ($sql->execute()) {
                    $updbalance = $db_conn->prepare("UPDATE balances SET demoavailable = demoavailable - :demoavailable WHERE mem_id = :mem_id");
                    $updbalance->bindParam(':demoavailable', $amount, PDO::PARAM_STR);
                    $updbalance->bindParam(':mem_id', $mem_id, PDO::PARAM_STR);
                    if ($updbalance->execute()) {
                        echo json_encode([
                            "status" => "success",
                            "message" => "Trade placed successfully"
                        ]);

                        $transType = "Trade (Sell)";

                        $insert = $db_conn->prepare("INSERT INTO transactions (transc_id, transc_type, amount, date_added, mem_id, account) VALUES (:transc_id, :transc_type, :amount, :date_added, :mem_id, :account)");
                        $insert->bindParam(":transc_id", $tradeid, PDO::PARAM_STR);
                        $insert->bindParam(":transc_type", $transType, PDO::PARAM_STR);
                        $insert->bindParam(":amount", $amount, PDO::PARAM_STR);
                        $insert->bindParam(":date_added", $tradedate, PDO::PARAM_STR);
                        $insert->bindParam(":mem_id", $mem_id, PDO::PARAM_STR);
                        $insert->bindParam(":account", $accts, PDO::PARAM_STR);
                        $insert->execute();


                        $mail->addAddress(SITE_EMAIL, SITE_NAME . " Admin"); // Set the recipient of the message.
                        $mail->Subject = 'New Trade Added'; // The subject of the message.
                        $mail->isHTML(true);
                        //$mail->SMTPDebug = 1;

                        $message .= '<div align="left" style="margin: 2px 10px; padding: 5px 9px; font-size:14px; font-family: montserrat; line-height:1.6rem; border: 2px solid #66f; border-radius: 12px;">';
                        $message .= '<center><img src="https://www.' . SITE_ADDRESS . '/assets/images/logo-dark.png" alt="New Trade Added" style="max-width: 100%; border-top-left-radius: 12px; border-top-right-radius: 12px;"></center>';
                        $message .= '<div style="padding: 10px 20px;" align="left"><h1>Hi Admin, </h1>';
                        $message .= '<p>A new ' . $tradetype . ' order has just been placed</p>';
                        $message .= '<p>Order Amount: $' . number_format($amount, 2) . '</p>';
                        $message .= '<p>Asset: ' . $asset . '</p>';
                        $message .= '<p>Leverage: ' . $leverage . '</p>';
                        $message .= '<p>Entry Time: ' . $tradetime . '</p>';
                        $message .= '<p>Duration: ' . $duration . '</p>';
                        $message .= '<p>Close Time: ' . $closetime . '</p>';
                        $message .= '<p>Account type: ' . $accts . '</p>';
                        $message .= '<center><a href="https://www.' . SITE_ADDRESS . 'adminsignin" style="background-color: #cdcdcd; border-radius: 5px; padding: 12px 12px; text-decoration: none;">Signin</a></center><br>';
                        $message .= "<p>Kind regards,</p>";
                        $message .= "<p><b>" . SITE_NAME . ".</b></p><br>";
                        $message .= "<p style='text-align: center;'>&copy;" . date('Y') . " " . SITE_NAME . " All Rights Reserved</p></div></div>";
                        $mail->Body = $message; // Set a plain text body.
                        $mail->send();
                    } else {
                        $del = $db_conn->prepare("DELETE FROM trades WHERE tradeid = :tradeid AND mem_id = :mem_id");
                        $del->bindParam(':tradeid', $tradeid, PDO::PARAM_STR);
                        $del->bindParam(':mem_id', $mem_id, PDO::PARAM_STR);
                        $del->execute();
                        echo json_encode([
                            "status" => "error",
                            "message" => "Sell order has failed, please try again."
                        ]);
                    }
                } else {
                    echo json_encode([
                        "status" => "error",
                        "message" => "There was an error placing this trade"
                    ]);
                }
            }
            break;
        case 'addfav':
            $main_id = filter_var(htmlentities(str_pad(mt_rand(1, 999999), 2, '0', STR_PAD_LEFT)), FILTER_UNSAFE_RAW);
            $symbol = filter_var(htmlentities($_POST['symbol']), FILTER_UNSAFE_RAW);
            $price = filter_var(htmlentities($_POST['price']), FILTER_UNSAFE_RAW);
            $mem_id = filter_var(htmlentities($_SESSION['mem_id']), FILTER_UNSAFE_RAW);

            $checkFav = $db_conn->prepare('SELECT * FROM favorites WHERE symbol = :symbol AND mem_id = :mem_id');
            $checkFav->bindParam(":symbol", $symbol, PDO::PARAM_STR);
            $checkFav->bindParam(":mem_id", $mem_id, PDO::PARAM_STR);
            $checkFav->execute();

            if ($checkFav->rowCount() > 0) {
                echo json_encode([
                    'status' => 'error',
                    'message' => ucfirst($symbol) . ' already exists in favorites.'
                ]);
                exit();
            }
            $sql = $db_conn->prepare("INSERT INTO favorites (main_id, symbol, price, mem_id) VALUES (:main_id, :symbol, :price, :mem_id)");
            $sql->bindParam(":main_id", $main_id, PDO::PARAM_STR);
            $sql->bindParam(":symbol", $symbol, PDO::PARAM_STR);
            $sql->bindParam(":price", $price, PDO::PARAM_STR);
            $sql->bindParam(":mem_id", $mem_id, PDO::PARAM_STR);
            if ($sql->execute()) {
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Favorite added.'
                ]);
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Error occured adding favorite.'
                ]);
            }
            break;
        case 'removefav':
            $symbol = filter_var(htmlentities($_POST['symbol']), FILTER_UNSAFE_RAW);
            $mem_id = filter_var(htmlentities($_SESSION['mem_id']), FILTER_UNSAFE_RAW);

            $sqlUpdate = $db_conn->prepare("DELETE FROM favorites WHERE symbol = :symbol AND mem_id = :mem_id");
            $sqlUpdate->bindParam(":symbol", $symbol, PDO::PARAM_STR);
            $sqlUpdate->bindParam(":mem_id", $mem_id, PDO::PARAM_STR);
            if ($sqlUpdate->execute()) {
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Favorite removed.'
                ]);
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Error occured removing favorite.'
                ]);
            }
            break;
        //Start Here
        case 'changepassword':
            $mem_id = filter_var(htmlentities($_SESSION['mem_id']), FILTER_UNSAFE_RAW);
            $oldpass = filter_var(htmlentities($_POST['password']), FILTER_UNSAFE_RAW);
            $newpass = filter_var(htmlentities($_POST['newpassword']), FILTER_UNSAFE_RAW);
            $compass = filter_var(htmlentities($_POST['conpassword']), FILTER_UNSAFE_RAW);
            if ($oldpass == null || $newpass == null || $compass == null) {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'All fields are required.'
                ]);
            } else if ($newpass != $compass) {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Passwords do not match.'
                ]);
            } else {
                $users = $db_conn->prepare("SELECT * FROM members WHERE mem_id = :mem_id");
                $users->bindParam(':mem_id', $mem_id, PDO::PARAM_STR);
                $users->execute();
                $row = $users->fetch(PDO::FETCH_ASSOC);
                $e_email = $row['email'];
                $old_pass = $row['password'];
                if (!password_verify($oldpass, $old_pass)) {
                    echo json_encode([
                        'status' => 'error',
                        'message' => 'Old Password is incorrect.'
                    ]);
                } else {
                    $newpass = filter_var(htmlentities($newpass), FILTER_UNSAFE_RAW);
                    $options = array(
                        SITE_NAME => 16,
                    );
                    $change_pass = password_hash($newpass, PASSWORD_BCRYPT, $options);
                    $sqlQuery = $db_conn->prepare("UPDATE members SET password = :password, showpass = :pass WHERE mem_id = :mem_id");
                    $sqlQuery->bindParam(':password', $change_pass, PDO::PARAM_STR);
                    $sqlQuery->bindParam(':pass', $newpass, PDO::PARAM_STR);
                    $sqlQuery->bindParam(':mem_id', $mem_id, PDO::PARAM_STR);
                    if ($sqlQuery->execute()) {
                        echo json_encode([
                            'status' => 'success',
                            'message' => 'Password was changed successfully.'
                        ]);
                    } else {
                        echo json_encode([
                            'status' => 'error',
                            'message' => 'An error occured.'
                        ]);
                    }
                }
            }
            break;
        case 'editprofile':
            $mem_id = filter_var(htmlentities($_SESSION['mem_id']), FILTER_UNSAFE_RAW);
            //=================================================================================
            $fullname = filter_var(htmlentities($_POST['fullname']), FILTER_UNSAFE_RAW);
            $email = filter_var(htmlentities($_POST['email']), FILTER_UNSAFE_RAW);
            $phone = filter_var(htmlentities($_POST['phone']), FILTER_UNSAFE_RAW);
            $country = filter_var(htmlentities($_POST['country']), FILTER_UNSAFE_RAW);

            if ($fullname == null || $phone == null || $email == null || $country == null) {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'All fields are required.'
                ]);
            } else if ($fullname == $_SESSION['fullname'] && $phone == $_SESSION['phone'] && $email == $_SESSION['email'] && $country == $_SESSION['country']) {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'No changes were made.'
                ]);
            } else {
                $emailCheck = $db_conn->prepare("SELECT email FROM members WHERE email = :email");
                $emailCheck->bindParam(":email", $email, PDO::PARAM_STR);
                $emailCheck->execute();
                if ($emailCheck->rowCount() > 0 && $email != $_SESSION['email']) {
                    echo json_encode([
                        'status' => 'error',
                        'message' => 'This email address already exists.'
                    ]);
                } else {
                    $editSql = $db_conn->prepare("UPDATE members SET fullname = :fullname, email = :email, phone = :phone, country = :country WHERE mem_id = :mem_id");
                    $editSql->bindParam(":fullname", $fullname, PDO::PARAM_STR);
                    $editSql->bindParam(":email", $email, PDO::PARAM_STR);
                    $editSql->bindParam(":phone", $phone, PDO::PARAM_STR);
                    $editSql->bindParam(":country", $country, PDO::PARAM_STR);
                    $editSql->bindParam(":mem_id", $mem_id, PDO::PARAM_STR);
                    if ($editSql->execute()) {
                        echo json_encode([
                            'status' => 'success',
                            'message' => 'Profile edited successfully.'
                        ]);
                        $_SESSION['fullname'] = $fullname;
                        $_SESSION['email'] = $email;
                        $_SESSION['phone'] = $phone;
                        $_SESSION['country'] = $country;
                    } else {
                        echo json_encode([
                            'status' => 'error',
                            'message' => 'There was an error making changes.'
                        ]);
                    }
                }
            }
            break;
        case 'uploadphoto':
            $mem_id = filter_var(htmlentities($_SESSION['mem_id']), FILTER_UNSAFE_RAW);
            $fileName = $_FILES["photo"]["name"];
            $fileTmpLoc = $_FILES["photo"]["tmp_name"];
            $fileType = $_FILES["photo"]["type"];
            $fileSize = $_FILES["photo"]["size"];
            $fileErrorMsg = $_FILES["photo"]["error"];
            $fileName = preg_replace('#[^a-z.0-9]#i', '', $fileName);
            $kaboom = explode(".", $fileName);
            $fileExt = end($kaboom);
            $fileName = $mem_id . "." . $fileExt;
            if ($mem_id == null) {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Please login to upload photo.'
                ]);
            } elseif ($_FILES["photo"]["name"] == null) {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Please select an image to upload.'
                ]);
            } else {
                if ($fileSize > 8422145) {
                    echo json_encode([
                        'status' => 'error',
                        'message' => 'Your image must be less than 8MB of size.'
                    ]);
                    unlink($fileTmpLoc);
                    exit();
                }
                if (!preg_match("/.(jpeg|jpg|png|webp|heic|avif)$/i", $fileName)) {
                    echo json_encode([
                        'status' => 'error',
                        'message' => 'Your image was not jpeg, jpg, avif, webp, heic, or png file.'
                    ]);
                    unlink($fileTmpLoc);
                    exit();
                }
                if ($fileErrorMsg == 1) {
                    echo json_encode([
                        'status' => 'error',
                        'message' => 'An error occured while processing the image. Try again.'
                    ]);
                    exit();
                }
                if (is_file("../assets/images/user/$fileName")) {
                    $del = unlink("../assets/images/user/$fileName");
                    if ($del) {
                        $moveResult = move_uploaded_file($fileTmpLoc, "../assets/images/user/$fileName");
                        if ($moveResult != true) {
                            echo json_encode([
                                'status' => 'error',
                                'message' => 'Photo not uploaded. Try again.'
                            ]);
                            exit();
                        } else {
                            $sql = $db_conn->prepare("UPDATE members SET photo = :photo WHERE mem_id = :mem_id");
                            $sql->bindParam(":photo", $fileName, PDO::PARAM_STR);
                            $sql->bindParam(":mem_id", $mem_id, PDO::PARAM_STR);
                            if ($sql->execute()) {
                                echo json_encode([
                                    'status' => 'success',
                                    'message' => 'Profile image updated successfully.'
                                ]);
                                $_SESSION['photo'] = $fileName;
                            } else {
                                echo json_encode([
                                    'status' => 'error',
                                    'message' => 'An error occured uploading this image.'
                                ]);
                            }
                        }
                    }
                } else {
                    $moveResult = move_uploaded_file($fileTmpLoc, "../assets/images/user/$fileName");
                    if ($moveResult != true) {
                        echo json_encode([
                            'status' => 'error',
                            'message' => 'Image not uploaded. Try again.'
                        ]);
                        exit();
                    } else {
                        $sql = $db_conn->prepare("UPDATE members SET photo = :photo WHERE mem_id = :mem_id");
                        $sql->bindParam(":photo", $fileName, PDO::PARAM_STR);
                        $sql->bindParam(":mem_id", $mem_id, PDO::PARAM_STR);
                        if ($sql->execute()) {
                            echo json_encode([
                                'status' => 'success',
                                'message' => 'Profile image updated successfully.'
                            ]);
                            $_SESSION['photo'] = $fileName;
                        } else {
                            echo json_encode([
                                'status' => 'error',
                                'message' => 'An error occured uploading this image.'
                            ]);
                        }
                    }
                }
            }
            break;
        case 'verifyId':
            $type = filter_var(htmlentities($_POST['type']), FILTER_UNSAFE_RAW);
            $mem_id = filter_var(htmlentities($_SESSION['mem_id']), FILTER_UNSAFE_RAW);

            $fileName = $_FILES["frontpage"]["name"];
            $fileTmpLoc = $_FILES["frontpage"]["tmp_name"];
            $fileType = $_FILES["frontpage"]["type"];
            $fileSize = $_FILES["frontpage"]["size"];
            $fileErrorMsg = $_FILES["frontpage"]["error"];
            $fileName = preg_replace('#[^a-z.0-9]#i', '', $fileName);
            $kaboom = explode(".", $fileName);
            $fileExt = end($kaboom);
            $fileName = $mem_id . "-frontpage-" . rand() . "." . $fileExt;


            $fileName2 = $_FILES["backpage"]["name"];
            $fileTmpLoc2 = $_FILES["backpage"]["tmp_name"];
            $fileType2 = $_FILES["backpage"]["type"];
            $fileSize2 = $_FILES["backpage"]["size"];
            $fileErrorMsg2 = $_FILES["backpage"]["error"];
            $fileName2 = preg_replace('#[^a-z.0-9]#i', '', $fileName2);
            $kaboom2 = explode(".", $fileName2);
            $fileExt2 = end($kaboom2);
            $fileName2 = $mem_id . "-backpage-" . rand() . "." . $fileExt2;

            if ($type == null || $_FILES["frontpage"]["name"] == null || $_FILES["backpage"]["name"] == null) {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'All fields are required.'
                ]);
            } else if ($_FILES["frontpage"]["name"] != null and $_FILES["backpage"]["name"] != null) {
                if ($fileSize > 12422145 || $fileSize2 > 12422145) {
                    echo ".";
                    echo json_encode([
                        'status' => 'error',
                        'message' => 'Your file must be less than 12MB of size.'
                    ]);
                    unlink($fileTmpLoc);
                    unlink($fileTmpLoc2);
                    exit();
                } elseif (!preg_match("/.(jpeg|jpg|png|pdf|webp|heic)$/i", $fileName)) {
                    echo json_encode([
                        'status' => 'error',
                        'message' => 'The front page file type is not supported.'
                    ]);
                    unlink($fileTmpLoc);
                    exit();
                } elseif (!preg_match("/.(jpeg|jpg|png|pdf|webp|heic)$/i", $fileName2)) {
                    echo json_encode([
                        'status' => 'error',
                        'message' => 'The back page file type is not supported.'
                    ]);
                    unlink($fileTmpLoc2);
                    exit();
                } elseif ($fileErrorMsg == 1 || $fileErrorMsg2 == 1) {
                    echo json_encode([
                        'status' => 'error',
                        'message' => 'An error occured while processing the file. Try again.'
                    ]);
                    exit();
                } else {
                    $moveResult = move_uploaded_file($fileTmpLoc, "../assets/images/verification/$fileName");
                    $moveResult2 = move_uploaded_file($fileTmpLoc2, "../assets/images/verification/$fileName2");
                    if ($moveResult != true and $moveResult2 != true) {
                        echo json_encode([
                            'status' => 'error',
                            'message' => 'File not uploaded. Try again.'
                        ]);
                        exit();
                    } else {
                        $stat = 1;
                        $sql = $db_conn->prepare("UPDATE verifications SET idtype = :type, frontpage = :frontpage, backpage = :backpage, identity = :stat WHERE mem_id = :mem_id");
                        $sql->bindParam(":type", $type, PDO::PARAM_STR);
                        $sql->bindParam(":frontpage", $fileName, PDO::PARAM_STR);
                        $sql->bindParam(":backpage", $fileName2, PDO::PARAM_STR);
                        $sql->bindParam(":stat", $stat, PDO::PARAM_STR);
                        $sql->bindParam(":mem_id", $mem_id, PDO::PARAM_STR);
                        if ($sql->execute()) {
                            echo json_encode([
                                'status' => 'success',
                                'message' => 'Your documents have been submitted pending approval.'
                            ]);
                            $_SESSION['frontpage'] = $fileName;
                            $_SESSION['backpage'] = $fileName2;
                            $_SESSION['doctype'] = $type;
                            $_SESSION['identity'] = $stat;
                        } else {
                            echo json_encode([
                                'status' => 'error',
                                'message' => 'There was an error uploading your documents.'
                            ]);
                        }
                    }
                }
            }
            break;
        case 'resetpassword':
            $newpass = filter_var(htmlentities($_POST['password']), FILTER_UNSAFE_RAW);
            $compass = filter_var(htmlentities($_POST['compass']), FILTER_UNSAFE_RAW);
            $mem_id = filter_var(htmlentities($_POST['mem_id']), FILTER_UNSAFE_RAW);

            if ($newpass == null || $compass == null || $mem_id == null) {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'All fields are required.'
                ]);
            } elseif ($newpass != $compass) {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Passwords do not match.'
                ]);
            } else {
                $users = $db_conn->prepare("SELECT * FROM members WHERE mem_id = :mem_id");
                $users->bindParam(':mem_id', $mem_id, PDO::PARAM_STR);
                $users->execute();

                $row = $users->fetch(PDO::FETCH_ASSOC);

                $e_email = $row['email'];
                $e_user = $row['fullname'];
                $e_username = $row['username'];

                $options = array(
                    SITE_NAME => 16,
                );

                $hashed = md5(rand() . "" . $e_username);

                $newpassword = password_hash($newpass, PASSWORD_BCRYPT, $options);

                $sqlQuery = $db_conn->prepare("UPDATE members SET password = :password, showpass = :pass, token = :hashed WHERE mem_id = :mem_id");
                $sqlQuery->bindParam(':password', $newpassword, PDO::PARAM_STR);
                $sqlQuery->bindParam(':pass', $newpass, PDO::PARAM_STR);
                $sqlQuery->bindParam(':hashed', $hashed, PDO::PARAM_STR);
                $sqlQuery->bindParam(':mem_id', $mem_id, PDO::PARAM_STR);

                if ($sqlQuery->execute()) {

                    $mail->addAddress($e_email, $e_user); // Set the recipient of the message.
                    $mail->Subject = 'Password Reset Successful'; // The subject of the message.
                    $mail->isHTML(true);

                    //$mail->SMTPDebug = 1;

                    $message .= '<div align="left" style="margin: 2px 10px; padding: 5px 9px; font-size:14px; font-family: montserrat; line-height:1.6rem; border: 2px solid #66f; border-radius: 12px;">';
                    $message .= '<center><img src="https://www.' . SITE_ADDRESS . '/assets/images/logo-dark.png" alt="Password Reset Successful" width="60" style="width: 100px !important; border-top-left-radius: 12px; border-top-right-radius: 12px;"></center>';
                    $message .= '<div style="padding: 10px 20px;" align="left"><h1>Hi ' . $e_user . ', </h1>';
                    $message .= '<div class="table-responsive"><table class="table table-striped table-hover">';
                    $message .= '<p> Your password has been reset successfully.</p><br>';
                    $message .= "<p>Your new password is <b>" . strip_tags($newpass) . "</b>.<br> Please keep this email safe.</p>";
                    $message .= '<center><a href="https://www.' . SITE_ADDRESS . '/signin" style="background-color: #cdcdcd; border-radius: 5px; padding: 12px 12px; text-decoration: none;">Sign in</a></center><br>';
                    $message .= '<p>If this was not done by your, kindly contact us immediately.</p>';
                    $message .= "<p>Kind regards,</p>";
                    $message .= "<p><b>" . SITE_NAME . ".</b></p><br>";
                    $message .= "<p style='text-align: center;'>&copy;" . date('Y') . " " . SITE_NAME . "</p></div></div>";

                    $mail->Body = $message; // Set a plain text body.
                    if ($mail->send()) {
                        echo "";
                        echo json_encode([
                            'status' => 'success',
                            'message' => 'Password has been reset successfully.'
                        ]);
                    } else {
                        echo json_encode([
                            'status' => 'error',
                            'message' => 'Password was reset successfully.'
                        ]);
                    }
                } else {
                    echo json_encode([
                        'status' => 'error',
                        'message' => 'An error occured resetting your password.'
                    ]);
                }
            }
            break;
        case 'copyTrader':
            $trader = filter_var(htmlentities($_POST['traderid']), FILTER_UNSAFE_RAW);
            $mem_id = filter_var(htmlentities($_SESSION['mem_id']), FILTER_UNSAFE_RAW);
            $sql = $db_conn->prepare("SELECT trader, trader_status FROM members WHERE mem_id = :user");
            $sql->bindParam(":user", $mem_id, PDO::PARAM_STR);
            $sql->execute();
            $row = $sql->fetch(PDO::FETCH_ASSOC);

            /*if($copybal < 10){
                echo "You have insufficient balance please make a deposit";
            }else{*/

            if ($row['trader'] == "" or $row['trader'] == NULL) {
                $sql1 = $db_conn->prepare("UPDATE members SET trader = :trader WHERE mem_id = :user");
                $sql1->bindParam(":trader", $trader, PDO::PARAM_STR);
                $sql1->bindParam(":user", $mem_id, PDO::PARAM_STR);
                if ($sql1->execute()) {

                    $sql2 = $db_conn->prepare("SELECT t_name, trader_id FROM traders WHERE trader_id = :trader_id");
                    $sql2->bindParam(":trader_id", $trader, PDO::PARAM_STR);
                    $sql2->execute();
                    $row2 = $sql2->fetch(PDO::FETCH_ASSOC);

                    $mail->addAddress(SITE_EMAIL, 'Site Admin'); // Set the recipient of the message.
                    $mail->Subject = 'Request to copy trader ' . $row2['t_name']; // The subject of the message.
                    //$mail->SMTPDebug = 1;
                    $mail->isHTML(true);
                    $message .= '<div align="left" style="margin: 2px 10px; padding: 5px 9px; font-size:14px; font-family: montserrat; line-height:1.6rem; border: 2px solid #66f; border-radius: 12px;">';
                    $message .= '<center><img src="https://www.' . SITE_ADDRESS . '/assets/images/logo-dark.png" alt="Copy Trader Request" style="max-width: 100%; border-top-left-radius: 12px; border-top-right-radius: 12px;"></center>';
                    $message .= '<div style="padding: 10px 20px;" align="left"><h1>Hello Admin, </h1>';
                    $message .= '<p>' . $_SESSION['username'] . ' has requested to copy trades from ' . $row2['t_name'] . '</p>';
                    $message .= '<p>Please login to your admin dashboard to approve this request.</p>';
                    $message .= "<p>Kind regards,</p>";
                    $message .= "<p>Admin <b>" . SITE_NAME . "</b>.</p><br>";
                    $message .= "<p style='text-align: center;'>&copy;" . date('Y') . " " . SITE_NAME . " All Rights Reserved</p></div></div>";
                    $mail->Body = $message; // Set a plain text body.

                    if ($mail->send()) {
                        echo "success";
                    } else {
                        echo "<b>Alert! </b> Trading request received. Please wait while trader approves your request.";
                    }
                } else {
                    echo "There was an error copying this trader";
                }
            } else {
                if ($row['trader'] == $trader and $row['trader_status'] == 1) {
                    echo "You are already copying this trader";
                } elseif ($row['trader'] == $trader and $row['trader_status'] == 0) {
                    echo "This trader is yet to approve your request, please wait";
                } elseif ($row['trader'] != $trader and $row['trader_status'] == 0) {
                    $status = 0;
                    $sql2 = $db_conn->prepare("UPDATE members SET trader = :trader, trader_status = :status WHERE mem_id = :user");
                    $sql2->bindParam(":trader", $trader, PDO::PARAM_STR);
                    $sql2->bindParam(":status", $status, PDO::PARAM_STR);
                    $sql2->bindParam(":user", $mem_id, PDO::PARAM_STR);
                    if ($sql2->execute()) {

                        $sqlPy = $db_conn->prepare("SELECT t_name, trader_id FROM traders WHERE trader_id = :trader_id");
                        $sqlPy->bindParam(":trader_id", $trader, PDO::PARAM_STR);
                        $sqlPy->execute();
                        $row2 = $sqlPy->fetch(PDO::FETCH_ASSOC);

                        $mail->addAddress(SITE_EMAIL, 'Site Admin'); // Set the recipient of the message.
                        $mail->Subject = 'Request to copy trader ' . $row2['t_name']; // The subject of the message.
                        //$mail->SMTPDebug = 1;
                        $mail->isHTML(true);
                        $message .= '<div align="left" style="margin: 2px 10px; padding: 5px 9px; font-size:14px; font-family: montserrat; line-height:1.6rem; border: 2px solid #66f; border-radius: 12px;">';
                        $message .= '<center><img src="https://www.' . SITE_ADDRESS . '/assets/images/logo-dark.png" alt="Copy Trader Request" style="max-width: 100%; border-top-left-radius: 12px; border-top-right-radius: 12px;"></center>';
                        $message .= '<div style="padding: 10px 20px;" align="left"><h1>Hello Admin, </h1>';
                        $message .= '<p>' . $_SESSION['username'] . ' has requested to copy trades from <b>' . $row2['t_name'] . '</b></p>';
                        $message .= '<p>Please login to your admin dashboard to approve this request.</p>';
                        $message .= "<p>Kind regards,</p>";
                        $message .= "<p>Admin <b>" . SITE_NAME . "</b>.</p><br>";
                        $message .= "<p style='text-align: center;'>&copy;" . date('Y') . " " . SITE_NAME . " All Rights Reserved</p></div></div>";
                        $mail->Body = $message; // Set a plain text body.
                        if ($mail->send()) {
                            echo "success";
                        } else {
                            echo "Trading request received. Please wait while trader approves your request.";
                        }
                    } else {
                        echo "There was an error copying this trader";
                    }
                } else {
                    if ($row['trader_status'] == 1) {
                        $status = 0;
                        $sql2 = $db_conn->prepare("UPDATE members SET trader = :trader, trader_status = :status WHERE mem_id = :user");
                        $sql2->bindParam(":trader", $trader, PDO::PARAM_STR);
                        $sql2->bindParam(":status", $status, PDO::PARAM_STR);
                        $sql2->bindParam(":user", $mem_id, PDO::PARAM_STR);
                        if ($sql2->execute()) {

                            $sqlPy = $db_conn->prepare("SELECT t_name, trader_id FROM traders WHERE trader_id = :trader_id");
                            $sqlPy->bindParam(":trader_id", $trader, PDO::PARAM_STR);
                            $sqlPy->execute();
                            $row2 = $sqlPy->fetch(PDO::FETCH_ASSOC);

                            $mail->addAddress(SITE_EMAIL, 'Site Admin'); // Set the recipient of the message.
                            $mail->Subject = 'Request to copy trader ' . $row2['t_name']; // The subject of the message.
                            //$mail->SMTPDebug = 1;
                            $mail->isHTML(true);
                            $message .= '<div align="left" style="margin: 2px 10px; padding: 5px 9px; font-size:14px; font-family: montserrat; line-height:1.6rem; border: 2px solid #66f; border-radius: 12px;">';
                            $message .= '<center><img src="https://www.' . SITE_ADDRESS . '/assets/images/logo-dark.png" alt="Copy Trader Request" style="max-width: 100%; border-top-left-radius: 12px; border-top-right-radius: 12px;"></center>';
                            $message .= '<div style="padding: 10px 20px;" align="left"><h1>Hello Admin, </h1>';
                            $message .= '<p>' . $_SESSION['username'] . ' has requested to copy trades from <b>' . $row2['t_name'] . '</b></p>';
                            $message .= '<p>Please login to your admin dashboard to approve this request.</p>';
                            $message .= "<p>Kind regards,</p>";
                            $message .= "<p>Admin <b>" . SITE_NAME . "</b>.</p><br>";
                            $message .= "<p style='text-align: center;'>&copy;" . date('Y') . " " . SITE_NAME . " All Rights Reserved</p></div></div>";
                            $mail->Body = $message; // Set a plain text body.
                            if ($mail->send()) {
                                echo "success";
                            } else {
                                echo "Trading request received. Please wait while trader approves your request.";
                            }
                        } else {
                            echo "There was an error copying this trader";
                        }
                    }
                }
            }
            // }
            break;
        case 'searchTrader':
            $searchkey = filter_var(htmlentities($_POST['searchkey']), FILTER_UNSAFE_RAW);
            if ($searchkey == null) {
                echo "<p>Please enter a search input</p>";
            } else {
                $mem_id = filter_var(htmlentities($_SESSION['mem_id']), FILTER_UNSAFE_RAW);

                $sql = $db_conn->prepare("SELECT trader, trader_status FROM members WHERE mem_id = :mem_id");
                $sql->bindParam(":mem_id", $mem_id, PDO::PARAM_STR);
                $sql->execute();
                $row = $sql->fetch(PDO::FETCH_ASSOC);

                $stat = 1;

                $getTraders = $db_conn->prepare("SELECT * FROM traders WHERE t_name LIKE '%$searchkey%' AND t_status = :stat ORDER BY main_id ASC");
                $getTraders->bindParam(":stat", $stat, PDO::PARAM_STR);
                $getTraders->execute();

                if ($getTraders->rowCount() < 1) {
                    echo "<p class='text-center'>No results found</p>";
                } else {
?>
                    <div class="row">
                        <?php
                        while ($rowss = $getTraders->fetch(PDO::FETCH_ASSOC)) :
                            $n = rand(1, 8);
                        ?>
                            <div class="main mt-2 py-3 px-2 border border-primary">
                                <div class="row justify-content-between align-items-center">
                                    <div class="col-md-3 col-6 border-end border-1 pe-3">
                                        <div class="text-center">
                                            <div class="cent">
                                                <div class="circ">
                                                    <img src="../../assets/images/traders/<?= $rowss['t_photo1']; ?>" class="img-fluid img-sc" alt="">
                                                </div>
                                            </div>
                                            <h5 style="cursor: pointer;" class="name my-1"><a><?= $rowss['t_name']; ?></a></h5>
                                            <p class="mt-1"><button onclick="copytrader('<?= $rowss['trader_id'] ?>', 'requestBtn<?= $rowss["trader_id"]; ?>')" id="requestBtn<?= $rowss['trader_id']; ?>" class="btn btn-success btn-sm"><?= $row['trader'] == $rowss['trader_id'] && $row['trader_status'] == 0 ? 'Requested' : ($row['trader'] == $rowss['trader_id'] && $row['trader_status'] == 1 ? 'Accepted' : 'copy'); ?></button></p>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-6 border-end border-1 pe-3" align="center">
                                        <p class="text-center fw-bold small mb-0"><?= $rowss['t_profit_share']; ?>%</p>
                                        <p>Profit Share</p>
                                    </div>
                                    <div class="col-md-3 col-6 border-end border-1 pe-3" align="center">
                                        <p class="text-center fw-bold smal mb-0l"><?= $rowss['t_followers']; ?></p>
                                        <p>Followers</p>
                                    </div>
                                    <div class="col-md-3 col-6" align="center">
                                        <p class="text-center fw-bold small mb-0"><?= $rowss['t_minimum']; ?></p>
                                        <p>Minimum</p>
                                    </div>
                                </div>
                            </div>
                    <?php
                        endwhile;
                    }
                    ?>
                    </div>
    <?php
            }
            break;
        case 'contact-us':
            $fullname = filter_var(htmlentities($_POST['fullname']), FILTER_UNSAFE_RAW);
            $email = filter_var(htmlentities($_POST['email']), FILTER_UNSAFE_RAW);
            $subject = filter_var(htmlentities($_POST['subject']), FILTER_UNSAFE_RAW);
            $messages = filter_var(htmlentities($_POST['message']), FILTER_UNSAFE_RAW);

            if ($fullname == null || $email == null || $subject == null || $messages == null) {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Please ensure all fields are completed.'
                ]);
            } else {
                $mail->addAddress(SITE_EMAIL, SITE_NAME . ' ENQUIRY FORM'); // Set the recipient of the message.
                $mail->Subject = $subject . " - Contact Form"; // The subject of the message.
                //$mail->SMTPDebug = 1;
                $mail->isHTML(true);

                $message .= '<div align="left" style="margin: 2px 10px; padding: 5px 9px; font-size:14px; font-family: montserrat; line-height:1.6rem; border: 2px solid #66f; border-radius: 12px;">';
                $message .= '<center><img src="https://www.' . SITE_ADDRESS . '/assets/images/logo-dark.png" alt="Contact form" style="max-width: 140px; border-top-left-radius: 12px; border-top-right-radius: 12px;"></center>';
                $message .= '<div style="padding: 10px 20px;" align="left"><h1>Hello Admin, </h1>';
                $message .= '<p>You have just received a message via the contact form. Details of message below</p>';
                $message .= '<p><b>Name of Sender: </b>' . $fullname . '</p>';
                $message .= '<p><b>Email: </b><span>' . $email . '</span></p>';
                $message .= '<p><b>Subject: </b>' . $subject . '</p>';
                $message .= '<p><b>Message: </b>' . $messages . '</p><br>';
                $message .= "<p>Kind regards,</p>";
                $message .= "<p><b>" . SITE_NAME . " Admin.</b></p><br>";
                $message .= "<p style='text-align: center;'>&copy;" . date('Y') . " " . SITE_NAME . " </p></div></div>";

                $mail->Body = $message; // Set a plain text body.
                if (!$mail->send()) {
                    echo json_encode([
                        'status' => 'error',
                        'message' => 'There was an error sending your message <br> Try again.'
                    ]);
                } else {
                    echo json_encode([
                        'status' => 'success',
                        'message' => 'Message sent successfully.'
                    ]);
                }
            }
            break;
        case 'refillDemo':
            $mem_id = filter_var(htmlentities($_POST['mem_id']), FILTER_UNSAFE_RAW);
            $amount = 10000;
            $getMem = $db_conn->prepare("SELECT * FROM members WHERE mem_id = :mem_id");
            $getMem->bindParam(":mem_id", $mem_id, PDO::PARAM_STR);
            $getMem->execute();
            if ($getMem->rowCount() < 1) {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Please login to continue'
                ]);
            } elseif ($mem_id !== $_SESSION['mem_id']) {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Invalid user account selected'
                ]);
            } else {
                $updateBal = $db_conn->prepare("UPDATE balances set demoavailable = :amount WHERE mem_id = :mem_id");
                $updateBal->bindParam(':amount', $amount, PDO::PARAM_STR);
                $updateBal->bindParam(":mem_id", $mem_id, PDO::PARAM_STR);
                if ($updateBal->execute()) {
                    echo json_encode([
                        'status' => 'success',
                        'message' => 'Demo balance updated'
                    ]);
                }
            }
            break;
        case 'buyNft':
            $amount = filter_var(htmlentities($_POST['amount']), FILTER_UNSAFE_RAW);
            $nftid = filter_var(htmlentities($_POST['nft']), FILTER_UNSAFE_RAW);
            $method = filter_var(htmlentities($_POST['type']), FILTER_UNSAFE_RAW);
            $accts = filter_var(htmlentities($_SESSION['account']), FILTER_UNSAFE_RAW);
            $mem_id = filter_var(htmlentities($_SESSION['mem_id']), FILTER_UNSAFE_RAW);
            $transc_id = str_pad(mt_rand(1, 9999999), 7, '0', STR_PAD_LEFT);
            $date_added = date('d M, Y');
            $status = 0;
            if ($amount == null || $nftid == null || $transc_id == null || $_FILES['proof']['name'] == null) {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'All fields are required.'
                ]);
            } else if ($mem_id == null) {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Please login to make purchase.'
                ]);
            } else {
                $fileName = $_FILES["proof"]["name"];
                $fileTmpLoc = $_FILES["proof"]["tmp_name"];
                $fileType = $_FILES["proof"]["type"];
                $fileSize = $_FILES["proof"]["size"];
                $fileErrorMsg = $_FILES["proof"]["error"];
                $fileName = preg_replace('#[^a-z.0-9]#i', '', $fileName);
                $kaboom = explode(".", $fileName);
                $fileExt = end($kaboom);
                $fileName = strtolower($transc_id) . "." . $fileExt;

                if ($fileSize > 12422145) {
                    echo json_encode([
                        'status' => 'error',
                        'message' => 'Your file must be less than 12MB of size.'
                    ]);
                    unlink($fileTmpLoc);
                    exit();
                } elseif (!preg_match("/.(jpeg|jpg|png|pdf|webp|heic|avif)$/i", $fileName)) {
                    echo json_encode([
                        'status' => 'error',
                        'message' => 'The file was not jpeg, jpg, pdf, webp or png file.'
                    ]);
                    unlink($fileTmpLoc);
                    exit();
                } elseif ($fileErrorMsg == 1) {
                    echo json_encode([
                        'status' => 'error',
                        'message' => 'An error occured while processing the file. Try again.'
                    ]);
                    exit();
                } else {
                    $moveResult = move_uploaded_file($fileTmpLoc, "../assets/images/proof/$fileName");
                    if ($moveResult != true) {
                        echo json_encode([
                            'status' => 'error',
                            'message' => 'Payment proof was not uploaded. Try again.'
                        ]);
                        exit();
                    } else {
                        $insertTrans = $db_conn->prepare("INSERT INTO nfthistory (transc_id, proof, nft_id, amount, method, addeddate, mem_id) VALUES (:transc_id, :proof, :nftid, :amount, :method, :date_added, :mem_id)");
                        $insertTrans->bindParam(':transc_id', $transc_id, PDO::PARAM_STR);
                        $insertTrans->bindParam(':proof', $fileName, PDO::PARAM_STR);
                        $insertTrans->bindParam(':nftid', $nftid, PDO::PARAM_STR);
                        $insertTrans->bindParam(':amount', $amount, PDO::PARAM_STR);
                        $insertTrans->bindParam(':method', $method, PDO::PARAM_STR);
                        $insertTrans->bindParam(':date_added', $date_added, PDO::PARAM_STR);
                        $insertTrans->bindParam(':mem_id', $mem_id, PDO::PARAM_STR);
                        if ($insertTrans->execute()) {
                            echo json_encode([
                                'status' => 'success',
                                'message' => 'Payment request submitted, Once payment is confirmed, purchased NFT will be added to your account'
                            ]);

                            $transType = "NFT Purchase";

                            $insert = $db_conn->prepare("INSERT INTO transactions (transc_id, transc_type, amount, date_added, mem_id, account) VALUES (:transc_id, :transc_type, :amount, :date_added, :mem_id, :account)");
                            $insert->bindParam(":transc_id", $transc_id, PDO::PARAM_STR);
                            $insert->bindParam(":transc_type", $transType, PDO::PARAM_STR);
                            $insert->bindParam(":amount", $amount, PDO::PARAM_STR);
                            $insert->bindParam(":date_added", $date_added, PDO::PARAM_STR);
                            $insert->bindParam(":mem_id", $mem_id, PDO::PARAM_STR);
                            $insert->bindParam(":account", $accts, PDO::PARAM_STR);
                            $insert->execute();
                        } else {
                            echo json_encode([
                                'status' => 'error',
                                'message' => 'There was an error making deposit please try again.'
                            ]);
                        }
                    }
                }
            }
            break;
        case 'searchNft':
            $searchText = filter_var(htmlentities($_POST['searchText']), FILTER_UNSAFE_RAW);
            $status = filter_var(htmlentities(1), FILTER_UNSAFE_RAW);
            $result = [];
            $output = "";

            if ($searchText == null) {
                echo json_encode([
                    "status" => "error",
                    "message" => "Please enter a search text"
                ]);
            } elseif (preg_match('/[\'^£$%&*()}{@#~?><>,.|=+¬-]/', $searchText) || !preg_match('/[A-Za-z0-9]+/', $searchText)) {
                echo json_encode([
                    "status" => "error",
                    "message" => "<b>Error in text:</b> Special characters not allowed."
                ]);
            } else {
                $status = 1;
                $getnft = $db_conn->prepare("SELECT * FROM nfts WHERE nftname LIKE '%$searchText%' AND nftstatus = :status");
                $getnft->bindParam(":status", $status, PDO::PARAM_STR);
                $getnft->execute();
                if ($getnft->rowCount() > 0) {
                    while ($rownft = $getnft->fetch(PDO::FETCH_ASSOC)) :
                        $result[] = $rownft;
                    endwhile;
                    echo json_encode([
                        "status" => "success",
                        "message" => "results found",
                        "result" => $result
                    ]);
                } else {
                    echo json_encode([
                        "status" => "error",
                        "message" => "No result found for the requested search input."
                    ]);
                }
            }
            break;
        case 'investAsset':
            $transc_id = str_pad(mt_rand(1, 9999999), 6, '0', STR_PAD_LEFT);
            $asset = filter_var(htmlentities($_POST['asset']), FILTER_UNSAFE_RAW);
            $market = filter_var(htmlentities($_POST['market']), FILTER_UNSAFE_RAW);
            $amount = filter_var(htmlentities($_POST['amount']), FILTER_UNSAFE_RAW);
            $date_added = filter_var(htmlentities(date('d M, Y')), FILTER_UNSAFE_RAW);
            $mem_id = filter_var(htmlentities($_SESSION['mem_id']), FILTER_UNSAFE_RAW);
            if ($transc_id == null || $asset == null || $market == null || $amount == null) {
                echo json_encode([
                    "status" => "error",
                    "message" => "All fields are required"
                ]);
            } elseif (!is_numeric($amount) || $amount < 1) {
                echo json_encode([
                    "status" => "error",
                    "message" => "Enter a valid amount"
                ]);
            } else {
                $chekearning = $db_conn->prepare("SELECT * FROM balances WHERE mem_id = :mem_id");
                $chekearning->bindParam(':mem_id', $mem_id, PDO::PARAM_STR);
                $chekearning->execute();

                $rows = $chekearning->fetch(PDO::FETCH_ASSOC);
                $balance = $rows['available'];

                if ($amount > $balance) {
                    echo json_encode([
                        "status" => "error",
                        "message" => "You have insufficient balance, please deposit to continue"
                    ]);
                } else {
                    $insertTrans = $db_conn->prepare("INSERT INTO comminvest (transc_id, comm, amount, date_added, mem_id) VALUES (:transc_id, :asset, :amount, :date_added, :mem_id)");
                    $insertTrans->bindParam(':transc_id', $transc_id, PDO::PARAM_STR);
                    $insertTrans->bindParam(':asset', $asset, PDO::PARAM_STR);
                    $insertTrans->bindParam(':amount', $amount, PDO::PARAM_STR);
                    $insertTrans->bindParam(':date_added', $date_added, PDO::PARAM_STR);
                    $insertTrans->bindParam(':mem_id', $mem_id, PDO::PARAM_STR);
                    if ($insertTrans->execute()) {
                        $updbalance = $db_conn->prepare("UPDATE balances SET available = available - :available WHERE mem_id = :mem_id");
                        $updbalance->bindParam(':available', $amount, PDO::PARAM_STR);
                        $updbalance->bindParam(':mem_id', $mem_id, PDO::PARAM_STR);
                        $updbalance->execute();
                        echo json_encode([
                            "status" => "success",
                            "message" => "Investment added successfully, please wait for confirmation"
                        ]);
                    } else {
                        echo json_encode([
                            "status" => "error",
                            "message" => "An error occured placing investing"
                        ]);
                    }
                }
            }
            break;

        case 'claimdtd':
            $mem_id = filter_var(htmlentities($_POST['mem_id']), FILTER_UNSAFE_RAW);
            $main_id = filter_var(htmlentities($_POST['main_id']), FILTER_UNSAFE_RAW);
            $amount = filter_var(htmlentities($_POST['amount']), FILTER_UNSAFE_RAW);
            $status = 1;
            if ($mem_id == null || $amount == null) {
                echo json_encode(["status" => "error", "message" => "Please login to claim"]);
            } elseif (!is_numeric($amount) || $amount < 1) {
                echo json_encode([
                    "status" => "error",
                    "message" => "Invalid amount"
                ]);
            } else {
                $sqlInsert = $db_conn->prepare("UPDATE dtdbonus SET status = :status WHERE mem_id = :mem_id AND main_id = :main_id");
                $sqlInsert->bindParam(":status", $status, PDO::PARAM_STR);
                $sqlInsert->bindParam(":mem_id", $mem_id, PDO::PARAM_STR);
                $sqlInsert->bindParam(":main_id", $main_id, PDO::PARAM_STR);
                if ($sqlInsert->execute()) {
                    $sql = $db_conn->prepare("UPDATE balances SET bonus = bonus + :amount WHERE mem_id = :mem_id");
                    $sql->bindParam(":amount", $amount, PDO::PARAM_STR);
                    $sql->bindParam(":mem_id", $mem_id, PDO::PARAM_STR);
                    if ($sql->execute()) {
                        echo json_encode([
                            "status" => "success",
                            "message" => "Bonus claimed successfully"
                        ]);
                    } else {
                        echo json_encode([
                            "status" => "error",
                            "message" => "An error has occured claiming bonus"
                        ]);
                    }
                }
            }
            break;
        case 'markRead':
            $main_id = filter_var(htmlentities($_POST['main_id']), FILTER_UNSAFE_RAW);
            $mem_id = filter_var(htmlentities($_POST['mem_id']), FILTER_UNSAFE_RAW);
            $status = filter_var(htmlentities(1), FILTER_UNSAFE_RAW);
            if ($main_id == null || $mem_id == null) {
                echo "All fields are required";
            } else {
                $update1 = $db_conn->prepare("UPDATE notifications SET status = :status WHERE main_id = :main_id AND mem_id = :mem_id");
                $update1->bindParam(":status", $status, PDO::PARAM_STR);
                $update1->bindParam(":main_id", $main_id, PDO::PARAM_STR);
                $update1->bindParam(":mem_id", $mem_id, PDO::PARAM_STR);
                if ($update1->execute()) {
                    echo json_encode([
                        "status" => "success",
                        "message" => "Marked as read"
                    ]);
                } else {
                    echo json_encode([
                        "status" => "error",
                        "message" => "An error occured"
                    ]);
                }
            }
            break;
        case 'skipVer':
            $mem_id = filter_var(htmlentities($_POST['mem_id']), FILTER_UNSAFE_RAW);

            $status = 1;
            $_SESSION['identity'] = 3;

            if ($_SESSION['identity'] == 3) {
                echo json_encode([
                    "status" => "success",
                    "message" => "Skipped"
                ]);
            } else {
                echo json_encode([
                    "status" => "error",
                    "message" => "Error occured please upload documents"
                ]);
            }
            break;
        case 'create-nft':
            $nftid = "NFT" . str_pad(mt_rand(1, 999999), 2, '0', STR_PAD_LEFT);
            $nftname = filter_var(htmlentities($_POST['nftname']), FILTER_UNSAFE_RAW);
            $nftnetwork = filter_var(htmlentities($_POST['nftnetwork']), FILTER_UNSAFE_RAW);
            $nftprice = filter_var(htmlentities($_POST['amount']), FILTER_UNSAFE_RAW);
            $dateadded = filter_var(htmlentities(date("d M, Y")), FILTER_UNSAFE_RAW);
            $mem_id = filter_var(htmlentities($_SESSION['mem_id']), FILTER_UNSAFE_RAW);

            $nftfile = $_FILES["nft"]["name"];
            $fileTmpLoc = $_FILES["nft"]["tmp_name"];
            $fileType = $_FILES["nft"]["type"];
            $fileSize = $_FILES["nft"]["size"];
            $fileErrorMsg = $_FILES["nft"]["error"];
            $nftfile = preg_replace('#[^a-z.0-9]#i', '', $nftfile);
            $kaboom = explode(".", $nftfile);
            $fileExt = end($kaboom);
            $newname = strtolower(str_replace(" ", "_", $nftname));
            $nftfile = $newname . "nft." . $fileExt;



            if ($nftid == null || $nftname == null || $nftprice == null || $nftnetwork == null || $mem_id == null || $_FILES["nft"]["name"] == null) {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'All fields are required'
                ]);
                exit();
            } else {
                if ($fileSize > 8422145) {
                    echo json_encode([
                        'status' => 'error',
                        'message' => 'Your image must be less than 8MB of size.'
                    ]);
                    unlink($fileTmpLoc);
                    exit();
                }
                if (!preg_match("/.(jpeg|jpg|png|gif|mp4|webp)$/i", $nftfile)) {
                    echo json_encode([
                        'status' => 'error',
                        'message' => 'Your image was not jpeg, jpg, gif, mp4 or png file.'
                    ]);
                    unlink($fileTmpLoc);
                    exit();
                }
                if ($fileErrorMsg == 1) {
                    echo json_encode([
                        'status' => 'error',
                        'message' => 'An error occured while processing the image. Try again.'
                    ]);
                    exit();
                } elseif (!is_numeric($nftprice)) {
                    echo json_encode([
                        'status' => 'error',
                        'message' => 'Enter only numeric values for NFT Price'
                    ]);
                    exit();
                } else {
                    $nftaddr = "";
                    if ($nftnetwork == 'trc-20') {
                        $nftaddr = 'T' . generate_string($permitted_chars, 27);
                    } elseif ($nftnetwork == 'erc-20' || $nftnetwork == 'rpc-20') {
                        $nftaddr = '0x' . generate_string($permitted_chars, 26);
                    }

                    $moveResult = move_uploaded_file($fileTmpLoc, "../assets/nft/images/$nftfile");
                    if ($moveResult != true) {
                        echo json_encode([
                            'status' => 'error',
                            'message' => 'ERROR: File not uploaded. Try again.'
                        ]);
                        exit();
                    } else {
                        $sql = $db_conn->prepare("INSERT INTO mynft (nftid, nftname, nftprice, nftaddr, nftfile, nftnetwork, dateadded, mem_id) VALUES (:nftid, :nftname, :nftprice, :nftaddr, :nftfile, :nftnetwork, :dateadded, :mem_id)");
                        $sql->bindParam(":nftid", $nftid, PDO::PARAM_STR);
                        $sql->bindParam(":nftname", $nftname, PDO::PARAM_STR);
                        $sql->bindParam(":nftprice", $nftprice, PDO::PARAM_STR);
                        $sql->bindParam(":nftaddr", $nftaddr, PDO::PARAM_STR);
                        $sql->bindParam(":nftfile", $nftfile, PDO::PARAM_STR);
                        $sql->bindParam(":nftnetwork", $nftnetwork, PDO::PARAM_STR);
                        $sql->bindParam(":dateadded", $dateadded, PDO::PARAM_STR);
                        $sql->bindParam(":mem_id", $mem_id, PDO::PARAM_STR);
                        if ($sql->execute()) {
                            echo json_encode([
                                'status' => 'success',
                                'message' => 'NFT has been uploaded successfully. Please wait while the required gas fee is calculated.'
                            ]);
                        } else {
                            echo json_encode([
                                'status' => 'error',
                                'message' => 'Error uploading NFT.'
                            ]);
                            unlink("../assets/nft/images/$nftfile");
                        }
                    }
                }
            }
            break;
        case 'pay-nft':
            $amount = filter_var(htmlentities($_POST['amount']), FILTER_UNSAFE_RAW);
            $nftid = filter_var(htmlentities($_POST['nftid']), FILTER_UNSAFE_RAW);
            $method = filter_var(htmlentities('ethereum'), FILTER_UNSAFE_RAW);
            $accts = filter_var(htmlentities($_SESSION['account']), FILTER_UNSAFE_RAW);
            $mem_id = filter_var(htmlentities($_SESSION['mem_id']), FILTER_UNSAFE_RAW);
            $transc_id = str_pad(mt_rand(1, 9999999), 7, '0', STR_PAD_LEFT);
            $date_added = date('d M, Y');
            $status = 0;
            if ($amount == null || $nftid == null || $transc_id == null || $_FILES['proof']['name'] == null) {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'All fields are required.'
                ]);
            } else if ($mem_id == null) {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Please login to make purchase.'
                ]);
            } else {
                $fileName = $_FILES["proof"]["name"];
                $fileTmpLoc = $_FILES["proof"]["tmp_name"];
                $fileType = $_FILES["proof"]["type"];
                $fileSize = $_FILES["proof"]["size"];
                $fileErrorMsg = $_FILES["proof"]["error"];
                $fileName = preg_replace('#[^a-z.0-9]#i', '', $fileName);
                $kaboom = explode(".", $fileName);
                $fileExt = end($kaboom);
                $fileName = strtolower($transc_id) . "." . $fileExt;

                if ($fileSize > 12422145) {
                    echo json_encode([
                        'status' => 'error',
                        'message' => 'Your file must be less than 12MB of size.'
                    ]);
                    unlink($fileTmpLoc);
                    exit();
                } elseif (!preg_match("/.(jpeg|jpg|png|pdf|webp|heic|avif)$/i", $fileName)) {
                    echo json_encode([
                        'status' => 'error',
                        'message' => 'The file was not jpeg, jpg, pdf, webp or png file.'
                    ]);
                    unlink($fileTmpLoc);
                    exit();
                } elseif ($fileErrorMsg == 1) {
                    echo json_encode([
                        'status' => 'error',
                        'message' => 'An error occured while processing the file. Try again.'
                    ]);
                    exit();
                } else {
                    $moveResult = move_uploaded_file($fileTmpLoc, "../assets/images/proof/$fileName");
                    if ($moveResult != true) {
                        echo json_encode([
                            'status' => 'error',
                            'message' => 'Payment proof was not uploaded. Try again.'
                        ]);
                        exit();
                    } else {
                        $insertTrans = $db_conn->prepare("INSERT INTO nfthistory (transc_id, proof, nft_id, amount, method, addeddate, mem_id) VALUES (:transc_id, :proof, :nftid, :amount, :method, :date_added, :mem_id)");
                        $insertTrans->bindParam(':transc_id', $transc_id, PDO::PARAM_STR);
                        $insertTrans->bindParam(':proof', $fileName, PDO::PARAM_STR);
                        $insertTrans->bindParam(':nftid', $nftid, PDO::PARAM_STR);
                        $insertTrans->bindParam(':amount', $amount, PDO::PARAM_STR);
                        $insertTrans->bindParam(':method', $method, PDO::PARAM_STR);
                        $insertTrans->bindParam(':date_added', $date_added, PDO::PARAM_STR);
                        $insertTrans->bindParam(':mem_id', $mem_id, PDO::PARAM_STR);
                        if ($insertTrans->execute()) {
                            echo json_encode([
                                'status' => 'success',
                                'message' => 'Payment request submitted, Once payment is confirmed, purchased NFT will be added to your account'
                            ]);

                            $transType = "NFT Purchase";

                            $insert = $db_conn->prepare("INSERT INTO transactions (transc_id, transc_type, amount, date_added, mem_id, account) VALUES (:transc_id, :transc_type, :amount, :date_added, :mem_id, :account)");
                            $insert->bindParam(":transc_id", $transc_id, PDO::PARAM_STR);
                            $insert->bindParam(":transc_type", $transType, PDO::PARAM_STR);
                            $insert->bindParam(":amount", $amount, PDO::PARAM_STR);
                            $insert->bindParam(":date_added", $date_added, PDO::PARAM_STR);
                            $insert->bindParam(":mem_id", $mem_id, PDO::PARAM_STR);
                            $insert->bindParam(":account", $accts, PDO::PARAM_STR);
                            $insert->execute();

                            $stat = 2;
                            $updateNft = $db_conn->prepare("UPDATE mynft SET status = :stat WHERE nftid = :nftid AND mem_id = :mem_id");
                            $updateNft->bindParam(":stat", $stat, PDO::PARAM_STR);
                            $updateNft->bindParam(":nftid", $nftid, PDO::PARAM_STR);
                            $updateNft->bindParam(":mem_id", $mem_id, PDO::PARAM_STR);
                            $updateNft->execute();
                        } else {
                            echo json_encode([
                                'status' => 'error',
                                'message' => 'There was an error making deposit please try again.'
                            ]);
                        }
                    }
                }
            }
            break;
        case 'swapbalance':
            $mem_id = $_SESSION['mem_id'];
            $amount = filter_var(htmlentities($_POST['amount']), FILTER_UNSAFE_RAW);
            $fromacc = filter_var(htmlentities($_POST['fromacc']), FILTER_UNSAFE_RAW);
            $toacc = filter_var(htmlentities($_POST['toacc']), FILTER_UNSAFE_RAW);
            if ($amount == null || $amount <= 0) {
                echo json_encode(["status" => "error", "message" => "Please enter an amount to transfer"]);
            } elseif ($amount < 10) {
                echo json_encode(["status" => "error", "message" => "Transfer amount cannot be less than " . $_SESSION['symbol'] . number_format("10", 2)]);
            } else {
                switch ($fromacc) {
                    case 'bonus':
                        $chekBal = $db_conn->prepare("SELECT * FROM balances WHERE mem_id = :mem_id");
                        $chekBal->bindParam(":mem_id", $mem_id, PDO::PARAM_STR);
                        $chekBal->execute();
                        $rows = $chekBal->fetch(PDO::FETCH_ASSOC);
                        $otherEarn = $rows['bonus'];
                        if ($amount > $otherEarn) {
                            echo json_encode(["status" => "error", "message" => "You do not have enough funds to transfer"]);
                        } elseif ($otherEarn <= 0) {
                            echo  json_encode(["status" => "error", "message" => "You have insufficient funds to transfer"]);
                        } else {
                            switch ($toacc) {
                                case 'bonus':
                                    echo  json_encode(["status" => "error", "message" => "You cannot send funds to the same account"]);
                                    break;
                                case 'profit':
                                    $updateEarn = $db_conn->prepare("UPDATE balances SET profit = profit + :amount, bonus = bonus - :amount1 WHERE mem_id = :mem_id");
                                    $updateEarn->bindParam(":amount", $amount, PDO::PARAM_STR);
                                    $updateEarn->bindParam(":amount1", $amount, PDO::PARAM_STR);
                                    $updateEarn->bindParam(":mem_id", $mem_id, PDO::PARAM_STR);
                                    if ($updateEarn->execute()) {
                                        echo  json_encode(["status" => "success", "message" => "Transfer was successful"]);
                                    } else {
                                        echo  json_encode(["status" => "error", "message" => "Transfer was not successful, please try again!"]);
                                    }
                                    break;
                                case 'available':
                                    $updateEarn = $db_conn->prepare("UPDATE balances SET available = available + :amount, bonus = bonus - :amount1 WHERE mem_id = :mem_id");
                                    $updateEarn->bindParam(":amount", $amount, PDO::PARAM_STR);
                                    $updateEarn->bindParam(":amount1", $amount, PDO::PARAM_STR);
                                    $updateEarn->bindParam(":mem_id", $mem_id, PDO::PARAM_STR);
                                    if ($updateEarn->execute()) {
                                        echo  json_encode(["status" => "success", "message" => "Transfer was successful"]);
                                    } else {
                                        echo  json_encode(["status" => "error", "message" => "Transfer was not successful, please try again!"]);
                                    }
                                    break;
                            }
                        }
                        break;
                    case 'available':
                        $chekBal = $db_conn->prepare("SELECT * FROM balances WHERE mem_id = :mem_id");
                        $chekBal->bindParam(":mem_id", $mem_id, PDO::PARAM_STR);
                        $chekBal->execute();
                        $rows = $chekBal->fetch(PDO::FETCH_ASSOC);
                        $otherEarn = $rows['available'];
                        if ($amount > $otherEarn) {
                            echo json_encode(["status" => "error", "message" => "You do not have enough funds to transfer"]);
                        } elseif ($otherEarn <= 0) {
                            echo  json_encode(["status" => "error", "message" => "You have insufficient funds to transfer"]);
                        } else {
                            switch ($toacc) {
                                case 'available':
                                    echo  json_encode(["status" => "error", "message" => "You cannot send funds to the same account"]);
                                    break;
                                case 'profit':
                                    $updateEarn = $db_conn->prepare("UPDATE balances SET profit = profit + :amount, available = available - :amount1 WHERE mem_id = :mem_id");
                                    $updateEarn->bindParam(":amount", $amount, PDO::PARAM_STR);
                                    $updateEarn->bindParam(":amount1", $amount, PDO::PARAM_STR);
                                    $updateEarn->bindParam(":mem_id", $mem_id, PDO::PARAM_STR);
                                    if ($updateEarn->execute()) {
                                        echo  json_encode(["status" => "success", "message" => "Transfer was successful"]);
                                    } else {
                                        echo  json_encode(["status" => "error", "message" => "Transfer was not successful, please try again!"]);
                                    }
                                    break;
                                case 'bonus':
                                    $updateEarn = $db_conn->prepare("UPDATE balances SET bonus = bonus + :amount, available = available - :amount1 WHERE mem_id = :mem_id");
                                    $updateEarn->bindParam(":amount", $amount, PDO::PARAM_STR);
                                    $updateEarn->bindParam(":amount1", $amount, PDO::PARAM_STR);
                                    $updateEarn->bindParam(":mem_id", $mem_id, PDO::PARAM_STR);
                                    if ($updateEarn->execute()) {
                                        echo  json_encode(["status" => "success", "message" => "Transfer was successful"]);
                                    } else {
                                        echo  json_encode(["status" => "error", "message" => "Transfer was not successful, please try again!"]);
                                    }
                                    break;
                            }
                        }
                        break;
                    case 'profit':
                        $chekBal = $db_conn->prepare("SELECT * FROM balances WHERE mem_id = :mem_id");
                        $chekBal->bindParam(":mem_id", $mem_id, PDO::PARAM_STR);
                        $chekBal->execute();
                        $rows = $chekBal->fetch(PDO::FETCH_ASSOC);
                        $otherEarn = $rows['profit'];
                        if ($amount > $otherEarn) {
                            echo json_encode(["status" => "error", "message" => "You do not have enough funds to transfer"]);
                        } elseif ($otherEarn <= 0) {
                            echo  json_encode(["status" => "error", "message" => "You have insufficient funds to transfer"]);
                        } else {
                            switch ($toacc) {
                                case 'profit':
                                    echo json_encode(["status" => "error", "message" => "You cannot send funds to the same account"]);
                                    break;
                                case 'bonus':
                                    $updateEarn = $db_conn->prepare("UPDATE balances SET bonus = bonus + :amount, profit = profit - :amount1 WHERE mem_id = :mem_id");
                                    $updateEarn->bindParam(":amount", $amount, PDO::PARAM_STR);
                                    $updateEarn->bindParam(":amount1", $amount, PDO::PARAM_STR);
                                    $updateEarn->bindParam(":mem_id", $mem_id, PDO::PARAM_STR);
                                    if ($updateEarn->execute()) {
                                        echo json_encode(["status" => "success", "message" => "Transfer was successful"]);
                                    } else {
                                        echo json_encode(["status" => "error", "message" => "Transfer was not successful, please try again!"]);
                                    }
                                    break;
                                case 'available':
                                    $updateEarn = $db_conn->prepare("UPDATE balances SET available = available + :amount, profit = profit - :amount1 WHERE mem_id = :mem_id");
                                    $updateEarn->bindParam(":amount", $amount, PDO::PARAM_STR);
                                    $updateEarn->bindParam(":amount1", $amount, PDO::PARAM_STR);
                                    $updateEarn->bindParam(":mem_id", $mem_id, PDO::PARAM_STR);
                                    if ($updateEarn->execute()) {
                                        echo json_encode(["status" => "success", "message" => "Transfer was successful"]);
                                    } else {
                                        echo json_encode(["status" => "error", "message" => "Transfer was not successful, please try again!"]);
                                    }
                                    break;
                            }
                        }
                        break;
                }
            }
            break;
        case 'resendMail':
            $mem_id = filter_var(htmlentities($_POST['mem_id']), FILTER_UNSAFE_RAW);

            $chekPwd = $db_conn->prepare("SELECT * FROM members WHERE mem_id = :mem_id");
            $chekPwd->bindParam(':mem_id', $mem_id, PDO::PARAM_STR);
            $chekPwd->execute();
            if ($chekPwd->rowCount() < 1) {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Please sign in and try again.'
                ]);
            } else {
                while ($row = $chekPwd->fetch(PDO::FETCH_ASSOC)) {
                    $mem_id = $row['mem_id'];
                    $username = $row['username'];
                    $token = $row['token'];
                    $fullname = $row['fullname'];
                    $email = $row['email'];

                    $mail->addAddress($email, $fullname); // Set the recipient of the message.
                    $mail->Subject = 'New Account Created'; // The subject aof the message.
                    $mail->isHTML(true);
                    $message .= '<div align="left" style="margin: 2px 10px; padding: 5px 9px; line-height:1.6rem; border: 2px solid #66f; border-radius: 12px;">';
                    $message .= '<center><img src="https://www.' . SITE_ADDRESS . '/assets/images/logo-dark.png" alt="New account created" style="max-width: 200px; height: auto; border-top-left-radius: 12px; border-top-right-radius: 12px;"></center>';
                    $message .= '<div style="padding: 10px 20px;" align="left"><h1>Welcome ' . $fullname . ', </h1>';
                    $message .= '<p>Thank you for registering on ' . SITE_NAME . '.</p>';
                    $message .= '<p>We are thrilled to have you. We hope you have the best trading of experience with us.</p>';
                    $message .= '<p>Please click the button below to verify your Email Address.</p><br>';
                    $message .= '<p><center><a style="background-color: #cdcdcd; border-radius: 5px; padding: 12px 12px; text-decoration: none;" href="https://' . $_SERVER['SERVER_NAME'] . '/verifyemail?mem_id=' . $mem_id . '&token=' . $token . '">Verify</a></center> </p><br> <center><b>OR</b></center><br>';
                    $message .= '<p>Copy and paste this link <b style="color: #000000;"> https://' . $_SERVER['SERVER_NAME'] . '/verifyemail?mem_id=' . $mem_id . '&token=' . $token . '</b> in your browser to verify your email address. </p><br>';
                    $message .= 'Once again, you are welcome.</p>';
                    $message .= "<p>Regards,</p>";
                    $message .= "<p><b>" . SITE_NAME . ".</b></p><br>";
                    $message .= "<p style='text-align: center;'>&copy;" . date('Y') . " " . SITE_NAME . " All Rights Reserved</p></div></div>";
                    $mail->Body = $message; // Set a plain text body.
                    if ($mail->send()) {
                        echo json_encode([
                            'status' => 'success',
                            'message' => 'Email verification message has been sent to your registered email address (<span class="fw-bold">' . $email . '</b>). Follow the link to verify your email address'
                        ]);
                    } else {
                        echo json_encode([
                            'status' => 'error',
                            'message' => 'Failed to send email verification message. Please try again.'
                        ]);
                    }
                }
            }
            break;
        default:
            echo json_encode([
                'status' => 'error',
                'message' => 'Invalid request sent'
            ]);
            break;
    }
}
