<?php
$password = "1234";
echo "password: ".$password."<br>";
echo "hashed password: ".password_hash($password, PASSWORD_DEFAULT);
?>