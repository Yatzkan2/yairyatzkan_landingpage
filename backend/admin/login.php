<?php
include_once("../config.php");  
include_once("../db_ops.php");  
session_start();

//REDIRECTING TO CONTROL (index.php) PAGE IF ADMIN IS LOGGED IN 
if(isset($_SESSION['logged_in']) && $_SESSION['logged_in']) {
    header("Location: ./index.php");
    exit();
}

//LOGGING IN
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $result = get_password($username);
    $row = mysqli_fetch_assoc($result);
    $hashed_password = $row['password'];
    if(password_verify($password, $hashed_password)) {
        $_SESSION['logged_in'] = true;
        header("Location: ./index.php");
        exit();
    } else {
        $error = "invalid credentials";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Document</title>
</head>
<body>

    <h1>Login to admin control</h1>
    <form action="" method="post">
        <input type="text" name="username" placeholder="username">
        <input type="password" name="password" placeholder="password">
        <button>Login</button>
    </form>
    <br>
    <?php if(isset($error)) {echo $error;} ?>
</body>
</html>