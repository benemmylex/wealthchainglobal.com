<?php
include('./connect.php');

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] != 'POST' && !isset($_POST['request'])) {
    echo 'Invalid request sent';
    die();
} else {
    $request = filter_var(htmlentities($_POST['request']), FILTER_UNSAFE_RAW);
    switch ($request) {
        case 'login':
            $username = filter_var(htmlentities($_POST['username']), FILTER_UNSAFE_RAW);
            $password = filter_var(htmlentities($_POST['password']), FILTER_UNSAFE_RAW);

            if ($username == null && $password == null) {
                echo "Enter your username and password to login";
            } elseif ($username == null) {
                echo "Enter your username address to login";
            } elseif ($password == null) {
                echo "Enter your password to login";
            } else {
                $chekPwd = $db_conn->prepare("SELECT * FROM admin WHERE username = :username");
                $chekPwd->bindParam(':username', $username, PDO::PARAM_STR);
                $chekPwd->execute();
                if ($chekPwd->rowCount() < 1) {
                    echo "No admin exists with that username";
                }
                while ($row = $chekPwd->fetch(PDO::FETCH_ASSOC)) {
                    $rAdminId = $row['admin_id'];
                    $rUsername = $row['username'];
                    $rPassword = $row['password'];
                    $rActPart = $row['actpart'];
                    $rEmail = $row['email'];
                    $rPhone = $row['phone'];
                    $optionsreset = array(
                        SITE_NAME => 32,
                    );

                    $resetpass = md5($rEmail . " " . mt_rand());


                    if (password_verify($password, $rPassword)) {
                        $query = $db_conn->prepare("SELECT * FROM admin WHERE username = :username AND password = :rPassword");
                        $query->bindParam(':username', $rUsername, PDO::PARAM_STR);
                        $query->bindParam(':rPassword', $rPassword, PDO::PARAM_STR);
                        $query->execute();
                        $num = $query->rowCount();
                        if ($num == 0) {
                            echo "User and password incorrect!";
                        } else {
                            $updateHash = $db_conn->prepare("UPDATE admin SET token = :pass_hash WHERE username = :username");
                            $updateHash->bindParam(":pass_hash", $resetpass, PDO::PARAM_STR);
                            $updateHash->bindParam(":username", $rUsername, PDO::PARAM_STR);
                            $updateHash->execute();
                            $_SESSION['admin_id'] = $rAdminId;
                            $_SESSION['admusername'] = $rUsername;
                            $_SESSION['admemail'] = $rEmail;
                            $_SESSION['password'] = $rPassword;
                            $_SESSION['actpart'] = $rActPart;
                            $_SESSION['admphone'] = $rPhone;
                            echo  "success";
                        }
                    } else {
                        echo "Incorrect password Please try again";
                    }
                }
            }
            break;
        case 'emailverify':
            $mem_id = filter_var(htmlentities($_POST['mem_id']), FILTER_UNSAFE_RAW);
            $username = filter_var(htmlentities($_POST['username']), FILTER_UNSAFE_RAW);
            $email = filter_var(htmlentities($_POST['email']), FILTER_UNSAFE_RAW);

            $status = 1;
            $sqlUpdate = $db_conn->prepare("UPDATE verifications SET email = :status WHERE mem_id = :mem_id");
            $sqlUpdate->bindParam(":status", $status, PDO::PARAM_STR);
            $sqlUpdate->bindParam(":mem_id", $mem_id, PDO::PARAM_STR);
            if ($sqlUpdate->execute()) {
                echo "success";
            } else {
                echo "An error occured!!";
            }
            break;
        case 'deleteuser':
            $mem_id = filter_var(htmlentities($_POST['mem_id']), FILTER_UNSAFE_RAW);
            $photo = filter_var(htmlentities($_POST['photo']), FILTER_UNSAFE_RAW);

            $sql2s = $db_conn->prepare("SELECT * FROM members");
            $sql2s->execute();
            $r = $sql2s->fetch(PDO::FETCH_ASSOC);
            if ($r['photo'] != NULL) {
                if (is_file("../assets/images/user/$photo")) {
                    unlink("../assets/images/user/$photo");
                }
            }
            $sqlUpdate = $db_conn->prepare("DELETE FROM members WHERE mem_id = :mem_id");
            $sqlUpdate->bindParam(":mem_id", $mem_id, PDO::PARAM_STR);
            if ($sqlUpdate->execute()) {
                $sql2 = $db_conn->prepare("DELETE FROM deptransc WHERE mem_id = :mem_id");
                $sql2->bindParam(":mem_id", $mem_id, PDO::PARAM_STR);
                if ($sql2->execute()) {
                    $sql3 = $db_conn->prepare("DELETE FROM balances WHERE mem_id = :mem_id");
                    $sql3->bindParam(":mem_id", $mem_id, PDO::PARAM_STR);
                    if ($sql3->execute()) {
                        $sql5 = $db_conn->prepare("DELETE FROM userplans WHERE mem_id = :mem_id");
                        $sql5->bindParam(":mem_id", $mem_id, PDO::PARAM_STR);
                        if ($sql5->execute()) {
                            $sql6 = $db_conn->prepare("DELETE FROM wittransc WHERE mem_id = :mem_id");
                            $sql6->bindParam(":mem_id", $mem_id, PDO::PARAM_STR);
                            if ($sql6->execute()) {
                                $sql7 = $db_conn->prepare("DELETE FROM verifications WHERE mem_id = :mem_id");
                                $sql7->bindParam(":mem_id", $mem_id, PDO::PARAM_STR);
                                if ($sql7->execute()) {
                                    $sql8 = $db_conn->prepare("DELETE FROM notifications WHERE mem_id = :mem_id");
                                    $sql8->bindParam(":mem_id", $mem_id, PDO::PARAM_STR);
                                    if ($sql8->execute()) {
                                        $sql9 = $db_conn->prepare("DELETE FROM favorites WHERE mem_id = :mem_id");
                                        $sql9->bindParam(":mem_id", $mem_id, PDO::PARAM_STR);
                                        if ($sql9->execute()) {
                                            $sql10 = $db_conn->prepare("DELETE FROM trades WHERE mem_id = :mem_id");
                                            $sql10->bindParam(":mem_id", $mem_id, PDO::PARAM_STR);
                                            if ($sql10->execute()) {
                                                $sql11 = $db_conn->prepare("DELETE FROM transactions WHERE mem_id = :mem_id");
                                                $sql11->bindParam(":mem_id", $mem_id, PDO::PARAM_STR);
                                                if ($sql11->execute()) {
                                                    echo "success";
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            } else {
                echo "An error occured deleting user!!";
            }
            break;
        case 'suspenduser':
            $mem_id = filter_var(htmlentities($_POST['mem_id']), FILTER_UNSAFE_RAW);
            $username = filter_var(htmlentities($_POST['username']), FILTER_UNSAFE_RAW);
            $email = filter_var(htmlentities($_POST['email']), FILTER_UNSAFE_RAW);

            $status = 2;

            $sqlUpdate = $db_conn->prepare("UPDATE verifications SET status = :status WHERE mem_id = :mem_id");
            $sqlUpdate->bindParam(":status", $status, PDO::PARAM_STR);
            $sqlUpdate->bindParam(":mem_id", $mem_id, PDO::PARAM_STR);
            if ($sqlUpdate->execute()) {
                $mail->addAddress($email, $username); // Set the recipient of the message.
                $mail->Subject = 'Account Suspended'; // The subject of the message.
                $mail->isHTML(true);
                //$mail->SMTPDebug = 1;

                $message .= '<div align="left" style="margin: 2px 10px; padding: 5px 9px; font-size:14px; font-family: montserrat; line-height:1.6rem; border: 2px solid #66f; border-radius: 12px;">';
                $message .= '<center><img src="https://www.' . SITE_ADDRESS . '/assets/images/logo-dark.png" alt="Account Suspension" style="max-width: 100%; border-top-left-radius: 12px; border-top-right-radius: 12px;"></center>';
                $message .= '<div style="padding: 10px 20px;" align="left"><h1>Hi ' . $username . ', </h1>';
                $message .= '<p>Your account has been suspended due to irregular activities!</p>';
                $message .= '<p>Click on the link below to contact support for assistance.</p><br>';
                $message .= '<center><a href="https://www.' . SITE_ADDRESS . '/contact-us" style="background-color: #cdcdcd; border-radius: 5px; padding: 12px 12px; text-decoration: none;">Contact us</a></center><br>';
                $message .= '<p>If this was a mistake, please ignore.</p>';
                $message .= "<p>Kind regards,</p>";
                $message .= "<p><b>" . SITE_NAME . ".</b></p><br>";
                $message .= "<p style='text-align: center;'>&copy;" . date('Y') . " " . SITE_NAME . " All Rights Reserved</p></div></div>";

                $mail->Body = $message; // Set a plain text body.
                if ($mail->send()) {
                    echo "success";
                } else {
                    echo "Suspended but email failed to deliver";
                }
            } else {
                echo "An error occured suspending account!";
            }
            break;
        case 'activateuser':
            $mem_id = filter_var(htmlentities($_POST['mem_id']), FILTER_UNSAFE_RAW);
            $username = filter_var(htmlentities($_POST['username']), FILTER_UNSAFE_RAW);
            $email = filter_var(htmlentities($_POST['email']), FILTER_UNSAFE_RAW);

            $status = 1;
            $sqlUpdate = $db_conn->prepare("UPDATE verifications SET status = :status WHERE mem_id = :mem_id");
            $sqlUpdate->bindParam(":status", $status, PDO::PARAM_STR);
            $sqlUpdate->bindParam(":mem_id", $mem_id, PDO::PARAM_STR);
            if ($sqlUpdate->execute()) {
                $mail->addAddress($email, $username); // Set the recipient of the message.
                $mail->Subject = 'Account Activated'; // The subject of the message.
                $mail->isHTML(true);
                //$mail->SMTPDebug = 1;

                $message .= '<div align="left" style="margin: 2px 10px; padding: 5px 9px; font-size:14px; font-family: montserrat; line-height:1.6rem; border: 2px solid #66f; border-radius: 12px;">';
                $message .= '<center><img src="https://www.' . SITE_ADDRESS . '/assets/images/logo-dark.png" alt="Account Activated" style="max-width: 100%; border-top-left-radius: 12px; border-top-right-radius: 12px;"></center>';
                $message .= '<div style="padding: 10px 20px;" align="left"><h1>Hi ' . $username . ', </h1>';
                $message .= '<p>Your account has been re-activated successfully!</p>';
                $message .= '<p>You can login now to your account to continue earning.</p><br>';
                $message .= '<center><a href="https://www.' . SITE_ADDRESS . '/signin" style="background-color: #cdcdcd; border-radius: 5px; padding: 12px 12px; text-decoration: none;">Login</a></center><br>';
                $message .= '<p>If this was a mistake, please ignore.</p>';
                $message .= "<p>Kind regards,</p>";
                $message .= "<p><b>" . SITE_NAME . ".</b></p><br>";
                $message .= "<p style='text-align: center;'>&copy;" . date('Y') . " " . SITE_NAME . " All Rights Reserved</p></div></div>";

                $mail->Body = $message; // Set a plain text body.
                if ($mail->send()) {
                    echo "success";
                } else {
                    echo "Activated but email failed to deliver";
                }
            } else {
                echo "An error occured acivating account!";
            }
            break;
        case 'sendpopup':
            $subject = filter_var(htmlentities($_POST['subject']), FILTER_UNSAFE_RAW);
            $mem_id = filter_var(htmlentities($_POST['mem_id']), FILTER_UNSAFE_RAW);
            $datetime = filter_var(htmlentities(date('d M, Y')), FILTER_UNSAFE_RAW);
            $message = $_POST['message'];

            if ($subject == null || $mem_id == null || $message == null) {
                echo "All fields are required";
            } else {
                $sql = $db_conn->prepare("INSERT INTO notifications (mem_id, title, datetime, message) VALUES(:mem_id, :title, :datetime, :message)");
                $sql->bindParam(':mem_id', $mem_id, PDO::PARAM_STR);
                $sql->bindParam(':datetime', $datetime, PDO::PARAM_STR);
                $sql->bindParam(':title', $subject, PDO::PARAM_STR);
                $sql->bindParam(':message', $message, PDO::PARAM_STR);
                if ($sql->execute()) {
                    echo "success";
                } else {
                    echo "Notification message was not sent to user";
                }
            }
            break;
        case 'verifyuser':
            $mem_id = filter_var(htmlentities($_POST['mem_id']), FILTER_UNSAFE_RAW);
            $email = filter_var(htmlentities($_POST['email']), FILTER_UNSAFE_RAW);
            $username = filter_var(htmlentities($_POST['username']), FILTER_UNSAFE_RAW);

            $status = 3;
            $sqlUpdate = $db_conn->prepare("UPDATE verifications SET identity = :status WHERE mem_id = :mem_id");
            $sqlUpdate->bindParam(":status", $status, PDO::PARAM_STR);
            $sqlUpdate->bindParam(":mem_id", $mem_id, PDO::PARAM_STR);
            if ($sqlUpdate->execute()) {
                $mail->addAddress($email, $username); // Set the recipient of the message.
                $mail->Subject = 'KYC verification successful'; // The subject of the message.
                $mail->isHTML(true);
                //$mail->SMTPDebug = 1;

                $message .= '<div align="left" style="margin: 2px 10px; padding: 5px 9px; font-size:14px; font-family: montserrat; line-height:1.6rem; border: 2px solid #66f; border-radius: 12px;">';
                $message .= '<center><img src="https://www.' . SITE_ADDRESS . '/assets/images/logo-dark.png" alt="Account Activated" style="max-width: 100%; border-top-left-radius: 12px; border-top-right-radius: 12px;"></center>';
                $message .= '<div style="padding: 10px 20px;" align="left"><h1>Hi ' . $username . ', </h1>';
                $message .= '<p>Your account has been verified successfully!</p>';
                $message .= '<p>You can login now to your account make deposit and start investing/trading.</p><br>';
                $message .= '<center><a href="https://www.' . SITE_ADDRESS . '/signin" style="background-color: #cdcdcd; border-radius: 5px; padding: 12px 12px; text-decoration: none;">Sign in</a></center><br>';
                $message .= "<p>Regards,</p>";
                $message .= "<p><b>" . SITE_NAME . ".</b></p><br>";
                $message .= "<p style='text-align: center;'>&copy;" . date('Y') . " " . SITE_NAME . " All Rights Reserved</p></div></div>";

                $mail->Body = $message; // Set a plain text body.
                if ($mail->send()) {
                    echo "success";
                } else {
                    echo "Verified but email failed to deliver";
                }
            } else {
                echo "An error occured verifying user!";
            }
            break;
        case 'notverifyuser':
            $mem_id = filter_var(htmlentities($_POST['mem_id']), FILTER_UNSAFE_RAW);
            $email = filter_var(htmlentities($_POST['email']), FILTER_UNSAFE_RAW);
            $username = filter_var(htmlentities($_POST['username']), FILTER_UNSAFE_RAW);
            $doctype = filter_var(htmlentities($_POST['doctype']), FILTER_UNSAFE_RAW);
            $frontpage = filter_var(htmlentities($_POST['frontpage']), FILTER_UNSAFE_RAW);
            $backpage = filter_var(htmlentities($_POST['backpage']), FILTER_UNSAFE_RAW);

            $emptfront = NULL;
            $emptback = NULL;
            $emptdoc = NULL;
            $status = 0;

            if (is_file("../assets/images/verification/$frontpage")) {
                unlink("../assets/images/verification/$frontpage");
            }

            if (is_file("../assets/images/verification/$backpage")) {
                unlink("../assets/images/verification/$backpage");
            }

            $sqlUpdate = $db_conn->prepare("UPDATE verifications SET identity = :status, idtype = :doctype, frontpage = :frontpage, backpage = :backpage WHERE mem_id = :mem_id");
            $sqlUpdate->bindParam(":status", $status, PDO::PARAM_STR);
            $sqlUpdate->bindParam(":doctype", $emptdoc, PDO::PARAM_STR);
            $sqlUpdate->bindParam(":frontpage", $emptfront, PDO::PARAM_STR);
            $sqlUpdate->bindParam(":backpage", $emptback, PDO::PARAM_STR);
            $sqlUpdate->bindParam(":mem_id", $mem_id, PDO::PARAM_STR);
            if ($sqlUpdate->execute()) {
                // $mail->addAddress($email, $username); // Set the recipient of the message.
                // $mail->Subject = 'KYC verification unsuccessful'; // The subject of the message.
                // $mail->isHTML(true);
                // //$mail->SMTPDebug = 1;

                // $message .= '<div align="left" style="margin: 2px 10px; padding: 5px 9px; font-size:14px; font-family: montserrat; line-height:1.6rem; border: 2px solid #66f; border-radius: 12px;">';
                // $message .= '<center><img src="https://www.' . SITE_ADDRESS . '/assets/images/logo-dark.png" alt="Account Activated" style="max-width: 100%; border-top-left-radius: 12px; border-top-right-radius: 12px;"></center>';
                // $message .= '<div style="padding: 10px 20px;" align="left"><h1>Hi ' . $username . ', </h1>';
                // $message .= '<p>Your account verification could not be completed due to some errors.</p>';
                // $message .= '<p>Please check the document uploaded and try again.</p><br>';
                // $message .= '<p>Do not hesitate to contact support for further assistance via ' . SITE_EMAIL . '</p>';
                // $message .= "<p>Regards,</p>";
                // $message .= "<p><b>" . SITE_NAME . ".</b></p><br>";
                // $message .= "<p style='text-align: center;'>&copy;" . date('Y') . " " . SITE_NAME . " All Rights Reserved</p></div></div>";

                // $mail->Body = $message; // Set a plain text body.
                // if ($mail->send()) {
                echo "success";
                // } else {
                //     echo "Unverified but email failed to deliver";
                // }
            } else {
                echo "An error occured unverifying user!";
            }
            break;
        case 'addPlan':
            $mem_id = filter_var(htmlentities($_POST['mem_id']), FILTER_UNSAFE_RAW);
            $plan = filter_var(htmlentities($_POST['plan']), FILTER_UNSAFE_RAW);
            $planduration = filter_var(htmlentities($_POST['duration']), FILTER_UNSAFE_RAW);
            $plandate = filter_var(htmlentities(date('d M, Y')), FILTER_UNSAFE_RAW);
            $status = filter_var(htmlentities("1"), FILTER_UNSAFE_RAW);
            if ($plan == null || $plandate == null) {
                echo "Please enter all fields";
            } else {
                $checkAmt = $db_conn->prepare("SELECT * FROM userplans WHERE mem_id = :mem_id");
                $checkAmt->bindParam(':mem_id', $mem_id, PDO::PARAM_STR);
                $checkAmt->execute();

                if ($checkAmt->rowCount() < 1) {
                    $planReg = $db_conn->prepare("INSERT INTO userplans (userplan, planduration, plandate, status, mem_id) VALUES (:plan, :duration, :plandate, :status, :mem_id)");
                    $planReg->bindParam(':plan', $plan, PDO::PARAM_STR);
                    $planReg->bindParam(':duration', $planduration, PDO::PARAM_STR);
                    $planReg->bindParam(':plandate', $plandate, PDO::PARAM_STR);
                    $planReg->bindParam(':status', $status, PDO::PARAM_STR);
                    $planReg->bindParam(':mem_id', $mem_id, PDO::PARAM_STR);
                    if ($planReg->execute()) {
                        echo "success";
                    } else {
                        echo "An error occured, please try again";
                    }
                } else {
                    $planReg = $db_conn->prepare("UPDATE userplans SET userplan = :plan, planduration = :duration, plandate = :plandate, status = :status WHERE mem_id = :mem_id");
                    $planReg->bindParam(':plan', $plan, PDO::PARAM_STR);
                    $planReg->bindParam(':duration', $planduration, PDO::PARAM_STR);
                    $planReg->bindParam(':plandate', $plandate, PDO::PARAM_STR);
                    $planReg->bindParam(':status', $status, PDO::PARAM_STR);
                    $planReg->bindParam(':mem_id', $mem_id, PDO::PARAM_STR);
                    if ($planReg->execute()) {
                        echo "success";
                    } else {
                        echo "An error occured, please try again";
                    }
                }
            }
            break;
        case 'sendmail':
            //=================================================================================//
            $name = filter_var(htmlentities($_POST['name']), FILTER_UNSAFE_RAW);
            $email = filter_var(htmlentities($_POST['email']), FILTER_UNSAFE_RAW);
            $subject = filter_var(htmlentities($_POST['subject']), FILTER_UNSAFE_RAW);
            $messages = filter_var(htmlentities($_POST['message']), FILTER_UNSAFE_RAW);

            if ($name == null || $email == null || $subject == null || $messages == null) {
                echo "Please ensure all fields are completed!";
            } else {
                $page = $subject;
                $mail->addAddress($email, $name); // Set the recipient of the message.
                $mail->Subject = $page; // The subject of the message.
                //$mail->SMTPDebug = 1;
                $mail->isHTML(true);

                $message .= '<div align="left" style="margin: 2px 10px; padding: 5px 9px; font-size:14px; font-family: montserrat; line-height:1.6rem; border: 2px solid #66f; border-radius: 12px;">';
                $message .= '<center><img src="https://www.' . SITE_ADDRESS . '/assets/images/logo-dark.png" alt="' . $page . '" style="max-width: 100%; border-top-left-radius: 12px; border-top-right-radius: 12px;"></center>';
                $message .= '<div style="padding: 10px 20px;" align="left"><h1>Hi ' . $name . ', </h1><p>';
                $message .= $messages;
                $message .= "</p><p>Kind regards,</p>";
                $message .= "<p><b>" . SITE_NAME . ".</b></p><br>";
                $message .= "<p style='text-align: center;'>&copy;" . date('Y') . " " . SITE_NAME . " All Rights Reserved</p></div></div>";
                $mail->Body = $message; // Set a plain text body.

                if (!$mail->send()) {
                    echo "Mailer Error: " . $mail->ErrorInfo; // "Mailer Error: " . $mail->ErrorInfo;
                } else {
                    echo "success";
                }
            }
            break;
        case 'approvedep':
            $mem_id = filter_var(htmlentities($_POST['mem_id']), FILTER_UNSAFE_RAW);
            $status = 1;
            $transc_id = filter_var(htmlentities($_POST['transc_id']), FILTER_UNSAFE_RAW);
            $amount = filter_var(htmlentities($_POST['amount']), FILTER_UNSAFE_RAW);

            $sqlUpdate = $db_conn->prepare("UPDATE balances SET available = available + :amount WHERE mem_id = :mem_id");
            $sqlUpdate->bindParam(":amount", $amount, PDO::PARAM_STR);
            $sqlUpdate->bindParam(":mem_id", $mem_id, PDO::PARAM_STR);
            if ($sqlUpdate->execute()) {
                $sqlQuery2 = $db_conn->prepare("UPDATE deptransc SET status = :status WHERE mem_id = :mem_id AND transc_id = :transac");
                $sqlQuery2->bindParam(":status", $status, PDO::PARAM_STR);
                $sqlQuery2->bindParam(":mem_id", $mem_id, PDO::PARAM_STR);
                $sqlQuery2->bindParam(":transac", $transc_id, PDO::PARAM_STR);
                if ($sqlQuery2->execute()) {
                    $transUpd = $db_conn->prepare("UPDATE transactions SET status = :status WHERE transc_id = :transc_id AND mem_id = :mem_id");
                    $transUpd->bindParam(":status", $status, PDO::PARAM_STR);
                    $transUpd->bindParam(":transc_id", $transc_id, PDO::PARAM_STR);
                    $transUpd->bindParam(":mem_id", $mem_id, PDO::PARAM_STR);
                    $transUpd->execute();

                    //IF users first deposit and exists in referal table
                    $getDepTrans = $db_conn->prepare("SELECT * FROM deptransc WHERE mem_id = :mem_id");
                    $getDepTrans->bindParam(':mem_id', $mem_id, PDO::PARAM_STR);
                    $getDepTrans->execute();
                    if ($getDepTrans->rowCount() == 1) {
                        $getRef = $db_conn->prepare("SELECT referrer FROM referral WHERE mem_id = :mem_id");
                        $getRef->bindParam(':mem_id', $mem_id, PDO::PARAM_STR);
                        $getRef->execute();
                        if ($getRef->rowCount() > 0) {
                            $r = $getRef->fetch(PDO::FETCH_ASSOC);
                            $referrer = $r['referrer'];
                            $discount = round($amount * 0.10, 2);

                            $sUpdate = $db_conn->prepare("UPDATE balances SET bonus = bonus + :amount WHERE mem_id = :mem_id");
                            $sUpdate->bindParam(":amount", $discount, PDO::PARAM_STR);
                            $sUpdate->bindParam(":mem_id", $referrer, PDO::PARAM_STR);
                            if ($sUpdate->execute()) {
                                echo "success";
                            }
                        } else {
                            echo "success";
                        }
                    } else {
                        echo "success";
                    }
                } else {
                    echo "Deposit has been approved";
                }
            } else {
                echo "An error occured!";
            }
            break;
        case 'faildep':
            $mem_id = filter_var(htmlentities($_POST['mem_id']), FILTER_UNSAFE_RAW);
            $status = 2;
            $transc_id = filter_var(htmlentities($_POST['transc_id']), FILTER_UNSAFE_RAW);
            $amount = filter_var(htmlentities($_POST['amount']), FILTER_UNSAFE_RAW);
            $depStat = filter_var(htmlentities($_POST['status']), FILTER_UNSAFE_RAW);

            if ($depStat == 1) {
                $sqlUpdate = $db_conn->prepare("UPDATE balances SET available = available - :amount WHERE mem_id = :mem_id");
                $sqlUpdate->bindParam(":amount", $amount, PDO::PARAM_STR);
                $sqlUpdate->bindParam(":mem_id", $mem_id, PDO::PARAM_STR);
                if ($sqlUpdate->execute()) {
                    $sqlQuery2 = $db_conn->prepare("UPDATE deptransc SET status = :status WHERE mem_id = :mem_id AND transc_id = :transac");
                    $sqlQuery2->bindParam(":status", $status, PDO::PARAM_STR);
                    $sqlQuery2->bindParam(":mem_id", $mem_id, PDO::PARAM_STR);
                    $sqlQuery2->bindParam(":transac", $transc_id, PDO::PARAM_STR);
                    if ($sqlQuery2->execute()) {
                        $transUpd = $db_conn->prepare("UPDATE transactions SET status = :status WHERE transc_id = :transc_id AND mem_id = :mem_id");
                        $transUpd->bindParam(":status", $status, PDO::PARAM_STR);
                        $transUpd->bindParam(":transc_id", $transc_id, PDO::PARAM_STR);
                        $transUpd->bindParam(":mem_id", $mem_id, PDO::PARAM_STR);
                        $transUpd->execute();
                        echo "success";
                    } else {
                        echo "Your request has failed";
                    }
                } else {
                    echo "Error occured failing deposit";
                }
            } else {
                $sqlQuery2 = $db_conn->prepare("UPDATE deptransc SET status = :status WHERE mem_id = :mem_id AND transc_id = :transac");
                $sqlQuery2->bindParam(":status", $status, PDO::PARAM_STR);
                $sqlQuery2->bindParam(":mem_id", $mem_id, PDO::PARAM_STR);
                $sqlQuery2->bindParam(":transac", $transc_id, PDO::PARAM_STR);
                if ($sqlQuery2->execute()) {
                    $transUpd = $db_conn->prepare("UPDATE transactions SET status = :status WHERE transc_id = :transc_id AND mem_id = :mem_id");
                    $transUpd->bindParam(":status", $status, PDO::PARAM_STR);
                    $transUpd->bindParam(":transc_id", $transc_id, PDO::PARAM_STR);
                    $transUpd->bindParam(":mem_id", $mem_id, PDO::PARAM_STR);
                    $transUpd->execute();
                    echo "success";
                } else {
                    echo "Your request has failed";
                }
            }
            break;
        case 'deleteDep':
            $mem_id = filter_var(htmlentities($_POST['mem_id']), FILTER_UNSAFE_RAW);
            $transc_id = filter_var(htmlentities($_POST['transc_id']), FILTER_UNSAFE_RAW);

            $sqlQuery2 = $db_conn->prepare("DELETE FROM deptransc WHERE mem_id = :mem_id AND transc_id = :transac");
            $sqlQuery2->bindParam(":mem_id", $mem_id, PDO::PARAM_STR);
            $sqlQuery2->bindParam(":transac", $transc_id, PDO::PARAM_STR);
            if ($sqlQuery2->execute()) {
                $transDel = $db_conn->prepare("DELETE FROM transactions WHERE mem_id = :mem_id AND transc_id = :transc_id");
                $transDel->bindParam(":mem_id", $mem_id, PDO::PARAM_STR);
                $transDel->bindParam(":transc_id", $transc_id, PDO::PARAM_STR);
                $transDel->execute();
                echo "success";
            } else {
                echo "Deposit has been deleted";
            }
            break;
        case 'addcrypto':
            $main_id = str_pad(mt_rand(1, 999999), 6, '0', STR_PAD_LEFT);
            $crypto_name = filter_var(htmlentities($_POST['crypto_name']), FILTER_UNSAFE_RAW);
            $wallet_addr = filter_var(htmlentities($_POST['wallet_addr']), FILTER_UNSAFE_RAW);
            $date_added = date('d M, Y H:i:s');
            $fileName = $_FILES["qrcode"]["name"];
            $fileTmpLoc = $_FILES["qrcode"]["tmp_name"];
            $fileType = $_FILES["qrcode"]["type"];
            $fileSize = $_FILES["qrcode"]["size"];
            $fileErrorMsg = $_FILES["qrcode"]["error"];
            $fileName = preg_replace('#[^a-z.0-9]#i', '', $fileName);
            $kaboom = explode(".", $fileName);
            $fileExt = end($kaboom);
            $fileName = strtolower(preg_replace('/\s+/', '', $crypto_name)) . "_barcode" . "." . $fileExt;


            $chekcrypto = $db_conn->prepare("SELECT crypto_name FROM crypto WHERE crypto_name = :crypto_name");
            $chekcrypto->bindParam(':crypto_name', $crypto_name, PDO::PARAM_STR);
            $chekcrypto->execute();


            if ($crypto_name == null || $wallet_addr == null) {
                echo "Please enter the name and wallet address of the coin";
            } elseif ($chekcrypto->rowCount() > 0) {
                echo "Crypto already exists, please go back and edit";
                exit();
            } elseif ($_FILES["qrcode"]["name"] == null) {
                echo "Please select an image to upload";
            } elseif ($fileSize > 3422145) {
                echo "Your image must be less than 8MB of size.";
                unlink($fileTmpLoc);
            } elseif (!preg_match("/.(jpeg|jpg|png|webp|heic|avif)$/i", $fileName)) {
                echo "Your image was not jpeg, jpg, or png file.";
                unlink($fileTmpLoc);
            } elseif ($fileErrorMsg == 1) {
                echo "An error occured while processing the image. Try again.";
            } elseif ($_FILES["qrcode"]["name"] != null) {
                $moveResult = move_uploaded_file($fileTmpLoc, "../assets/images/wallets/$fileName");
                if ($moveResult == true) {
                    $addCrypto = "INSERT INTO crypto (main_id, crypto_name, date_added, wallet_addr, barcode) VALUES (:main_id, :crypto_name, :date_added, :wallet_addr, :barcode) ";
                    $crypto_add = $db_conn->prepare($addCrypto);
                    $crypto_add->bindParam(':main_id', $main_id, PDO::PARAM_STR);
                    $crypto_add->bindParam(':crypto_name', $crypto_name, PDO::PARAM_STR);
                    $crypto_add->bindParam(':date_added', $date_added, PDO::PARAM_STR);
                    $crypto_add->bindParam(':wallet_addr', $wallet_addr, PDO::PARAM_STR);
                    $crypto_add->bindParam(':barcode', $fileName, PDO::PARAM_STR);
                    if ($crypto_add->execute()) {
                        echo "success";
                    } else {
                        echo "There was a problem adding new crypto currency.";
                    }
                } else {
                    echo "failed to upload file";
                    unlink("../assets/images/wallets/$fileName");
                }
            }
            break;
        case 'deletecrypto':
            $main_id = filter_var(htmlentities($_POST['main_id']), FILTER_UNSAFE_RAW);
            $barcode = filter_var(htmlentities($_POST['barcode']), FILTER_UNSAFE_RAW);
            if (is_file("../assets/images/wallets/$barcode")) {
                $del = unlink("../assets/images/wallets/$barcode");
                if ($del) {
                    $sqlUpdate = $db_conn->prepare("DELETE FROM crypto WHERE main_id = :main_id");
                    $sqlUpdate->bindParam(":main_id", $main_id, PDO::PARAM_STR);
                    if ($sqlUpdate->execute()) {
                        echo "success";
                    } else {
                        echo "Crypto wallet was not deleted";
                    }
                }
            }
            break;
        case 'editwallet':
            $main_id = filter_var(htmlentities($_POST['main_id']), FILTER_UNSAFE_RAW);
            $coinname = filter_var(htmlentities($_POST['crypto_name']), FILTER_UNSAFE_RAW);
            $coinaddr = filter_var(htmlentities($_POST['wallet_addr']), FILTER_UNSAFE_RAW);
            $barcode = filter_var(htmlentities($_POST['barcode']), FILTER_UNSAFE_RAW);
            $date_added = date('d M, Y H:i:s');

            if ($main_id == null || $coinname == null || $coinaddr == null) {
                echo "All fields are required";
                exit();
            } elseif ($_FILES["qrcode"]["name"] == null) {
                $upd1 = $db_conn->prepare("UPDATE crypto SET crypto_name = :crypto_name, date_added = :date_added, wallet_addr = :wallet_addr WHERE main_id = :main_id");
                $upd1->bindParam(":crypto_name", $coinname, PDO::PARAM_STR);
                $upd1->bindParam(":date_added", $date_added, PDO::PARAM_STR);
                $upd1->bindParam(":wallet_addr", $coinaddr, PDO::PARAM_STR);
                $upd1->bindParam(":main_id", $main_id, PDO::PARAM_STR);
                if ($upd1->execute()) {
                    echo "success";
                } else {
                    echo "The Wallet was not edited sucessfully";
                }
            } else {
                $fileName = $_FILES["qrcode"]["name"];
                $fileTmpLoc = $_FILES["qrcode"]["tmp_name"];
                $fileType = $_FILES["qrcode"]["type"];
                $fileSize = $_FILES["qrcode"]["size"];
                $fileErrorMsg = $_FILES["qrcode"]["error"];
                $fileName = preg_replace('#[^a-z.0-9]#i', '', $fileName);
                $kaboom = explode(".", $fileName);
                $fileExt = end($kaboom);
                $newname = strtolower($coinname);
                $fileName = preg_replace('/\s+/', '', $newname) . "_barcode." . $fileExt;

                if ($fileSize > 8422145) {
                    echo "Your image must be less than 8MB of size.";
                    unlink($fileTmpLoc);
                    exit();
                }
                if (!preg_match("/.(jpeg|jpg|png|webp|heic|avif)$/i", $fileName)) {
                    echo "Your image was not jpeg, jpg, or png file.";
                    unlink($fileTmpLoc);
                    exit();
                }
                if ($fileErrorMsg == 1) {
                    echo "An error occured while processing the image. Try again.";
                    exit();
                } else {
                    if (is_file("../assets/images/wallets/$barcode")) {
                        $delimg = unlink("../assets/images/wallets/$barcode");
                        if ($delimg) {
                            $moveResult = move_uploaded_file($fileTmpLoc, "../assets/images/wallets/$fileName");
                            if ($moveResult != true) {
                                echo "File not uploaded. Try again.";
                                exit();
                            } else {
                                $upd1 = $db_conn->prepare("UPDATE crypto SET crypto_name = :crypto_name, date_added = :date_added, wallet_addr = :wallet_addr, barcode = :barcode WHERE main_id = :main_id");
                                $upd1->bindParam(":crypto_name", $coinname, PDO::PARAM_STR);
                                $upd1->bindParam(":date_added", $date_added, PDO::PARAM_STR);
                                $upd1->bindParam(":wallet_addr", $coinaddr, PDO::PARAM_STR);
                                $upd1->bindParam(":barcode", $fileName, PDO::PARAM_STR);
                                $upd1->bindParam(":main_id", $main_id, PDO::PARAM_STR);
                                if ($upd1->execute()) {
                                    echo "success";
                                } else {
                                    unlink("../assets/images/wallets/$fileName");
                                    echo "The Wallet was not edited sucessfully";
                                }
                            }
                        }
                    } else {
                        $moveResult = move_uploaded_file($fileTmpLoc, "../assets/images/wallets/$fileName");
                        if ($moveResult != true) {
                            echo "File not uploaded. Try again.";
                            exit();
                        } else {
                            $upd1 = $db_conn->prepare("UPDATE crypto SET crypto_name = :crypto_name, date_added = :date_added, wallet_addr = :wallet_addr, barcode = :barcode WHERE main_id = :main_id");
                            $upd1->bindParam(":crypto_name", $coinname, PDO::PARAM_STR);
                            $upd1->bindParam(":date_added", $date_added, PDO::PARAM_STR);
                            $upd1->bindParam(":wallet_addr", $coinaddr, PDO::PARAM_STR);
                            $upd1->bindParam(":barcode", $fileName, PDO::PARAM_STR);
                            $upd1->bindParam(":main_id", $main_id, PDO::PARAM_STR);
                            if ($upd1->execute()) {
                                echo "success";
                            } else {
                                unlink("../assets/images/wallets/$fileName");
                                echo "The Wallet was not edited sucessfully";
                            }
                        }
                    }
                }
            }
            break;
        case 'withdrawdeposit':
            $mem_id = filter_var(htmlentities($_POST['mem_id']), FILTER_UNSAFE_RAW);
            $amount = filter_var(htmlentities($_POST['amount']), FILTER_UNSAFE_RAW);
            $depositbal = filter_var(htmlentities($_POST['available']), FILTER_UNSAFE_RAW);
            if ($amount == null || $mem_id == null) {
                echo "Please enter an amount to withdraw";
            } elseif (!is_numeric($amount) || $amount < 1) {
                echo "Please enter a valid amount";
            } elseif ($depositbal < $amount) {
                echo "Insufficient Balance to withdraw";
            } else {
                $sqlUpdate = $db_conn->prepare("UPDATE balances SET available = available - :amount WHERE mem_id = :mem_id");
                $sqlUpdate->bindParam(":amount", $amount, PDO::PARAM_STR);
                $sqlUpdate->bindParam(":mem_id", $mem_id, PDO::PARAM_STR);
                if ($sqlUpdate->execute()) {
                    echo "success";
                } else {
                    echo "An error occured!!";
                }
            }
            break;

        case 'updateCurr':
            $mem_id = filter_var(htmlentities($_POST['mem_id']), FILTER_UNSAFE_RAW);
            $currdaypro = filter_var(htmlentities($_POST['currdaypro']), FILTER_UNSAFE_RAW);
            $currdayloss = filter_var(htmlentities($_POST['currdayloss']), FILTER_UNSAFE_RAW);
            $alldaygain = filter_var(htmlentities($_POST['alldaygain']), FILTER_UNSAFE_RAW);
            if ($currdaypro == null || $currdayloss == null || $alldaygain == null || $mem_id == null) {
                echo "Please enter an amount to update";
            } elseif (!is_numeric($currdaypro) || $currdaypro < 1) {
                echo "Please enter a valid number for current day profit";
            } elseif (!is_numeric($currdayloss) || $currdayloss < 1) {
                echo "Please enter a valid number for current day loss";
            } elseif (!is_numeric($alldaygain) || $alldaygain < 1) {
                echo "Please enter a valid number for all day gain";
            } else {
                $sqlUpdate = $db_conn->prepare("UPDATE balances SET currdaypro = :currdaypro, currdayloss = :currdayloss, alldaygain = :alldaygain WHERE mem_id = :mem_id");
                $sqlUpdate->bindParam(":currdaypro", $currdaypro, PDO::PARAM_STR);
                $sqlUpdate->bindParam(":currdayloss", $currdayloss, PDO::PARAM_STR);
                $sqlUpdate->bindParam(":alldaygain", $alldaygain, PDO::PARAM_STR);
                $sqlUpdate->bindParam(":mem_id", $mem_id, PDO::PARAM_STR);
                if ($sqlUpdate->execute()) {
                    echo "success";
                } else {
                    echo "An error occured!!";
                }
            }
            break;

        case 'withdrawProfit':
            $mem_id = filter_var(htmlentities($_POST['mem_id']), FILTER_UNSAFE_RAW);
            $amount = filter_var(htmlentities($_POST['amount']), FILTER_UNSAFE_RAW);
            $profitbal = filter_var(htmlentities($_POST['profit']), FILTER_UNSAFE_RAW);
            if ($amount == null || $mem_id == null) {
                echo "Please enter an amount to withdraw";
            } elseif (!is_numeric($amount) || $amount < 1) {
                echo "Please enter a valid amount";
            } elseif ($profitbal < $amount) {
                echo "Insufficient Balance to withdraw";
            } else {
                $sqlUpdate = $db_conn->prepare("UPDATE balances SET profit = profit - :amount WHERE mem_id = :mem_id");
                $sqlUpdate->bindParam(":amount", $amount, PDO::PARAM_STR);
                $sqlUpdate->bindParam(":mem_id", $mem_id, PDO::PARAM_STR);
                if ($sqlUpdate->execute()) {
                    echo "success";
                } else {
                    echo "An error occured!!";
                }
            }
            break;

        case 'withdrawpending':
            $mem_id = filter_var(htmlentities($_POST['mem_id']), FILTER_UNSAFE_RAW);
            $amount = filter_var(htmlentities($_POST['amount']), FILTER_UNSAFE_RAW);
            $available = filter_var(htmlentities($_POST['pending']), FILTER_UNSAFE_RAW);
            if ($amount == null || $mem_id == null) {
                echo "Please enter an amount to withdraw";
            } elseif (!is_numeric($amount) || $amount < 1) {
                echo "Please enter a valid amount";
            } elseif ($available < $amount) {
                echo "Insufficient Balance to withdraw";
            } else {
                $sqlUpdate = $db_conn->prepare("UPDATE balances SET pending = pending - :amount WHERE mem_id = :mem_id");
                $sqlUpdate->bindParam(":amount", $amount, PDO::PARAM_STR);
                $sqlUpdate->bindParam(":mem_id", $mem_id, PDO::PARAM_STR);
                if ($sqlUpdate->execute()) {
                    echo "success";
                } else {
                    echo "An error occured!!";
                }
            }
            break;

        case 'withdrawbonus':
            $mem_id = filter_var(htmlentities($_POST['mem_id']), FILTER_UNSAFE_RAW);
            $amount = filter_var(htmlentities($_POST['amount']), FILTER_UNSAFE_RAW);
            $bonusbal = filter_var(htmlentities($_POST['bonus']), FILTER_UNSAFE_RAW);
            if ($amount == null || $mem_id == null) {
                echo "Please enter an amount to withdraw";
            } elseif (!is_numeric($amount) || $amount < 1) {
                echo "Please enter a valid amount";
            } elseif ($bonusbal < $amount) {
                echo "Insufficient Balance to withdraw";
            } else {
                $sqlUpdate = $db_conn->prepare("UPDATE balances SET bonus = bonus - :amount WHERE mem_id = :mem_id");
                $sqlUpdate->bindParam(":amount", $amount, PDO::PARAM_STR);
                $sqlUpdate->bindParam(":mem_id", $mem_id, PDO::PARAM_STR);
                if ($sqlUpdate->execute()) {
                    echo "success";
                } else {
                    echo "An error occured!!";
                }
            }
            break;
        case 'sendfundsAvl':
            $mem_id = filter_var(htmlentities($_POST['mem_id']), FILTER_UNSAFE_RAW);
            $amount = filter_var(htmlentities($_POST['amount']), FILTER_UNSAFE_RAW);
            $available = filter_var(htmlentities($_POST['available']), FILTER_UNSAFE_RAW);
            $email = filter_var(htmlentities($_POST['email']), FILTER_UNSAFE_RAW);
            $username = filter_var(htmlentities($_POST['username']), FILTER_UNSAFE_RAW);
            if ($amount == null || $mem_id == null) {
                echo "Please enter an amount to send";
            } elseif (!is_numeric($amount) || $amount < 1) {
                echo "Please enter a valid amount";
            } else {
                $sqlUpdate = $db_conn->prepare("UPDATE balances SET available = available + :amount WHERE mem_id = :mem_id");
                $sqlUpdate->bindParam(":amount", $amount, PDO::PARAM_STR);
                $sqlUpdate->bindParam(":mem_id", $mem_id, PDO::PARAM_STR);
                if ($sqlUpdate->execute()) {
                    echo "success";
                } else {
                    echo "There was an error processing your request";
                }
            }
            break;

        case 'sendfundsBonus':
            $mem_id = filter_var(htmlentities($_POST['mem_id']), FILTER_UNSAFE_RAW);
            $amount = filter_var(htmlentities($_POST['amount']), FILTER_UNSAFE_RAW);
            $bonus = filter_var(htmlentities($_POST['bonus']), FILTER_UNSAFE_RAW);
            $email = filter_var(htmlentities($_POST['email']), FILTER_UNSAFE_RAW);
            $username = filter_var(htmlentities($_POST['username']), FILTER_UNSAFE_RAW);
            if ($amount == null || $mem_id == null) {
                echo "Please enter an amount to send";
            } elseif (!is_numeric($amount) || $amount < 1) {
                echo "Please enter a valid amount";
            } else {
                $sqlUpdate = $db_conn->prepare("UPDATE balances SET bonus = bonus + :amount WHERE mem_id = :mem_id");
                $sqlUpdate->bindParam(":amount", $amount, PDO::PARAM_STR);
                $sqlUpdate->bindParam(":mem_id", $mem_id, PDO::PARAM_STR);
                if ($sqlUpdate->execute()) {
                    echo "success";
                } else {
                    echo "There was an error processing your request";
                }
            }
            break;

        case 'sendfundsPrf':
            $mem_id = filter_var(htmlentities($_POST['mem_id']), FILTER_UNSAFE_RAW);
            $amount = filter_var(htmlentities($_POST['amount']), FILTER_UNSAFE_RAW);
            $profit = filter_var(htmlentities($_POST['profit']), FILTER_UNSAFE_RAW);
            $email = filter_var(htmlentities($_POST['email']), FILTER_UNSAFE_RAW);
            $username = filter_var(htmlentities($_POST['username']), FILTER_UNSAFE_RAW);
            if ($amount == null || $mem_id == null) {
                echo "Please enter an amount to send";
            } elseif (!is_numeric($amount) || $amount < 1) {
                echo "Please enter a valid amount";
            } else {
                $sqlUpdate = $db_conn->prepare("UPDATE balances SET profit = profit + :amount WHERE mem_id = :mem_id");
                $sqlUpdate->bindParam(":amount", $amount, PDO::PARAM_STR);
                $sqlUpdate->bindParam(":mem_id", $mem_id, PDO::PARAM_STR);
                if ($sqlUpdate->execute()) {
                    echo "success";
                } else {
                    echo "There was an error processing your request";
                }
            }
            break;

        case 'apprInvest':
            $mem_id = filter_var(htmlentities($_POST['mem_id']), FILTER_UNSAFE_RAW);
            $main_id = filter_var(htmlentities($_POST['main_id']), FILTER_UNSAFE_RAW);
            $amount = filter_var(htmlentities($_POST['amount']), FILTER_UNSAFE_RAW);
            $plan = filter_var(htmlentities($_POST['plan']), FILTER_UNSAFE_RAW);
            if ($amount == null || $amount < 1) {
                echo "Please enter an upgrade amount to approve";
            } elseif (!is_numeric($amount)) {
                echo "Please enter a valid amount";
            } else {
                $stat = 1;
                $planUpdate = $db_conn->prepare("UPDATE userplans SET planstatus = :stat WHERE mem_id = :mem_id AND main_id = :main_id");
                $planUpdate->bindParam(":stat", $stat, PDO::PARAM_STR);
                $planUpdate->bindParam(":mem_id", $mem_id, PDO::PARAM_STR);
                $planUpdate->bindParam(":main_id", $main_id, PDO::PARAM_STR);
                if ($planUpdate->execute()) {
                    echo "success";
                } else {
                    echo "An error occured with plan update";
                }
            }
            break;

        case 'cancelInvest':
            $stat = 1;
            $status = 2;
            $mem_id = filter_var(htmlentities($_POST['mem_id']), FILTER_UNSAFE_RAW);
            $main_id = filter_var(htmlentities($_POST['main_id']), FILTER_UNSAFE_RAW);
            $sqlCancel = $db_conn->prepare("UPDATE userplans SET planstatus = :status WHERE mem_id = :mem_id AND planStatus = :stat");
            $sqlCancel->bindParam(":status", $status, PDO::PARAM_STR);
            $sqlCancel->bindParam(":mem_id", $mem_id, PDO::PARAM_STR);
            $sqlCancel->bindParam(":stat", $stat, PDO::PARAM_STR);
            if ($sqlCancel->execute()) {
                echo "success";
            } else {
                echo "An error occured. Try again!";
            }
            break;
        case 'approvewit':
            //             ini_set('display_errors', 1);
            // ini_set('display_startup_errors', 1);
            // error_reporting(E_ALL);
            $mem_id = filter_var(htmlentities($_POST['mem_id']), FILTER_UNSAFE_RAW);
            $transc_id = filter_var(htmlentities($_POST['transc_id']), FILTER_UNSAFE_RAW);
            $account = filter_var(htmlentities($_POST['account']), FILTER_UNSAFE_RAW);
            $amount = filter_var(htmlentities($_POST['amount']), FILTER_UNSAFE_RAW);

            if ($mem_id == null || $transc_id == null || $amount == null) {
                echo "All fields are required";
            } else {
                $getinv = $db_conn->prepare("SELECT pending FROM balances WHERE mem_id = :mem_id");
                $getinv->bindParam(":mem_id", $mem_id, PDO::PARAM_STR);
                $getinv->execute();
                $row = $getinv->fetch(PDO::FETCH_ASSOC);
                if ($row["pending"] < $amount) {
                    echo "Insufficient Balance";
                } else {
                    $updateEarn = $db_conn->prepare("UPDATE balances SET pending = pending - :pending WHERE mem_id = :mem_id");
                    $updateEarn->bindParam(":pending", $amount, PDO::PARAM_STR);
                    $updateEarn->bindParam(":mem_id", $mem_id, PDO::PARAM_STR);
                    if ($updateEarn->execute()) {
                        $status = 1;
                        $sqlUpdate = $db_conn->prepare("UPDATE wittransc SET status = :status WHERE transc_id = :transc_id AND mem_id = :mem_id");
                        $sqlUpdate->bindParam(":status", $status, PDO::PARAM_STR);
                        $sqlUpdate->bindParam(":transc_id", $transc_id, PDO::PARAM_STR);
                        $sqlUpdate->bindParam(":mem_id", $mem_id, PDO::PARAM_STR);
                        if ($sqlUpdate->execute()) {
                            $transUpd = $db_conn->prepare("UPDATE transactions SET status = :status WHERE transc_id = :transc_id AND mem_id = :mem_id");
                            $transUpd->bindParam(":status", $status, PDO::PARAM_STR);
                            $transUpd->bindParam(":transc_id", $transc_id, PDO::PARAM_STR);
                            $transUpd->bindParam(":mem_id", $mem_id, PDO::PARAM_STR);
                            $transUpd->execute();
                            echo "success";
                        } else {
                            $updateAvl = $db_conn->prepare("UPDATE balances SET pending = pending + :pending WHERE mem_id = :mem_id");
                            $updateAvl->bindParam(":pending", $amount, PDO::PARAM_STR);
                            $updateAvl->bindParam(":mem_id", $mem_id, PDO::PARAM_STR);
                            if ($updateAvl->execute()) {
                                echo "Withdrawal has failed to be approved. Please try again.";
                            }
                        }
                    } else {
                        echo "An error occured approving withdrawal";
                    }
                }
            }
            break;
        case 'failwit':
            $mem_id = filter_var(htmlentities($_POST['mem_id']), FILTER_UNSAFE_RAW);
            $transc_id = filter_var(htmlentities($_POST['transc_id']), FILTER_UNSAFE_RAW);
            $account = filter_var(htmlentities($_POST['account']), FILTER_UNSAFE_RAW);
            $transc_status = filter_var(htmlentities($_POST['status']), FILTER_UNSAFE_RAW);
            $amount = filter_var(htmlentities($_POST['amount']), FILTER_UNSAFE_RAW);

            if ($mem_id == null || $transc_id == null || $amount == null) {
                echo "All fields are required";
            } else {
                if ($transc_status == 1) {
                    $updateEarn = $db_conn->prepare("UPDATE balances SET $account = $account + :available WHERE mem_id = :mem_id");
                    $updateEarn->bindParam(":available", $amount, PDO::PARAM_STR);
                    $updateEarn->bindParam(":mem_id", $mem_id, PDO::PARAM_STR);
                    if ($updateEarn->execute()) {
                        $status = 2;
                        $sqlUpdate = $db_conn->prepare("UPDATE wittransc SET status = :status WHERE transc_id = :transc_id AND mem_id = :mem_id");
                        $sqlUpdate->bindParam(":status", $status, PDO::PARAM_STR);
                        $sqlUpdate->bindParam(":transc_id", $transc_id, PDO::PARAM_STR);
                        $sqlUpdate->bindParam(":mem_id", $mem_id, PDO::PARAM_STR);
                        if ($sqlUpdate->execute()) {
                            $transUpd = $db_conn->prepare("UPDATE transactions SET status = :status WHERE transc_id = :transc_id AND mem_id = :mem_id");
                            $transUpd->bindParam(":status", $status, PDO::PARAM_STR);
                            $transUpd->bindParam(":transc_id", $transc_id, PDO::PARAM_STR);
                            $transUpd->bindParam(":mem_id", $mem_id, PDO::PARAM_STR);
                            $transUpd->execute();
                            echo "success";
                        } else {
                            echo "Withdrawal did not fail. Please try again.";
                        }
                    } else {
                        echo "An error occured approving withdrawal";
                    }
                } elseif ($transc_status == 0) {
                    $updateEarn = $db_conn->prepare("UPDATE balances SET $account = $account + :amount, pending = pending - :pending WHERE mem_id = :mem_id");
                    $updateEarn->bindParam(":amount", $amount, PDO::PARAM_STR);
                    $updateEarn->bindParam(":pending", $amount, PDO::PARAM_STR);
                    $updateEarn->bindParam(":mem_id", $mem_id, PDO::PARAM_STR);
                    if ($updateEarn->execute()) {
                        $status = 2;
                        $sqlUpdate = $db_conn->prepare("UPDATE wittransc SET status = :status WHERE transc_id = :transc_id AND mem_id = :mem_id");
                        $sqlUpdate->bindParam(":status", $status, PDO::PARAM_STR);
                        $sqlUpdate->bindParam(":transc_id", $transc_id, PDO::PARAM_STR);
                        $sqlUpdate->bindParam(":mem_id", $mem_id, PDO::PARAM_STR);
                        if ($sqlUpdate->execute()) {
                            $transUpd = $db_conn->prepare("UPDATE transactions SET status = :status WHERE transc_id = :transc_id AND mem_id = :mem_id");
                            $transUpd->bindParam(":status", $status, PDO::PARAM_STR);
                            $transUpd->bindParam(":transc_id", $transc_id, PDO::PARAM_STR);
                            $transUpd->bindParam(":mem_id", $mem_id, PDO::PARAM_STR);
                            $transUpd->execute();
                            echo "success";
                        } else {
                            echo "Withdrawal did not fail. Please try again.";
                        }
                    } else {
                        echo "An error occured failing withdrawal";
                    }
                }
            }
            break;
        case 'changepassword':
            $mem_id = filter_var(htmlentities($_SESSION['admin_id']), FILTER_UNSAFE_RAW);
            $oldpass = filter_var(htmlentities($_POST['password']), FILTER_UNSAFE_RAW);
            $newpass = filter_var(htmlentities($_POST['newpassword']), FILTER_UNSAFE_RAW);
            $compass = filter_var(htmlentities($_POST['conpassword']), FILTER_UNSAFE_RAW);
            if ($oldpass == null || $newpass == null || $compass == null) {
                echo "All fields are required";
            } else if ($newpass != $compass) {
                echo "Passwords do not match!";
            } else {
                $users = $db_conn->prepare("SELECT * FROM admin WHERE admin_id = :mem_id");
                $users->bindParam(':mem_id', $mem_id, PDO::PARAM_STR);
                $users->execute();
                $row = $users->fetch(PDO::FETCH_ASSOC);
                $e_email = $row['email'];
                $old_pass = $row['password'];
                if (!password_verify($oldpass, $old_pass)) {
                    echo "Old Password is incorrect!!";
                } else {
                    $options = array(
                        SITE_NAME => 16,
                    );
                    $change_pass = password_hash($newpass, PASSWORD_BCRYPT, $options);
                    $sqlQuery = $db_conn->prepare("UPDATE admin SET password = :password WHERE admin_id = :mem_id");
                    $sqlQuery->bindParam(':password', $change_pass, PDO::PARAM_STR);
                    $sqlQuery->bindParam(':mem_id', $mem_id, PDO::PARAM_STR);
                    if ($sqlQuery->execute()) {
                        echo "success";
                    } else {
                        echo "An error occured changing password.";
                    }
                }
            }
            break;
        case 'editprofile':
            $mem_id = filter_var(htmlentities($_SESSION['admin_id']), FILTER_UNSAFE_RAW);
            //=================================================================================
            $username = filter_var(htmlentities($_POST['username']), FILTER_UNSAFE_RAW);
            $email = filter_var(htmlentities($_POST['email']), FILTER_UNSAFE_RAW);
            $phone = filter_var(htmlentities($_POST['phone']), FILTER_UNSAFE_RAW);
            $actpart = filter_var(htmlentities($_POST['actpart']), FILTER_UNSAFE_RAW);

            if ($username == null || $phone == null || $email == null || $actpart == null) {
                echo "All fields are required";
            } else if ($username == $_SESSION['admusername'] && $phone == $_SESSION['admphone'] && $email == $_SESSION['admemail'] && $actpart == $_SESSION['actpart']) {
                echo "No changes were made";
            } else {
                $emailCheck = $db_conn->prepare("SELECT email FROM admin WHERE email = :email");
                $emailCheck->bindParam(":email", $email, PDO::PARAM_STR);
                $emailCheck->execute();
                if ($emailCheck->rowCount() > 0 && $email != $_SESSION['admemail']) {
                    echo "This email address already exists";
                } else {
                    $editSql = $db_conn->prepare("UPDATE admin SET username = :username, email = :email, phone = :phone, actpart = :actpart WHERE admin_id = :mem_id");
                    $editSql->bindParam(":username", $username, PDO::PARAM_STR);
                    $editSql->bindParam(":email", $email, PDO::PARAM_STR);
                    $editSql->bindParam(":phone", $phone, PDO::PARAM_STR);
                    $editSql->bindParam(":actpart", $actpart, PDO::PARAM_STR);
                    $editSql->bindParam(":mem_id", $mem_id, PDO::PARAM_STR);
                    if ($editSql->execute()) {
                        echo "success";
                        $_SESSION['admusername'] = $username;
                        $_SESSION['admemail'] = $email;
                        $_SESSION['admphone'] = $phone;
                        $_SESSION['actpart'] = $actpart;
                    } else {
                        echo "There was an error making changes!";
                    }
                }
            }
            break;
        case 'closetrade':
            $mem_id = filter_var(htmlentities($_POST['mem_id']), FILTER_UNSAFE_RAW);
            $status = filter_var(htmlentities("0"), FILTER_UNSAFE_RAW);
            $tradeid = filter_var(htmlentities($_POST['tradeid']), FILTER_UNSAFE_RAW);
            $account = filter_var(htmlentities($_POST['account']), FILTER_UNSAFE_RAW);
            $amnt = filter_var(htmlentities($_POST['amnt']), FILTER_UNSAFE_RAW);
            $outcome = filter_var(htmlentities($_POST['outcome']), FILTER_UNSAFE_RAW);
            $finalprice = filter_var(htmlentities($_POST['finalprice']), FILTER_UNSAFE_RAW);
            $amount = filter_var(htmlentities($_POST['entry']), FILTER_UNSAFE_RAW);
            $accts = "";
            $earndate = date('d M, Y');
            if ($tradeid == null || $mem_id == null || $amount == null) {
                echo json_encode(["status" => "error", "message" => "Ensure all fields are completed"]);
            } else {
                $sql = $db_conn->prepare("UPDATE trades SET outcome = :outcome, oamount = :entry, finalprice = :finalprice, tradestatus = :status WHERE tradeid = :tradeid AND mem_id = :mem_id");
                $sql->bindParam(":outcome", $outcome, PDO::PARAM_STR);
                $sql->bindParam(":entry", $amount, PDO::PARAM_STR);
                $sql->bindParam(":finalprice", $finalprice, PDO::PARAM_STR);
                $sql->bindParam(":tradeid", $tradeid, PDO::PARAM_STR);
                $sql->bindParam(":status", $status, PDO::PARAM_STR);
                $sql->bindParam(":mem_id", $mem_id, PDO::PARAM_STR);
                if ($sql->execute()) {
                    if ($outcome == "Profit") {

                        $accts = 'profit';

                        // $prof = $amount + $amnt;
                        $sqlUpdate = $db_conn->prepare("UPDATE balances SET profit = profit + :prof, $account = $account + :amount WHERE mem_id = :mem_id");
                        $sqlUpdate->bindParam(":prof", $amount, PDO::PARAM_STR);
                        $sqlUpdate->bindParam(":amount", $amnt, PDO::PARAM_STR);
                        $sqlUpdate->bindParam(":mem_id", $mem_id, PDO::PARAM_STR);
                        if ($sqlUpdate->execute()) {
                            $sql = $db_conn->prepare("INSERT INTO earninghistory (outcome, amount, tradeid, earndate, mem_id) VALUES (:outcome, :amount, :tradeid, :earndate, :mem_id)");
                            $sql->bindParam(":outcome", $outcome, PDO::PARAM_STR);
                            $sql->bindParam(":amount", $amount, PDO::PARAM_STR);
                            $sql->bindParam(":tradeid", $tradeid, PDO::PARAM_STR);
                            $sql->bindParam(":earndate", $earndate, PDO::PARAM_STR);
                            $sql->bindParam(":mem_id", $mem_id, PDO::PARAM_STR);
                            if ($sql->execute()) {
                                $status = 1;
                                $transUpd = $db_conn->prepare("UPDATE transactions SET status = :status WHERE transc_id = :transc_id AND mem_id = :mem_id");
                                $transUpd->bindParam(":status", $status, PDO::PARAM_STR);
                                $transUpd->bindParam(":transc_id", $tradeid, PDO::PARAM_STR);
                                $transUpd->bindParam(":mem_id", $mem_id, PDO::PARAM_STR);
                                if ($transUpd->execute()) {
                                    echo json_encode(["status" => "success", "message" => "Trade closed successfully"]);
                                } else {
                                    echo json_encode(["status" => "error", "message" => "An error occured closing trade"]);
                                }
                            }
                        } else {
                            echo json_encode(["status" => "error", "message" => "There was an error closing trade"]);
                        }
                    } elseif ($outcome == "Loss") {
                        $accts = 'available';
                        $loss = $amnt - $amount;
                        $sqlUpdate = $db_conn->prepare("UPDATE balances SET $accts = $accts + :amount WHERE mem_id = :mem_id");
                        $sqlUpdate->bindParam(":amount", $loss, PDO::PARAM_STR);
                        $sqlUpdate->bindParam(":mem_id", $mem_id, PDO::PARAM_STR);
                        if ($sqlUpdate->execute()) {
                            $sql = $db_conn->prepare("INSERT INTO earninghistory (outcome, amount, tradeid, earndate, mem_id) VALUES (:outcome, :amount, :tradeid, :earndate, :mem_id)");
                            $sql->bindParam(":outcome", $outcome, PDO::PARAM_STR);
                            $sql->bindParam(":amount", $amount, PDO::PARAM_STR);
                            $sql->bindParam(":tradeid", $tradeid, PDO::PARAM_STR);
                            $sql->bindParam(":earndate", $earndate, PDO::PARAM_STR);
                            $sql->bindParam(":mem_id", $mem_id, PDO::PARAM_STR);
                            if ($sql->execute()) {
                                $status = 1;
                                $transUpd = $db_conn->prepare("UPDATE transactions SET status = :status WHERE transc_id = :transc_id AND mem_id = :mem_id");
                                $transUpd->bindParam(":status", $status, PDO::PARAM_STR);
                                $transUpd->bindParam(":transc_id", $tradeid, PDO::PARAM_STR);
                                $transUpd->bindParam(":mem_id", $mem_id, PDO::PARAM_STR);
                                if ($transUpd->execute()) {
                                    echo json_encode(["status" => "success", "message" => "Trade closed successfully"]);
                                } else {
                                    echo json_encode(["status" => "error", "message" => "An error occured closing trade"]);
                                }
                            }
                        } else {
                            echo json_encode(["status" => "error", "message" => "There was an error closing trade"]);
                        }
                    }
                }
            }
            break;
        case 'addtest':
            $main_id = str_pad(mt_rand(1, 9999999), 7, '0', STR_PAD_LEFT);
            $fullname = filter_var(htmlentities($_POST['fullname']), FILTER_UNSAFE_RAW);
            $role = filter_var(htmlentities($_POST['role']), FILTER_UNSAFE_RAW);
            $comment = filter_var(htmlentities($_POST['comment']), FILTER_UNSAFE_RAW);

            $checkname = $db_conn->prepare("SELECT fullname FROM testimonials WHERE fullname = :fullname");
            $checkname->bindParam(':fullname', $fullname, PDO::PARAM_STR);
            $checkname->execute();


            if ($fullname == null || $role == null || $comment == null) {
                echo json_encode(["status" => "error", "message" => "All fields are required"]);
            } elseif ($checkname->rowCount() > 0) {
                echo json_encode(["status" => "error", "message" => "Name already exists, please go back and edit"]);
                exit();
            } else {
                $test_add = $db_conn->prepare("INSERT INTO testimonials (main_id, fullname, role, message) VALUES (:main_id, :fullname, :role, :comment)");
                $test_add->bindParam(':main_id', $main_id, PDO::PARAM_STR);
                $test_add->bindParam(':fullname', $fullname, PDO::PARAM_STR);
                $test_add->bindParam(':role', $role, PDO::PARAM_STR);
                $test_add->bindParam(':comment', $comment, PDO::PARAM_STR);
                if ($test_add->execute()) {
                    echo json_encode(["status" => "success", "message" => "New testimonial added"]);
                } else {
                    echo json_encode(["status" => "error", "message" => "There was a problem adding new testimonial."]);
                }
            }
            break;

        case 'deletetest':
            $main_id = filter_var(htmlentities($_POST['main_id']), FILTER_UNSAFE_RAW);

            $sqlUpdate = $db_conn->prepare("DELETE FROM testimonials WHERE main_id = :main_id");
            $sqlUpdate->bindParam(":main_id", $main_id, PDO::PARAM_STR);
            if ($sqlUpdate->execute()) {
                echo json_encode(["status" => "success", "message" => "Testimonial deleted"]);
            } else {
                echo json_encode(["status" => "error", "message" => "Testimonial was not deleted"]);
            }
            break;

        case 'edittest':
            $main_id = filter_var(htmlentities($_POST['main_id']), FILTER_UNSAFE_RAW);
            $fullname = filter_var(htmlentities($_POST['fullname']), FILTER_UNSAFE_RAW);
            $role = filter_var(htmlentities($_POST['role']), FILTER_UNSAFE_RAW);
            $comment = filter_var(htmlentities($_POST['comment']), FILTER_UNSAFE_RAW);

            if ($main_id == null || $fullname == null || $role == null || $comment == null) {
                echo json_encode(["status" => "error", "message" => "All fields are required"]);
                exit();
            } else {
                $upd1 = $db_conn->prepare("UPDATE testimonials SET fullname = :fullname, role = :role, message = :comment WHERE main_id = :main_id");
                $upd1->bindParam(":fullname", $fullname, PDO::PARAM_STR);
                $upd1->bindParam(":role", $role, PDO::PARAM_STR);
                $upd1->bindParam(":comment", $comment, PDO::PARAM_STR);
                $upd1->bindParam(":main_id", $main_id, PDO::PARAM_STR);
                if ($upd1->execute()) {
                    echo json_encode(["status" => "success", "message" => "Testimonial edited successfully"]);
                } else {
                    echo json_encode(["status" => "error", "message" => "Testimonial was not edited sucessfully"]);
                }
            }
            break;
        case 'approveCopy':
            $trader = filter_var(htmlentities($_POST['trader_id']), FILTER_UNSAFE_RAW);
            $mem_id = filter_var(htmlentities($_POST['mem_id']), FILTER_UNSAFE_RAW);
            $status = filter_var(htmlentities(1), FILTER_UNSAFE_RAW);
            if ($mem_id == null) {
                echo "All fields are required";
            } else {
                $update1 = $db_conn->prepare("UPDATE members SET trader_status = :status WHERE mem_id = :mem_id");
                $update1->bindParam(":status", $status, PDO::PARAM_STR);
                $update1->bindParam(":mem_id", $mem_id, PDO::PARAM_STR);
                if ($update1->execute()) {

                    $sql2 = $db_conn->prepare("SELECT email, fullname, mem_id, username FROM members WHERE mem_id = :mem_id");
                    $sql2->bindParam(":mem_id", $mem_id, PDO::PARAM_STR);
                    $sql2->execute();
                    $row2 = $sql2->fetch(PDO::FETCH_ASSOC);
                    $sql3 = $db_conn->prepare("SELECT t_name, trader_id FROM traders WHERE trader_id = :trader_id");
                    $sql3->bindParam(":trader_id", $trader, PDO::PARAM_STR);
                    $sql3->execute();
                    $row3 = $sql3->fetch(PDO::FETCH_ASSOC);

                    $mail->addAddress($row2['email'], $row2['fullname']); // Set the recipient of the message.
                    $mail->Subject = 'Copy Request Approved'; // The subject of the message.
                    //$mail->SMTPDebug = 1;
                    $mail->isHTML(true);
                    $message .= '<div align="left" style="margin: 2px 10px; padding: 5px 9px; font-size:14px; font-family: montserrat; line-height:1.6rem; border: 2px solid #66f; border-radius: 12px;">';
                    $message .= '<center><img src="https://www.' . SITE_ADDRESS . '/assets/images/logo-dark.png" alt="Copy Trader Request Approved" style="max-width: 100%; border-top-left-radius: 12px; border-top-right-radius: 12px;"></center>';
                    $message .= '<div style="padding: 10px 20px;" align="left"><h1>Hello ' . $row2['fullname'] . ', </h1>';
                    $message .= '<p>Your request to copy trades from <b>' . $row3['t_name'] . '</b> has been approved.</p>';
                    $message .= '<p>Please login to your dashboard to continue.</p>';
                    $message .= "<p>Happy Trading,</p>";
                    $message .= "<p>Admin <b>" . SITE_NAME . "</b>.</p><br>";
                    $message .= "<p style='text-align: center;'>&copy;" . date('Y') . " " . SITE_NAME . " All Rights Reserved</p></div></div>";
                    $mail->Body = $message; // Set a plain text body.

                    if ($mail->send()) {
                        echo "success";
                    } else {
                        echo "Trading request has been approved.";
                    }
                } else {
                    "Approval was not successful";
                }
            }
            break;

        case 'cancelCopy':
            $mem_id = filter_var(htmlentities($_POST['mem_id']), FILTER_UNSAFE_RAW);
            $status = filter_var(htmlentities(0), FILTER_UNSAFE_RAW);
            if ($mem_id == null) {
                echo "All fields are required";
            } else {
                $update1 = $db_conn->prepare("UPDATE members SET trader_status = :status WHERE mem_id = :mem_id");
                $update1->bindParam(":status", $status, PDO::PARAM_STR);
                $update1->bindParam(":mem_id", $mem_id, PDO::PARAM_STR);
                if ($update1->execute()) {
                    echo "success";
                } else {
                    "Cancellation was not successful";
                }
            }
            break;
        case 'editTrader':
            $trader_id = filter_var(htmlentities($_POST['trader_id']), FILTER_UNSAFE_RAW);
            $t_name = filter_var(htmlentities($_POST['t_name']), FILTER_UNSAFE_RAW);
            $t_followers = filter_var(htmlentities($_POST['t_followers']), FILTER_UNSAFE_RAW);
            $t_total_win = filter_var(htmlentities($_POST['t_total_win']), FILTER_UNSAFE_RAW);
            $t_minimum = filter_var(htmlentities($_POST['t_minimum']), FILTER_UNSAFE_RAW);
            $t_total_loss = filter_var(htmlentities($_POST['t_total_loss']), FILTER_UNSAFE_RAW);
            $stars = filter_var(htmlentities($_POST['stars']), FILTER_UNSAFE_RAW);
            $t_win_rate = filter_var(htmlentities($_POST['t_win_rate']), FILTER_UNSAFE_RAW);
            $t_profit_share = filter_var(htmlentities($_POST['t_profit_share']), FILTER_UNSAFE_RAW);

            $photo = filter_var(htmlentities($_POST['myphoto']), FILTER_UNSAFE_RAW);

            if ($trader_id == null || $t_name == null || $t_followers == null || $t_total_win == null || $t_total_loss == null || $stars == null || $t_win_rate == null || $t_profit_share == null) {
                echo "All fields are required";
            } elseif ($_FILES["photo"]["name"] == null) {
                if (!is_numeric($t_win_rate)) {
                    echo "Enter only numeric values for Win Rate";
                } elseif (!is_numeric($t_profit_share)) {
                    echo "Enter only numeric values for Profit Share";
                } else {
                    $sql = $db_conn->prepare("UPDATE traders SET t_name = :t_name, t_win_rate = :t_win_rate, t_minimum = :t_minimum, t_profit_share = :t_profit_share, stars = :stars, t_followers = :t_followers, t_total_win = :t_total_win, t_total_loss = :t_total_loss WHERE trader_id = :trader_id");
                    $sql->bindParam(":t_name", $t_name, PDO::PARAM_STR);
                    $sql->bindParam(":t_win_rate", $t_win_rate, PDO::PARAM_STR);
                    $sql->bindParam(":t_minimum", $t_minimum, PDO::PARAM_STR);
                    $sql->bindParam(":t_profit_share", $t_profit_share, PDO::PARAM_STR);
                    $sql->bindParam(":stars", $stars, PDO::PARAM_STR);
                    $sql->bindParam(":t_followers", $t_followers, PDO::PARAM_STR);
                    $sql->bindParam(":t_total_win", $t_total_win, PDO::PARAM_STR);
                    $sql->bindParam(":t_total_loss", $t_total_loss, PDO::PARAM_STR);
                    $sql->bindParam(":trader_id", $trader_id, PDO::PARAM_STR);
                    if ($sql->execute()) {
                        echo "success";
                    } else {
                        echo "There was an error adding new trader";
                    }
                }
            } else {
                $fileName = $_FILES["photo"]["name"];
                $fileTmpLoc = $_FILES["photo"]["tmp_name"];
                $fileType = $_FILES["photo"]["type"];
                $fileSize = $_FILES["photo"]["size"];
                $fileErrorMsg = $_FILES["photo"]["error"];
                $fileName = preg_replace('#[^a-z.0-9]#i', '', $fileName);
                $kaboom = explode(".", $fileName);
                $fileExt = end($kaboom);
                $fileName = $trader_id . "." . $fileExt;

                if ($fileSize > 8422145) {
                    echo "Your image must be less than 8MB of size.";
                    unlink($fileTmpLoc);
                    exit();
                }
                if (!preg_match("/.(jpeg|jpg|png|webp|heic|avif)$/i", $fileName)) {
                    echo "Your image was not jpeg, jpg, webp or png file.";
                    unlink($fileTmpLoc);
                    exit();
                }
                if ($fileErrorMsg == 1) {
                    echo "An error occured while processing the image. Try again.";
                    exit();
                } else {
                    if (is_file("../assets/images/traders/$photo")) {
                        $delimg = unlink("../assets/images/traders/$photo");
                        if ($delimg) {
                            $moveResult = move_uploaded_file($fileTmpLoc, "../assets/images/traders/$fileName");
                            if ($moveResult != true) {
                                echo "ERROR: File not uploaded. Try again.";
                                exit();
                            } else {
                                if (!is_numeric($t_win_rate)) {
                                    echo "Enter only numeric values for Win Rate";
                                } elseif (!is_numeric($t_profit_share)) {
                                    echo "Enter only numeric values for Profit Share";
                                } else {
                                    $sql = $db_conn->prepare("UPDATE traders SET t_name = :t_name, t_win_rate = :t_win_rate, t_minimum = :t_minimum, t_profit_share = :t_profit_share, t_photo1 = :t_photo1, stars = :stars, t_followers = :t_followers, t_total_win = :t_total_win, t_total_loss = :t_total_loss WHERE trader_id = :trader_id");
                                    $sql->bindParam(":t_name", $t_name, PDO::PARAM_STR);
                                    $sql->bindParam(":t_win_rate", $t_win_rate, PDO::PARAM_STR);
                                    $sql->bindParam(":t_minimum", $t_minimum, PDO::PARAM_STR);
                                    $sql->bindParam(":t_profit_share", $t_profit_share, PDO::PARAM_STR);
                                    $sql->bindParam(":t_photo1", $fileName, PDO::PARAM_STR);
                                    $sql->bindParam(":stars", $stars, PDO::PARAM_STR);
                                    $sql->bindParam(":t_followers", $t_followers, PDO::PARAM_STR);
                                    $sql->bindParam(":t_total_win", $t_total_win, PDO::PARAM_STR);
                                    $sql->bindParam(":t_total_loss", $t_total_loss, PDO::PARAM_STR);
                                    $sql->bindParam(":trader_id", $trader_id, PDO::PARAM_STR);
                                    if ($sql->execute()) {
                                        echo "success";
                                    } else {
                                        echo "There was an error adding new trader";
                                        unlink("../assets/images/traders/$fileName");
                                    }
                                }
                            }
                        }
                    }
                }
            }
            // ============================================ //
            break;
        case 'addTrader':
            $trader_id = filter_var(htmlentities(str_pad(mt_rand(1, 9999999999999), 2, '0', STR_PAD_LEFT)), FILTER_UNSAFE_RAW);
            $t_name = filter_var(htmlentities($_POST['t_name']), FILTER_UNSAFE_RAW);
            $t_win_rate = filter_var(htmlentities($_POST['t_win_rate']), FILTER_UNSAFE_RAW);
            $t_profit_share = filter_var(htmlentities($_POST['t_profit_share']), FILTER_UNSAFE_RAW);
            $t_followers = filter_var(htmlentities($_POST['t_followers']), FILTER_UNSAFE_RAW);
            $t_total_win = filter_var(htmlentities($_POST['t_total_win']), FILTER_UNSAFE_RAW);
            $t_minimum = filter_var(htmlentities($_POST['t_minimum']), FILTER_UNSAFE_RAW);
            $t_total_loss = filter_var(htmlentities($_POST['t_total_loss']), FILTER_UNSAFE_RAW);
            $stars = filter_var(htmlentities($_POST['stars']), FILTER_UNSAFE_RAW);
            $t_status = filter_var(htmlentities('1'), FILTER_UNSAFE_RAW);


            if ($trader_id == null || $t_name == null || $t_followers == null || $t_minimum == null || $stars == null || $t_win_rate == null || $t_total_win == null || $t_total_loss == null || $t_profit_share == null || $t_status == null) {
                echo "All fields are required";
            } elseif ($_FILES["photo"]["name"] == null) {
                echo "Please select an image to upload";
            } else {
                if (!is_numeric($t_win_rate)) {
                    echo "Enter only numeric values for win rate";
                } elseif (!is_numeric($t_profit_share)) {
                    echo "Enter only numeric values for profit share";
                } else {
                    $fileName = $_FILES["photo"]["name"];
                    $fileTmpLoc = $_FILES["photo"]["tmp_name"];
                    $fileType = $_FILES["photo"]["type"];
                    $fileSize = $_FILES["photo"]["size"];
                    $fileErrorMsg = $_FILES["photo"]["error"];
                    $fileName = preg_replace('#[^a-z.0-9]#i', '', $fileName);
                    $kaboom = explode(".", $fileName);
                    $fileExt = end($kaboom);
                    $fileName = $trader_id . "." . $fileExt;

                    if ($fileSize > 8422145) {
                        echo "Your image must be less than 8MB of size.";
                        unlink($fileTmpLoc);
                        exit();
                    }
                    if (!preg_match("/.(jpeg|jpg|png|webp|heic|heic|avif)$/i", $fileName)) {
                        echo "Your image was not jpeg, jpg, or png file.";
                        unlink($fileTmpLoc);
                        exit();
                    }
                    if ($fileErrorMsg == 1) {
                        echo "An error occured while processing the image. Try again.";
                        exit();
                    } else {
                        $moveResult = move_uploaded_file($fileTmpLoc, "../assets/images/traders/$fileName");
                        if ($moveResult != true) {
                            echo "ERROR: File not uploaded. Try again.";
                            exit();
                        } else {
                            $sql = $db_conn->prepare("INSERT INTO traders (trader_id, t_name, t_win_rate, t_minimum, t_profit_share, t_photo1, t_followers, t_total_win, t_total_loss, stars, t_status) VALUES (:trader_id, :t_name, :t_win_rate, :t_minimum, :t_profit_share, :t_photo1, :t_followers, :t_total_win, :t_total_loss, :stars, :t_status)");
                            $sql->bindParam(":trader_id", $trader_id, PDO::PARAM_STR);
                            $sql->bindParam(":t_name", $t_name, PDO::PARAM_STR);
                            $sql->bindParam(":t_win_rate", $t_win_rate, PDO::PARAM_STR);
                            $sql->bindParam(":t_minimum", $t_minimum, PDO::PARAM_STR);
                            $sql->bindParam(":t_profit_share", $t_profit_share, PDO::PARAM_STR);
                            $sql->bindParam(":t_photo1", $fileName, PDO::PARAM_STR);
                            $sql->bindParam(":t_followers", $t_followers, PDO::PARAM_STR);
                            $sql->bindParam(":t_total_win", $t_total_win, PDO::PARAM_STR);
                            $sql->bindParam(":t_total_loss", $t_total_loss, PDO::PARAM_STR);
                            $sql->bindParam(":stars", $stars, PDO::PARAM_STR);
                            $sql->bindParam(":t_status", $t_status, PDO::PARAM_STR);
                            if ($sql->execute()) {
                                echo "success";
                            } else {
                                echo "There was an error adding new trader";
                                unlink("../assets/images/traders/$fileName");
                            }
                        }
                    }
                }
            }
            break;

        case "deleteTrader":
            $trader_id = filter_var(htmlentities($_POST['trader_id']), FILTER_UNSAFE_RAW);
            $photo = filter_var(htmlentities($_POST['photo']), FILTER_UNSAFE_RAW);

            if ($trader_id != null && $photo != null) {
                if (is_file("../assets/images/traders/$photo")) {
                    $del = unlink("../assets/images/traders/$photo");
                    if ($del) {
                        $delTrader = $db_conn->prepare("DELETE FROM traders where trader_id = :trader_id");
                        $delTrader->bindParam(":trader_id", $trader_id, PDO::PARAM_STR);
                        if ($delTrader->execute()) {
                            echo "success";
                        } else {
                            echo "Error! An error occured while deleting this trader";
                        }
                    }
                } else {
                    $delTrader = $db_conn->prepare("DELETE FROM traders where trader_id = :trader_id");
                    $delTrader->bindParam(":trader_id", $trader_id, PDO::PARAM_STR);
                    if ($delTrader->execute()) {
                        echo "success";
                    } else {
                        echo "Error! An error occured while deleting this trader";
                    }
                }
            }
            break;
        case 'addProfit':
            $transc_id = filter_var(htmlentities($_POST['transc_id']), FILTER_UNSAFE_RAW);
            $mem_id = filter_var(htmlentities($_POST['mem_id']), FILTER_UNSAFE_RAW);
            $duration = filter_var(htmlentities($_POST['duration']), FILTER_UNSAFE_RAW);
            $status = filter_var(htmlentities($_POST['status']), FILTER_UNSAFE_RAW);
            $amount = filter_var(htmlentities($_POST['profit']), FILTER_UNSAFE_RAW);
            if ($transc_id == null || $mem_id == null || $amount == null || $duration == null || $status == null) {
                echo "All fields are required";
            } elseif (!is_numeric($amount) || $amount < 0) {
                echo "Enter a valid amount for profit";
            } else {
                $updInv = $db_conn->prepare("UPDATE comminvest SET duration = :duration, profit = profit + :profit, status = :status WHERE transc_id = :transc_id AND mem_id = :mem_id");
                $updInv->bindParam(":duration", $duration, PDO::PARAM_STR);
                $updInv->bindParam(":profit", $amount, PDO::PARAM_STR);
                $updInv->bindParam(":status", $status, PDO::PARAM_STR);
                $updInv->bindParam(":transc_id", $transc_id, PDO::PARAM_STR);
                $updInv->bindParam(":mem_id", $mem_id, PDO::PARAM_STR);
                if ($updInv->execute()) {
                    $updateEarn = $db_conn->prepare("UPDATE balances SET profit = profit + :amount WHERE mem_id = :mem_id");
                    $updateEarn->bindParam(":amount", $amount, PDO::PARAM_STR);
                    $updateEarn->bindParam(":mem_id", $mem_id, PDO::PARAM_STR);
                    if ($updateEarn->execute()) {
                        echo "success";
                    } else {
                        echo "an error occured adding profit";
                    }
                }
            }
            break;
        case 'addNft':
            $nftid = "NFT" . str_pad(mt_rand(1, 999999), 2, '0', STR_PAD_LEFT);
            $nftname = filter_var(htmlentities($_POST['nftname']), FILTER_UNSAFE_RAW);
            $nftaddr = filter_var(htmlentities($_POST['nftaddr']), FILTER_UNSAFE_RAW);
            $nftprice = filter_var(htmlentities($_POST['nftprice']), FILTER_UNSAFE_RAW);
            $nftdesc = filter_var(htmlentities($_POST['nftdesc']), FILTER_UNSAFE_RAW);
            $nftstandard = filter_var(htmlentities($_POST['nftstandard']), FILTER_UNSAFE_RAW);
            $nftblockchain = filter_var(htmlentities($_POST['nftblockchain']), FILTER_UNSAFE_RAW);
            $nftroi = filter_var(htmlentities($_POST['nftroi']), FILTER_UNSAFE_RAW);
            $nfttype = filter_var(htmlentities($_POST['type']), FILTER_UNSAFE_RAW);
            $status = filter_var(htmlentities(0), FILTER_UNSAFE_RAW);


            $fileName = $_FILES["photo"]["name"];
            $fileTmpLoc = $_FILES["photo"]["tmp_name"];
            $fileType = $_FILES["photo"]["type"];
            $fileSize = $_FILES["photo"]["size"];
            $fileErrorMsg = $_FILES["photo"]["error"];
            $fileName = preg_replace('#[^a-z.0-9]#i', '', $fileName);
            $kaboom = explode(".", $fileName);
            $fileExt = end($kaboom);
            $newname = strtolower(str_replace(" ", "_", $nftname));
            $fileName = $newname . "nft." . $fileExt;
            if ($nftid == null || $nftname == null || $nftprice == null || $nftaddr == null || $nftdesc == null || $nftstandard == null || $nftblockchain == null || $nftroi == null || $nfttype == null || $_FILES["photo"]["name"] == null) {
                echo "All fields are required";
                exit();
            }
            if ($fileSize > 8422145) {
                echo "Your image must be less than 8MB of size.";
                unlink($fileTmpLoc);
                exit();
            }
            if (!preg_match("/.(jpeg|jpg|png|gif|mp4|webp|mkv)$/i", $fileName)) {
                echo "Your image was not jpeg, jpg, gif, mp4, mkv or png file.";
                unlink($fileTmpLoc);
                exit();
            }
            if ($fileErrorMsg == 1) {
                echo "An error occured while processing the image. Try again.";
                exit();
            } elseif (!is_numeric($nftprice)) {
                echo "Enter only numeric values for NFT Price";
                exit();
            } else {
                if (!is_numeric($nftroi)) {
                    echo "Enter only numeric values for max ROI";
                } else {
                    $count = 7;
                    mt_srand((int)microtime());
                    $roiArr = array();
                    $i = 0;
                    while ($i++ < $count) {
                        $roiArr[] = round(-10 + lcg_value() * (abs($nftroi - (-10))), 2);
                        shuffle($roiArr);
                        sort($roiArr);
                    }
                    $newroi = filter_var(htmlentities(implode(",", $roiArr)), FILTER_UNSAFE_RAW);
                    if ($nfttype == "image") {
                        $file = strtolower($nftid . "file." . $fileExt);
                        $moveResult = move_uploaded_file($fileTmpLoc, "../assets/nft/images/$fileName");
                        if ($moveResult != true) {
                            echo "ERROR: File not uploaded. Try again.";
                            exit();
                        } else {
                            $update1 = $db_conn->prepare("INSERT INTO nfts (nftid, nftname, nftprice, nftaddr, nftroi, nftdesc, nfttype, nftblockchain, nftstandard, nftimage, nftfile, nftstatus) VALUES (:nftid, :nftname, :nftprice, :nftaddr, :nftroi, :nftdesc, :nfttype, :nftblockchain, :nftstandard, :nftimage, :nftfile, :nftstatus)");
                            $update1->bindParam(":nftid", $nftid, PDO::PARAM_STR);
                            $update1->bindParam(":nftname", $nftname, PDO::PARAM_STR);
                            $update1->bindParam(":nftprice", $nftprice, PDO::PARAM_STR);
                            $update1->bindParam(":nftaddr", $nftaddr, PDO::PARAM_STR);
                            $update1->bindParam(":nftroi", $newroi, PDO::PARAM_STR);
                            $update1->bindParam(":nftdesc", $nftdesc, PDO::PARAM_STR);
                            $update1->bindParam(":nfttype", $nfttype, PDO::PARAM_STR);
                            $update1->bindParam(":nftblockchain", $nftblockchain, PDO::PARAM_STR);
                            $update1->bindParam(":nftstandard", $nftstandard, PDO::PARAM_STR);
                            $update1->bindParam(":nftimage", $fileName, PDO::PARAM_STR);
                            $update1->bindParam(":nftfile", $file, PDO::PARAM_STR);
                            $update1->bindParam(":nftstatus", $status, PDO::PARAM_STR);
                            if ($update1->execute()) {
                                echo "success";
                            } else {
                                unlink("../assets/nft/images/$fileName");
                                echo "The NFT was not uploaded";
                            }
                        }
                    } elseif ($nfttype == "video") {
                        if ($_FILES["file"]["name"] == null) {
                            echo "Please select a video file";
                        } elseif (!preg_match("/.(gif|mp4|mkv)$/i", $fileName)) {
                            echo "Your file was not gif, mp4 or mkv file.";
                            unlink($fileTmpLoc);
                            exit();
                        } else {
                            $fileName2 = $_FILES["file"]["name"];
                            $fileTmpLoc2 = $_FILES["file"]["tmp_name"];
                            $fileType2 = $_FILES["file"]["type"];
                            $fileSize2 = $_FILES["file"]["size"];
                            $fileErrorMsg2 = $_FILES["file"]["error"];
                            $fileName2 = preg_replace('#[^a-z.0-9]#i', '', $fileName2);
                            $kaboom2 = explode(".", $fileName2);
                            $fileExt2 = end($kaboom2);
                            $fileName2 = strtolower($nftid . "file." . $fileExt2);

                            $moveResult = move_uploaded_file($fileTmpLoc, "../assets/nft/images/$fileName");
                            if ($moveResult != true) {
                                echo "ERROR: File not uploaded. Try again.";
                                exit();
                            } else {
                                $moveResult2 = move_uploaded_file($fileTmpLoc2, "../assets/nft/videos/$fileName2");
                                if ($moveResult2 != true) {
                                    echo "ERROR: your video was not uploaded. Try again.";
                                } else {
                                    $update1 = $db_conn->prepare("INSERT INTO nfts (nftid, nftname, nftprice, nfttype, nftaddr, nftroi, nftdesc, nftblockchain, nftstandard, nftimage, nftfile, nftstatus) VALUES (:nftid, :nftname, :nftprice, :nfttype, :nftaddr, :nftroi, :nftdesc, :nftblockchain, :nftstandard, :nftimage, :nftfile, :nftstatus)");
                                    $update1->bindParam(":nftid", $nftid, PDO::PARAM_STR);
                                    $update1->bindParam(":nftname", $nftname, PDO::PARAM_STR);
                                    $update1->bindParam(":nftprice", $nftprice, PDO::PARAM_STR);
                                    $update1->bindParam(":nfttype", $nfttype, PDO::PARAM_STR);
                                    $update1->bindParam(":nftaddr", $nftaddr, PDO::PARAM_STR);
                                    $update1->bindParam(":nftroi", $newroi, PDO::PARAM_STR);
                                    $update1->bindParam(":nftdesc", $nftdesc, PDO::PARAM_STR);
                                    $update1->bindParam(":nftblockchain", $nftblockchain, PDO::PARAM_STR);
                                    $update1->bindParam(":nftstandard", $nftstandard, PDO::PARAM_STR);
                                    $update1->bindParam(":nftimage", $fileName, PDO::PARAM_STR);
                                    $update1->bindParam(":nftfile", $fileName2, PDO::PARAM_STR);
                                    $update1->bindParam(":nftstatus", $status, PDO::PARAM_STR);
                                    if ($update1->execute()) {
                                        echo "success";
                                    } else {
                                        unlink("../asset/nft/images/$fileName");
                                        echo "The NFT was not uploaded";
                                    }
                                }
                            }
                        }
                    }
                }
            }
            break;
        case 'approveNft':
            $nftid = filter_var(htmlentities($_POST['nftid']), FILTER_UNSAFE_RAW);
            $status = filter_var(htmlentities(1), FILTER_UNSAFE_RAW);
            if ($nftid == null) {
                echo "All fields are required";
            } else {
                $update1 = $db_conn->prepare("UPDATE nfts SET nftstatus = :status WHERE nftid = :nftid");
                $update1->bindParam(":status", $status, PDO::PARAM_STR);
                $update1->bindParam(":nftid", $nftid, PDO::PARAM_STR);
                if ($update1->execute()) {
                    echo "success";
                } else {
                    "NFT was not published";
                }
            }
            break;

        case 'cancelNft':
            $nftid = filter_var(htmlentities($_POST['nftid']), FILTER_UNSAFE_RAW);
            $status = filter_var(htmlentities(0), FILTER_UNSAFE_RAW);
            if ($nftid == null) {
                echo "All fields are required";
            } else {
                $update1 = $db_conn->prepare("UPDATE nfts SET nftstatus = :status WHERE nftid = :nftid");
                $update1->bindParam(":status", $status, PDO::PARAM_STR);
                $update1->bindParam(":nftid", $nftid, PDO::PARAM_STR);
                if ($update1->execute()) {
                    echo "success";
                } else {
                    "NFT was not cancelled";
                }
            }
            break;

        case 'editNft':
            $nftid = filter_var(htmlentities($_POST['nftid']), FILTER_UNSAFE_RAW);
            $nftname = filter_var(htmlentities($_POST['nftname']), FILTER_UNSAFE_RAW);
            $nftaddr = filter_var(htmlentities($_POST['nftaddr']), FILTER_UNSAFE_RAW);
            $nftprice = filter_var(htmlentities($_POST['nftprice']), FILTER_UNSAFE_RAW);
            $nftdesc = filter_var(htmlentities($_POST['nftdesc']), FILTER_UNSAFE_RAW);
            $nftstandard = filter_var(htmlentities($_POST['nftstandard']), FILTER_UNSAFE_RAW);
            $nftblockchain = filter_var(htmlentities($_POST['nftblockchain']), FILTER_UNSAFE_RAW);
            $nftroi = filter_var(htmlentities($_POST['nftroi']), FILTER_UNSAFE_RAW);
            $photo = filter_var(htmlentities($_POST['photos']), FILTER_UNSAFE_RAW);
            $files = filter_var(htmlentities($_POST['files']), FILTER_UNSAFE_RAW);
            $nfttype = filter_var(htmlentities($_POST['type']), FILTER_UNSAFE_RAW);
            $status = filter_var(htmlentities(0), FILTER_UNSAFE_RAW);

            if ($nftid == null || $nftname == null || $nftprice == null || $nftaddr == null || $nftdesc == null || $nftstandard == null || $nftblockchain == null || $nftroi == null || $nfttype == null) {
                echo "All fields are required";
                exit();
            } elseif (!is_numeric($nftprice)) {
                echo "Enter only numeric values for NFT Price";
                exit();
            } else {
                if (false) {
                    echo "Enter only numeric values for max ROI";
                } else {
                    $count = 7;
                    mt_srand((int)microtime());
                    $roiArr = array();
                    $i = 0;
                    while ($i++ < $count) {
                        $roiArr[] = round(-10 + lcg_value() * (abs($nftroi - (-10))), 2);
                        shuffle($roiArr);
                        sort($roiArr);
                    }
                    $newroi = filter_var(htmlentities(implode(",", $roiArr)), FILTER_UNSAFE_RAW);
                    if ($nfttype == "image") {
                        if ($_FILES["photo"]["name"] == null) {
                            $update1 = $db_conn->prepare("UPDATE nfts SET nftname = :nftname, nftaddr = :nftaddr, nftprice = :nftprice, nftdesc = :nftdesc, nftstandard = :nftstandard, nftblockchain = :nftblockchain, nftroi = :nftroi, nfttype = :nfttype WHERE nftid = :nftid AND nftstatus = :nftstatus");
                            $update1->bindParam(":nftname", $nftname, PDO::PARAM_STR);
                            $update1->bindParam(":nftaddr", $nftaddr, PDO::PARAM_STR);
                            $update1->bindParam(":nftprice", $nftprice, PDO::PARAM_STR);
                            $update1->bindParam(":nftdesc", $nftdesc, PDO::PARAM_STR);
                            $update1->bindParam(":nftstandard", $nftstandard, PDO::PARAM_STR);
                            $update1->bindParam(":nftblockchain", $nftblockchain, PDO::PARAM_STR);
                            $update1->bindParam(":nftroi", $newroi, PDO::PARAM_STR);
                            $update1->bindParam(":nfttype", $nfttype, PDO::PARAM_STR);
                            $update1->bindParam(":nftid", $nftid, PDO::PARAM_STR);
                            $update1->bindParam(":nftstatus", $status, PDO::PARAM_STR);
                            if ($update1->execute()) {
                                echo "success";
                            } else {
                                echo "There was an error editing this NFT";
                            }
                        } elseif ($_FILES["photo"]["name"] != null) {
                            $fileName = $_FILES["photo"]["name"];
                            $fileTmpLoc = $_FILES["photo"]["tmp_name"];
                            $fileType = $_FILES["photo"]["type"];
                            $fileSize = $_FILES["photo"]["size"];
                            $fileErrorMsg = $_FILES["photo"]["error"];
                            $fileName = preg_replace('#[^a-z.0-9]#i', '', $fileName);
                            $kaboom = explode(".", $fileName);
                            $fileExt = end($kaboom);
                            $newname = strtolower(str_replace(" ", "_", $nftname));
                            $fileName = $newname . "nft." . $fileExt;
                            if ($fileSize > 8422145) {
                                echo "Your image must be less than 8MB of size.";
                                unlink($fileTmpLoc);
                                exit();
                            }
                            if (!preg_match("/.(jpeg|jpg|png|webp)$/i", $fileName)) {
                                echo "Your image was not jpeg, jpg, webp or png file.";
                                unlink($fileTmpLoc);
                                exit();
                            }
                            if ($fileErrorMsg == 1) {
                                echo "An error occured while processing the image. Try again.";
                                exit();
                            } elseif (!is_numeric($nftprice)) {
                                echo "Enter only numeric values for NFT Price";
                                exit();
                            } else {
                                $file = strtolower($nftid . "file." . $fileExt);
                                if (is_file("../assets/nft/images/$photo")) {
                                    $del = unlink("../assets/nft/images/$photo");
                                    if ($del) {
                                        $moveResult = move_uploaded_file($fileTmpLoc, "../assets/nft/images/$fileName");
                                        if ($moveResult != true) {
                                            echo "ERROR: File not uploaded. Try again.";
                                            exit();
                                        } else {
                                            $update1 = $db_conn->prepare("UPDATE nfts SET nftname = :nftname, nftaddr = :nftaddr, nftprice = :nftprice, nftdesc = :nftdesc, nftstandard = :nftstandard, nftblockchain = :nftblockchain, nftroi = :nftroi, nfttype = :nfttype, nftimage = :nftimage, nftfile = :nftfile WHERE nftid = :nftid AND nftstatus = :nftstatus");
                                            $update1->bindParam(":nftname", $nftname, PDO::PARAM_STR);
                                            $update1->bindParam(":nftaddr", $nftaddr, PDO::PARAM_STR);
                                            $update1->bindParam(":nftprice", $nftprice, PDO::PARAM_STR);
                                            $update1->bindParam(":nftdesc", $nftdesc, PDO::PARAM_STR);
                                            $update1->bindParam(":nftstandard", $nftstandard, PDO::PARAM_STR);
                                            $update1->bindParam(":nftblockchain", $nftblockchain, PDO::PARAM_STR);
                                            $update1->bindParam(":nftroi", $newroi, PDO::PARAM_STR);
                                            $update1->bindParam(":nfttype", $nfttype, PDO::PARAM_STR);
                                            $update1->bindParam(":nftimage", $fileName, PDO::PARAM_STR);
                                            $update1->bindParam(":nftfile", $file, PDO::PARAM_STR);
                                            $update1->bindParam(":nftid", $nftid, PDO::PARAM_STR);
                                            $update1->bindParam(":nftstatus", $status, PDO::PARAM_STR);
                                            if ($update1->execute()) {
                                                echo "success";
                                            } else {
                                                echo "There was an error editing this NFT";
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    } elseif ($nfttype == "video") {
                        if ($_FILES["photo"]["name"] == null) {
                            $update1 = $db_conn->prepare("UPDATE nfts SET nftname = :nftname, nftaddr = :nftaddr, nftprice = :nftprice, nftdesc = :nftdesc, nftstandard = :nftstandard, nftblockchain = :nftblockchain, nftroi = :nftroi, nfttype = :nfttype WHERE nftid = :nftid AND nftstatus = :nftstatus");
                            $update1->bindParam(":nftname", $nftname, PDO::PARAM_STR);
                            $update1->bindParam(":nftaddr", $nftaddr, PDO::PARAM_STR);
                            $update1->bindParam(":nftprice", $nftprice, PDO::PARAM_STR);
                            $update1->bindParam(":nftdesc", $nftdesc, PDO::PARAM_STR);
                            $update1->bindParam(":nftstandard", $nftstandard, PDO::PARAM_STR);
                            $update1->bindParam(":nftblockchain", $nftblockchain, PDO::PARAM_STR);
                            $update1->bindParam(":nftroi", $newroi, PDO::PARAM_STR);
                            $update1->bindParam(":nfttype", $nfttype, PDO::PARAM_STR);
                            $update1->bindParam(":nftid", $nftid, PDO::PARAM_STR);
                            $update1->bindParam(":nftstatus", $status, PDO::PARAM_STR);
                            if ($update1->execute()) {
                                echo "success";
                            } else {
                                echo "There was an error editing this NFT";
                            }
                        } elseif ($_FILES["file"]["name"] == null and $_FILES["photo"]["name"] != null) {
                            $fileName = $_FILES["photo"]["name"];
                            $fileTmpLoc = $_FILES["photo"]["tmp_name"];
                            $fileType = $_FILES["photo"]["type"];
                            $fileSize = $_FILES["photo"]["size"];
                            $fileErrorMsg = $_FILES["photo"]["error"];
                            $fileName = preg_replace('#[^a-z.0-9]#i', '', $fileName);
                            $kaboom = explode(".", $fileName);
                            $fileExt = end($kaboom);
                            $newname = strtolower(str_replace(" ", "_", $nftname));
                            $fileName = $newname . "nft." . $fileExt;
                            if ($fileSize > 8422145) {
                                echo "Your image must be less than 8MB of size.";
                                unlink($fileTmpLoc);
                                exit();
                            }
                            if (!preg_match("/.(jpeg|jpg|png|webp)$/i", $fileName)) {
                                echo "Your image was not jpeg, jpg, webp or png file.";
                                unlink($fileTmpLoc);
                                exit();
                            }
                            if ($fileErrorMsg == 1) {
                                echo "An error occured while processing the image. Try again.";
                                exit();
                            } elseif (!is_numeric($nftprice)) {
                                echo "Enter only numeric values for NFT Price";
                                exit();
                            } else {
                                $file = strtolower($nftid . "file." . $fileExt);
                                if (is_file("../assets/nft/images/$photo")) {
                                    $del = unlink("../assets/nft/images/$photo");
                                    if ($del) {
                                        $moveResult = move_uploaded_file($fileTmpLoc, "../assets/nft/images/$fileName");
                                        if ($moveResult != true) {
                                            echo "ERROR: File not uploaded. Try again.";
                                            exit();
                                        } else {
                                            $update1 = $db_conn->prepare("UPDATE nfts SET nftname = :nftname, nftaddr = :nftaddr, nftprice = :nftprice, nftdesc = :nftdesc, nftstandard = :nftstandard, nftblockchain = :nftblockchain, nftroi = :nftroi, nfttype = :nfttype, nftimage = :nftimage, nftfile = :nftfile WHERE nftid = :nftid AND nftstatus = :nftstatus");
                                            $update1->bindParam(":nftname", $nftname, PDO::PARAM_STR);
                                            $update1->bindParam(":nftaddr", $nftaddr, PDO::PARAM_STR);
                                            $update1->bindParam(":nftprice", $nftprice, PDO::PARAM_STR);
                                            $update1->bindParam(":nftdesc", $nftdesc, PDO::PARAM_STR);
                                            $update1->bindParam(":nftstandard", $nftstandard, PDO::PARAM_STR);
                                            $update1->bindParam(":nftblockchain", $nftblockchain, PDO::PARAM_STR);
                                            $update1->bindParam(":nftroi", $newroi, PDO::PARAM_STR);
                                            $update1->bindParam(":nfttype", $nfttype, PDO::PARAM_STR);
                                            $update1->bindParam(":nftimage", $fileName, PDO::PARAM_STR);
                                            $update1->bindParam(":nftfile", $file, PDO::PARAM_STR);
                                            $update1->bindParam(":nftid", $nftid, PDO::PARAM_STR);
                                            $update1->bindParam(":nftstatus", $status, PDO::PARAM_STR);
                                            if ($update1->execute()) {
                                                echo "success";
                                            } else {
                                                echo "There was an error editing this NFT";
                                            }
                                        }
                                    }
                                }
                            }
                        } else {
                            $fileName = $_FILES["photo"]["name"];
                            $fileTmpLoc = $_FILES["photo"]["tmp_name"];
                            $fileType = $_FILES["photo"]["type"];
                            $fileSize = $_FILES["photo"]["size"];
                            $fileErrorMsg = $_FILES["photo"]["error"];
                            $fileName = preg_replace('#[^a-z.0-9]#i', '', $fileName);
                            $kaboom = explode(".", $fileName);
                            $fileExt = end($kaboom);
                            $newname = strtolower(str_replace(" ", "_", $nftname));
                            $fileName = $newname . "nft." . $fileExt;
                            if ($fileSize > 8422145) {
                                echo "Your image must be less than 8MB of size.";
                                unlink($fileTmpLoc);
                                exit();
                            }
                            if (!preg_match("/.(jpeg|jpg|png|webp)$/i", $fileName)) {
                                echo "Your image was not jpeg, jpg, webp or png file.";
                                unlink($fileTmpLoc);
                                exit();
                            }
                            if ($fileErrorMsg == 1) {
                                echo "An error occured while processing the image. Try again.";
                                exit();
                            } elseif (!is_numeric($nftprice)) {
                                echo "Enter only numeric values for NFT Price";
                                exit();
                            } else {
                                $fileName2 = $_FILES["file"]["name"];
                                $fileTmpLoc2 = $_FILES["file"]["tmp_name"];
                                $fileType2 = $_FILES["file"]["type"];
                                $fileSize2 = $_FILES["file"]["size"];
                                $fileErrorMsg2 = $_FILES["file"]["error"];
                                $fileName2 = preg_replace('#[^a-z.0-9]#i', '', $fileName2);
                                $kaboom2 = explode(".", $fileName2);
                                $fileExt2 = end($kaboom2);
                                $fileName2 = strtolower($nftid . "file." . $fileExt2);

                                if (!preg_match("/.(gif|mp4|mkv)$/i", $fileName2)) {
                                    echo "Your file was not gif, mp4 or mkv file.";
                                    unlink($fileTmpLoc);
                                    exit();
                                } else {
                                    if (is_file("../assets/nft/images/$photo")) {
                                        unlink("../assets/nft/images/$photo");
                                    }
                                    if (is_file("../assets/nft/videos/$files")) {
                                        unlink("../assets/nft/videos/$files");
                                    }
                                    $moveResult = move_uploaded_file($fileTmpLoc, "../assets/nft/images/$fileName");
                                    if ($moveResult != true) {
                                        echo "ERROR: File not uploaded. Try again.";
                                        exit();
                                    } else {
                                        $moveResult2 = move_uploaded_file($fileTmpLoc2, "../assets/nft/videos/$fileName2");
                                        if ($moveResult2 != true) {
                                            echo "ERROR: your video was not uploaded. Try again.";
                                        } else {
                                            $update1 = $db_conn->prepare("UPDATE nfts SET nftname = :nftname, nftaddr = :nftaddr, nftprice = :nftprice, nftdesc = :nftdesc, nftstandard = :nftstandard, nftblockchain = :nftblockchain, nftroi = :nftroi, nfttype = :nfttype, nftimage = :nftimage, nftfile = :nftfile WHERE nftid = :nftid AND nftstatus = :nftstatus");
                                            $update1->bindParam(":nftname", $nftname, PDO::PARAM_STR);
                                            $update1->bindParam(":nftaddr", $nftaddr, PDO::PARAM_STR);
                                            $update1->bindParam(":nftprice", $nftprice, PDO::PARAM_STR);
                                            $update1->bindParam(":nftdesc", $nftdesc, PDO::PARAM_STR);
                                            $update1->bindParam(":nftstandard", $nftstandard, PDO::PARAM_STR);
                                            $update1->bindParam(":nftblockchain", $nftblockchain, PDO::PARAM_STR);
                                            $update1->bindParam(":nftroi", $newroi, PDO::PARAM_STR);
                                            $update1->bindParam(":nfttype", $nfttype, PDO::PARAM_STR);
                                            $update1->bindParam(":nftimage", $fileName, PDO::PARAM_STR);
                                            $update1->bindParam(":nftfile", $fileName2, PDO::PARAM_STR);
                                            $update1->bindParam(":nftid", $nftid, PDO::PARAM_STR);
                                            $update1->bindParam(":nftstatus", $status, PDO::PARAM_STR);
                                            if ($update1->execute()) {
                                                echo "success";
                                            } else {
                                                unlink("../asset/nft/images/$fileName");
                                                unlink("../asset/nft/videos/$fileName2");
                                                echo "The NFT was not uploaded";
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
            break;
        case 'approveNfts':
            $transc_id = filter_var(htmlentities($_POST['transc_id']), FILTER_UNSAFE_RAW);
            $mem_id = filter_var(htmlentities($_POST['mem_id']), FILTER_UNSAFE_RAW);
            $status = filter_var(htmlentities($_POST['status']), FILTER_UNSAFE_RAW);
            if ($transc_id == null || $mem_id == null) {
                echo "All fields are required";
            } else {
                $update1 = $db_conn->prepare("UPDATE nfthistory SET status = :status WHERE transc_id = :transc_id AND mem_id = :mem_id");
                $update1->bindParam(":status", $status, PDO::PARAM_STR);
                $update1->bindParam(":transc_id", $transc_id, PDO::PARAM_STR);
                $update1->bindParam(":mem_id", $mem_id, PDO::PARAM_STR);
                if ($update1->execute()) {
                    echo "success";
                } else {
                    "There was an error updating status";
                }
            }
            break;
        case 'addBonus':
            $mem_id = filter_var(htmlentities($_POST['mem_id']), FILTER_UNSAFE_RAW);
            $status = 0;
            $asset = filter_var(htmlentities($_POST['asset']), FILTER_UNSAFE_RAW);
            $amount = filter_var(htmlentities($_POST['amountb']), FILTER_UNSAFE_RAW);
            $date_added = filter_var(htmlentities(date('d M, Y')), FILTER_UNSAFE_RAW);

            if ($amount  == null || $asset == null) {
                echo "All fields are required";
            } else if (!is_numeric($amount) || $amount < 1) {
                echo "Enter a valid amount";
            } else {
                $checkBon = $db_conn->prepare("SELECT * FROM dtdbonus WHERE mem_id = :mem_id AND status = :status");
                $checkBon->bindParam(':mem_id', $mem_id, PDO::PARAM_STR);
                $checkBon->bindParam(':status', $status, PDO::PARAM_STR);
                $checkBon->execute();
                if ($checkBon->rowCount() > 0) {
                    echo "User already has an unclaimed bonus";
                } else {
                    $sqlIns = $db_conn->prepare("INSERT INTO dtdbonus (asset, amount, date_added, mem_id) VALUES (:asset, :amount, :date_added, :mem_id)");
                    $sqlIns->bindParam(":asset", $asset, PDO::PARAM_STR);
                    $sqlIns->bindParam(":amount", $amount, PDO::PARAM_STR);
                    $sqlIns->bindParam(":date_added", $date_added, PDO::PARAM_STR);
                    $sqlIns->bindParam(":mem_id", $mem_id, PDO::PARAM_STR);
                    if ($sqlIns->execute()) {
                        $subject = "Bonus received";
                        $message = "You have just received a bonus on your account, click <a href='claimbonus'>here</a> to open and claim";
                        $sql = $db_conn->prepare("INSERT INTO notifications (mem_id, title, datetime, message) VALUES (:mem_id, :title, :datetime, :message)");
                        $sql->bindParam(':mem_id', $mem_id, PDO::PARAM_STR);
                        $sql->bindParam(':datetime', $date_added, PDO::PARAM_STR);
                        $sql->bindParam(':title', $subject, PDO::PARAM_STR);
                        $sql->bindParam(':message', $message, PDO::PARAM_STR);
                        if ($sql->execute()) {
                            echo "success";
                        } else {
                            echo "Notification message was not sent to user";
                        }
                    }
                }
            }
            break;
        case 'addtrades':
            $tradeid = str_pad(mt_rand(1, 9999999), 6, '0', STR_PAD_LEFT);
            $asset = filter_var(htmlentities($_POST['items']), FILTER_UNSAFE_RAW);
            $price = filter_var(htmlentities($_POST['entry']), FILTER_UNSAFE_RAW);
            $market = filter_var(htmlentities($_POST['market']), FILTER_UNSAFE_RAW);
            $amount = filter_var(htmlentities($_POST['amount']), FILTER_UNSAFE_RAW);
            $duration = filter_var(htmlentities($_POST['duration']), FILTER_UNSAFE_RAW);
            $leverage = filter_var(htmlentities($_POST['leverage']), FILTER_UNSAFE_RAW);
            $account = filter_var(htmlentities($_POST['account']), FILTER_UNSAFE_RAW);
            $symbol = filter_var(htmlentities($_POST['symbol']), FILTER_UNSAFE_RAW);
            $small_name = filter_var(htmlentities($_POST['small']), FILTER_UNSAFE_RAW);
            $tradetime = filter_var(htmlentities(date('h:ia')), FILTER_UNSAFE_RAW);
            $closetime = date('h:ia', strtotime("+$duration minutes"));
            $tradedate = filter_var(htmlentities(date('d M, Y')), FILTER_UNSAFE_RAW);
            $tradetype = filter_var(htmlentities($_POST['tradetype']), FILTER_UNSAFE_RAW);
            $tradestatus = filter_var(htmlentities(1), FILTER_UNSAFE_RAW);
            $mem_id = filter_var(htmlentities($_POST['mem_id']), FILTER_UNSAFE_RAW);
            $accts = filter_var(htmlentities('live'), FILTER_UNSAFE_RAW);

            $amount = str_replace(",", "", $amount);
            $price = str_replace(",", "", $price);

            if ($asset == null) {
                echo "Please select an asset to trade";
            } elseif ($amount == null || !is_numeric($amount)) {
                echo "Check the amount and try again";
            } elseif ($price == null || $price < 0) {
                echo "An error has occured please try again";
            } elseif ($leverage == null || $leverage < 2) {
                echo  "The minimun leverage is 2";
            } else {
                $chekearning = $db_conn->prepare("SELECT * FROM balances WHERE mem_id = :mem_id");
                $chekearning->bindParam(':mem_id', $mem_id, PDO::PARAM_STR);
                $chekearning->execute();

                $getEarns = $chekearning->fetch(PDO::FETCH_ASSOC);

                $tradebal = $getEarns["$account"];

                if ($tradebal < $amount) {
                    echo "This user avalable balance is less than trading amount entered";
                    exit();
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
                    $sql->bindParam(":account", $account, PDO::PARAM_STR);
                    if ($sql->execute()) {
                        $transType = "Trade ($tradetype)";

                        $insert = $db_conn->prepare("INSERT INTO transactions (transc_id, transc_type, amount, date_added, mem_id, account) VALUES (:transc_id, :transc_type, :amount, :date_added, :mem_id, :account)");
                        $insert->bindParam(":transc_id", $tradeid, PDO::PARAM_STR);
                        $insert->bindParam(":transc_type", $transType, PDO::PARAM_STR);
                        $insert->bindParam(":amount", $amount, PDO::PARAM_STR);
                        $insert->bindParam(":date_added", $tradedate, PDO::PARAM_STR);
                        $insert->bindParam(":mem_id", $mem_id, PDO::PARAM_STR);
                        $insert->bindParam(":account", $accts, PDO::PARAM_STR);
                        if ($insert->execute()) {
                            echo "success";
                            $updbalance = $db_conn->prepare("UPDATE balances SET $account = $account - :available WHERE mem_id = :mem_id");
                            $updbalance->bindParam(':available', $amount, PDO::PARAM_STR);
                            $updbalance->bindParam(':mem_id', $mem_id, PDO::PARAM_STR);
                            $updbalance->execute();
                        } else {
                            $del = $db_conn->prepare("DELETE FROM trades WHERE tradeid = :tradeid AND mem_id = :mem_id");
                            $del->bindParam(':tradeid', $tradeid, PDO::PARAM_STR);
                            $del->bindParam(':mem_id', $mem_id, PDO::PARAM_STR);
                            $del->execute();
                            echo "$tradetype order has failed, please try again.";
                        }
                    } else {
                        echo "There was an error adding this trade";
                    }
                }
            }
            break;
        case 'addGasFee':
            $nftid = filter_var(htmlentities($_POST['nftid']), FILTER_UNSAFE_RAW);
            $status = filter_var(htmlentities($_POST['status']), FILTER_UNSAFE_RAW);
            $amount = filter_var(htmlentities($_POST['amount']), FILTER_UNSAFE_RAW);
            $buyer = filter_var(htmlentities($_POST['buyer']), FILTER_UNSAFE_RAW);
            $payment = filter_var(htmlentities($_POST['payment']), FILTER_UNSAFE_RAW);
            if ($nftid == null || $amount == null) {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'All fields are required'
                ]);
            } else {
                $update1 = $db_conn->prepare("UPDATE mynft SET gasfee = :amount, buyer = :buyer, payment = :payment, status = :status WHERE nftid = :nftid");
                $update1->bindParam(":amount", $amount, PDO::PARAM_STR);
                $update1->bindParam(":buyer", $buyer, PDO::PARAM_STR);
                $update1->bindParam(":payment", $payment, PDO::PARAM_STR);
                $update1->bindParam(":status", $status, PDO::PARAM_STR);
                $update1->bindParam(":nftid", $nftid, PDO::PARAM_STR);
                if ($update1->execute()) {
                    echo json_encode([
                        'status' => 'success',
                        'message' => 'Update was successful',
                    ]);
                } else {
                    echo json_encode([
                        'status' => 'error',
                        'message' => 'An error occurred while updating'
                    ]);
                }
            }
            break;
        default:
            echo "Invalid request sent";
            break;
    }
}
