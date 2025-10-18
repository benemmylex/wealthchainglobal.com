<?php
$servername = "localhost";
$username = "qfsecure_wealthchainglobal_com";
$password = "wealthchainglobal.com";
$dbname = "qfsecure_wealthchainglobal.com";

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

$file = dirname(__FILE__);
include(dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '/PHPMailer/PHPMailerAutoload.php');

define("SITE_URL", "wealthchainsglobal.com");

define("SITE_ADDRESS", "wealthchainsglobal.com");

define("SITE_NAME", "Wealth Chain Global");

// define("SITE_PHONE", "+1");

define("SITE", "Wealth Chain Global");

define("SITE_EMAIL", "support@" . SITE_ADDRESS);
define("SITE_ADMIN_EMAIL", "admin@" . SITE_ADDRESS);

// define("LIVE_CHAT", '<script src="//code.tidio.co/" async></script>');
define("LIVE_CHAT", '');

define("ADDRESS", "Beethovenstraat 505 - 1083 HK - Amsterdam - Noord-Holland"); //IF ANY


try {
    $db_conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8mb4", $username, $password);
    $db_conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
// ========================= config the languages ================================
session_start();
ob_start();
date_default_timezone_set("America/New_York");
error_reporting(E_NOTICE ^ E_ALL);

$dd = $db_conn->prepare("SELECT phone FROM admin");
$dd->execute();

$rr = $dd->fetch(PDO::FETCH_ASSOC);

define("SITE_PHONE", $rr['phone']);

//====================================================================================================================================================

$mail = new PHPMailer;
$mail->isSMTP();
/*
     * Mail Server Configuration
     */
$mail->Host = 'mail.wealthchainsglobal.com'; // Which SMTP server to use.
$mail->Port = 587; // Which port to use, 587 is the default port for TLS security.
$mail->SMTPSecure = 'tsl'; // Which security method to use. TLS is most secure.
$mail->SMTPAuth = true; // Whether you need to login. This is almost always required.
$mail->Username = "support@wealthchainsglobal.com"; //. SITE_ADDRESS; // Your Gmail address.
$mail->Password = "Omo4real@"; // Your Gmail login password or App Specific Password.
$mail->setFrom("support@wealthchainsglobal.com"); //. SITE_ADDRESS);
$mail->CharSet = "UTF-8";
$mail->Encoding = "base64";
$message = '';


//=========================================== Second Mailler =========================================================================//

$mail2 = new PHPMailer;
$mail2->isSMTP();
/*
     * Mail2 Server Configuration
     */
$mail2->Host = 'mail.wealthchainsglobal.com'; // Which SMTP server to use.
$mail2->Port = 587; // Which port to use, 587 is the default port for TLS security.
$mail2->SMTPSecure = 'tls'; // Which security method to use. TLS is most secure.
$mail2->SMTPAuth = true; // Whether you need to login. This is almost always required.
$mail2->Username = "support@wealthchainsglobal.com"; // . SITE_ADDRESS; // Your Gmail address.
$mail2->Password = "Omo4real@"; // Your Gmail login password or App Specific Password.
$mail2->setFrom('support@wealthchainsglobal.com');
$mail2->CharSet = "UTF-8";
$mail2->Encoding = "base64";
$message2 = '';

function contains($str, array $arr)
{
    foreach ($arr as $a) {
        if (stripos($str, $a) !== false) return true;
    }
    return false;
}

$permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

function generate_string($input, $strength)
{
    $input_length = strlen($input);
    $random_string = '';
    for ($i = 0; $i < $strength; $i++) {
        $random_character = $input[mt_rand(0, $input_length - 1)];
        $random_string .= $random_character;
    }

    return $random_string;
}

function date_time($t = "")
{
    if ($t == "") {
        return date("Y-m-d H:i:s");
    } elseif ($t == "t" || $t == "T") {
        return date("H:i:s");
    } elseif ($t == "d" || $t == "D") {
        return date("Y-m-d");
    }
}
