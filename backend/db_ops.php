<?php
include_once(__DIR__."/config.php");

/* LEADS TABLE */
//ADD NEW LEAD
function add_lead($first_name, $last_name, $email, $phone_number, $ip, $country, $url, $note, $sub_1) {
    $conn = mysqli_connect(DB_SERVERNAME, DB_USERNAME, DB_PASSWORD, DB_NAME);

    if ($conn->errno) {
        return $conn->error;
    } 
    
    $stmnt = $conn->prepare("SELECT COUNT(*) FROM leads WHERE email = ?;");
    $stmnt->bind_param("s", $email);
    $stmnt->execute();
    $result = $stmnt->get_result();

    $row = mysqli_fetch_assoc($result);

    if ($row['COUNT(*)'] > 0) {
        return false;
    }

    $stmnt->close();

    $stmnt = $conn->prepare("INSERT INTO leads (first_name, last_name, email, phone_number, ip, country, url, note, sub_1, called, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, FALSE, NOW());");
    $stmnt->bind_param("sssssssss", $first_name, $last_name, $email, $phone_number, $ip, $country, $url, $note, $sub_1);
    $success = $stmnt->execute();

    $stmnt->close();
    $conn->close();

    return $success;
}

//GETTING LEAD BY ID
function show_lead_by_id($id) {
    $conn = mysqli_connect(DB_SERVERNAME, DB_USERNAME, DB_PASSWORD, DB_NAME);

    if($conn->errno) {
        return $conn->error;
    }

    $stmnt = $conn->prepare("SELECT * FROM leads WHERE id = ?;");
    $stmnt->bind_param("i", $id);
    $stmnt->execute();
    $result = $stmnt->get_result();

    $stmnt->close();
    $conn->close();

    return $result;
} 

//SET A SINGLE LEAD AS "CALLED"
function set_called_by_id($id) {
    $conn = mysqli_connect(DB_SERVERNAME, DB_USERNAME, DB_PASSWORD, DB_NAME);

    if($conn->errno) {
        return $conn->error;
    }

    $stmnt = $conn->prepare("UPDATE leads SET called = TRUE WHERE id = ?;");
    $stmnt->bind_param("i", $id);
    $success = $stmnt->execute();
    $affected_rows = $stmnt->affected_rows;
    $stmnt->close();
    $conn->close();
    return $affected_rows;
}

//FILTER LEADS BY "CALLED" FIELD
function filter_called_leads() {
    $conn = mysqli_connect(DB_SERVERNAME, DB_USERNAME, DB_PASSWORD, DB_NAME);

    if ($conn->errno) {
        return $conn->error;
    }

    $query = "SELECT * FROM leads WHERE called = TRUE;";
    $result = $conn->query($query);

    $conn->close();

    return $result;
}

//FILTER ALL LEADS THAT WERE CREATED TODAY
function filter_created_today() {
    $conn = mysqli_connect(DB_SERVERNAME, DB_USERNAME, DB_PASSWORD, DB_NAME);

    if ($conn->errno) {
        return $conn->error;
    }

    $query = "SELECT * FROM leads WHERE DATE(created_at) = CURDATE();";
    $result = $conn->query($query);

    $conn->close();

    return $result;
}

//FILTER LEADS BY COUNTRY
function filter_by_country($country) {
    $conn = mysqli_connect(DB_SERVERNAME, DB_USERNAME, DB_PASSWORD, DB_NAME);

    if ($conn->errno) {
        return $conn->error;
    }

    $stmnt = $conn->prepare("SELECT * FROM leads WHERE country = ?;");
    $stmnt->bind_param("s", $country);
    $stmnt->execute();
    $result = $stmnt->get_result();

    $stmnt->close();
    $conn->close();

    return $result;
}

//RETURNS ALL LEADS
function show_all_leads() {

    $conn = mysqli_connect(DB_SERVERNAME, DB_USERNAME, DB_PASSWORD, DB_NAME);

    if($conn->errno) {
        return $conn->error;
    }

    $query = "SELECT * FROM leads;";

    $result = $conn->query($query);

    $conn->close();

    return $result;
}

/* ADMINS TABLE */
//GETTING A PASSWORD ACCORDING TO USENAME. FOR LOGIN.
function get_password($username) {
    $conn = mysqli_connect(DB_SERVERNAME, DB_USERNAME, DB_PASSWORD, DB_NAME);

    if ($conn->errno) {
        return $conn->error;
    }

    $stmnt = $conn->prepare("SELECT password FROM admins WHERE username = ?");
    $stmnt->bind_param("s", $username);
    $stmnt->execute();
    $result = $stmnt->get_result();

    $stmnt->close();
    $conn->close();

    return $result;
}

?>