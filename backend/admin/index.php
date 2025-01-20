<?php
session_start();
include_once("../config.php");
include_once("../db_ops.php");

//REDIRECTING TO LOGIN PAGE IF ADMIN NOT LOGGED IN
if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
    header("Location: ./login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">

    <title>Admin Page</title>
</head>
<body>
    <form action="./logout.php">
        <button>Logout</button>
    </form>
    <form action=""> 
        <input type="hidden" name="clear_page" value="true">
        <button>Clear Page</button>
    </form>
    <h1>Admin Page</h1>
    <!-- ADMIN ADD NEW LEAD -->
    
    <h3>Add New Lead:</h3>
    <form action="" method="post">
        <input type="hidden" name="add_lead" value="true">
        <input type="text" name="first-name" placeholder="First Name" required>
        <input type="text" name="last-name" placeholder="Last Name" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="text" name="phone" placeholder="Phone Number" required>
        <select name="country">
            <option value="">Select a country</option>
            <option value="USA">USA</option>
            <option value="UK">UK</option>
            <option value="Israel">Israel</option>
        </select>
        <input type="text" name="url" placeholder="URL">
        <input type="text" name="ip" placeholder="IP">
        <textarea name="note" placeholder="Note"></textarea>
        <button type="submit">Add Lead</button>
    </form>
    <?php 
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add_lead"]) && $_POST["add_lead"] == "true") {
        $result = add_lead(
            $_POST["first-name"],
            $_POST["last-name"],
            $_POST["email"],
            $_POST["phone"],
            !empty(trim($_POST['ip'])) ? $_POST['ip'] : '172.150.56.3',
            !empty(trim($_POST["country"])) ? $_POST["country"] : 'Israel',
            !empty(trim($_POST["url"])) ? $_POST["url"] : $_SERVER["PHP_SELF"],
            !empty(trim($_POST["note"])) ? $_POST["note"] : 'default note',
            'from admin'
        );            
        echo $result ? "<p style='color:blue'>Lead added successfully." : "This lead is already used.</p><br>";
    }
    ?>

    <!-- ADMIN FILTER LEAD BY ID -->
    <h3>Find Lead by ID:</h3>
    <form action="">
        <input type="text" name="lead_id" placeholder="Lead ID" required>
        <button>Find a Lead by its ID</button>
    </form>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["lead_id"])) {
        $result = show_lead_by_id($_GET["lead_id"]);
        if ($result->num_rows != 0) {
            echo "<table border='1'>";
            echo "<tr><th>ID</th><th>First Name</th><th>Last Name</th><th>Email</th><th>Phone Number</th><th>IP</th><th>Country</th><th>URL</th><th>Note</th><th>Sub 1</th><th>Called</th><th>Created At</th></tr>";
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td>" . $row['first_name'] . "</td>";
                echo "<td>" . $row['last_name'] . "</td>";
                echo "<td>" . $row['email'] . "</td>";
                echo "<td>" . $row['phone_number'] . "</td>";
                echo "<td>" . $row['ip'] . "</td>";
                echo "<td>" . $row['country'] . "</td>";
                echo "<td>" . $row['url'] . "</td>";
                echo "<td>" . $row['note'] . "</td>";
                echo "<td>" . $row['sub_1'] . "</td>";
                echo "<td>" . ($row['called'] ? 'Yes' : 'No') . "</td>";
                echo "<td>" . $row['created_at'] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p style='color:red'>There's no such lead...</p><br>";
        }
    }
    ?>

    <!-- ADAMIN SET LEAD "CALLED" FIELD TO TRUE -->
    <h3>Set Lead as "Called":</h3>
    <form action="" method="post">
        <input type="hidden" name="called" value="true">
        <input type="text" name="lead_id" placeholder="Lead ID" required>
        <button>Update</button>
    </form>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["called"]) && $_POST["called"] == "true") {
        $success = set_called_by_id($_POST["lead_id"]);
        echo $success ? "<p style='color:blue'>Lead updated successfully.</p><br>" : "<p style='color:red'>There's no such lead...</p><br>";
    }
    ?>

    <!-- ADMIN FILTER LEADS THAT CREATED TODAY -->
    <h3>Show All Leads Created Today:</h3>
    <form action="">
        <input type="hidden" name="created_today" value="true">
        <button>Created Today Table</button>
    </form>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["created_today"]) && $_GET["created_today"] == "true") {
        $result = filter_created_today();
        if ($result->num_rows != 0) {
            echo "<table border='1'>";
            echo "<tr><th>ID</th><th>First Name</th><th>Last Name</th><th>Email</th><th>Phone Number</th><th>IP</th><th>Country</th><th>URL</th><th>Note</th><th>Sub 1</th><th>Called</th><th>Created At</th></tr>";
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td>" . $row['first_name'] . "</td>";
                echo "<td>" . $row['last_name'] . "</td>";
                echo "<td>" . $row['email'] . "</td>";
                echo "<td>" . $row['phone_number'] . "</td>";
                echo "<td>" . $row['ip'] . "</td>";
                echo "<td>" . $row['country'] . "</td>";
                echo "<td>" . $row['url'] . "</td>";
                echo "<td>" . $row['note'] . "</td>";
                echo "<td>" . $row['sub_1'] . "</td>";
                echo "<td>" . ($row['called'] ? 'Yes' : 'No') . "</td>";
                echo "<td>" . $row['created_at'] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p style='color:red'>No new leads created today</p><br>";
        }
    }
    ?>

    <!-- ADMIN FILTER CALLED LEADS -->
    <h3>Show All Leads That Were Called:</h3>
    <form action="">
        <input type="hidden" name="called_leads" value="true">
        <button>Called Leads Table</button>
    </form>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["called_leads"]) && $_GET["called_leads"] == "true") {
        $result = filter_called_leads();
        if ($result->num_rows != 0) {
            echo "<table border='1'>";
            echo "<tr><th>ID</th><th>First Name</th><th>Last Name</th><th>Email</th><th>Phone Number</th><th>IP</th><th>Country</th><th>URL</th><th>Note</th><th>Sub 1</th><th>Called</th><th>Created At</th></tr>";
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td>" . $row['first_name'] . "</td>";
                echo "<td>" . $row['last_name'] . "</td>";
                echo "<td>" . $row['email'] . "</td>";
                echo "<td>" . $row['phone_number'] . "</td>";
                echo "<td>" . $row['ip'] . "</td>";
                echo "<td>" . $row['country'] . "</td>";
                echo "<td>" . $row['url'] . "</td>";
                echo "<td>" . $row['note'] . "</td>";
                echo "<td>" . $row['sub_1'] . "</td>";
                echo "<td>" . ($row['called'] ? 'Yes' : 'No') . "</td>";
                echo "<td>" . $row['created_at'] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p style='color:red'>You didn't call any lead yet</p><br>";
        }
    }
    ?>

    <!-- ENTIRE LEADS TABLE -->

    <h3>Show all leads: </h3>
    <form action="">
        <input type="hidden" name="show_all" value="true">
        <button>Leads Table</button>
    </form>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["show_all"]) && $_GET["show_all"] == "true") {
        $result = show_all_leads();
        if ($result->num_rows != 0) {
            echo "<table border='1'>";
            echo "<tr><th>ID</th><th>First Name</th><th>Last Name</th><th>Email</th><th>Phone Number</th><th>IP</th><th>Country</th><th>URL</th><th>Note</th><th>Sub 1</th><th>Called</th><th>Created At</th></tr>";
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td>" . $row['first_name'] . "</td>";
                echo "<td>" . $row['last_name'] . "</td>";
                echo "<td>" . $row['email'] . "</td>";
                echo "<td>" . $row['phone_number'] . "</td>";
                echo "<td>" . $row['ip'] . "</td>";
                echo "<td>" . $row['country'] . "</td>";
                echo "<td>" . $row['url'] . "</td>";
                echo "<td>" . $row['note'] . "</td>";
                echo "<td>" . $row['sub_1'] . "</td>";
                echo "<td>" . ($row['called'] ? 'Yes' : 'No') . "</td>";
                echo "<td>" . $row['created_at'] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p style='color:red'>There's no leads so fat</p><br>";
        }
    }
    ?>
</body>
</html>
