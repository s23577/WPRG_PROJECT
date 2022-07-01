<?php
setcookie("login", "", time() - 3600);
session_start();
unset($_SESSION["login"]);
$_SESSION = array();
session_destroy();
header('Location: index.php');
exit;