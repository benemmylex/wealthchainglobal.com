<?php
ob_start();
include("../../ops/connect.php");
session_destroy();
session_unset();
header("Location: ../../adminsignin");
exit();
