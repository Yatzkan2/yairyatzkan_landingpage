<?php
//DESTROY SESSION WHILE LOGOUT
session_start();
$_SESSION = [];
session_destroy();
header("Location: ./login.php");

?>