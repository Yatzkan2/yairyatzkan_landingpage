<?php
include_once('../config.php');

function get_random_country() {
    $countries = ["USA", "UK", "Israel"];
    return $countries[array_rand($countries)];
}
function get_random_ip() {
    return rand(0, 255) . '.' . rand(0, 255) . '.' . rand(0, 255) . '.' . rand(0, 255);
}

function clean_leads_table() {
    $conn = mysqli_connect(DB_SERVERNAME, DB_USERNAME, DB_PASSWORD, DB_NAME);

    if ($conn->errno) {
        die("Connection failed: " . $conn->error);
    }

    $query = "TRUNCATE TABLE leads";
    $success = $conn->query($query);

    if (!$success) {
        die("Error cleaning table: " . $conn->error);
    }

    $conn->close();

    return true;
}


function fetch_data($url) {  
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);
    return json_decode($response);
}

function extract_data($users_arr) {
    $leads = [];
    foreach($users_arr as $index => $user) {
        if($index > 10) {
            break;
        }
        $full_name = explode(" ", $user->name);
        $leads[$index]["first_name"] = $full_name[0];
        $leads[$index]["last_name"] = $full_name[1];
        $leads[$index]["email"] = $user->email;
        $leads[$index]["phone"] = $user->phone;
        $leads[$index]["note"] = $user->company->catchPhrase;
        $leads[$index]["country"] = get_random_country();
        $leads[$index]["ip"] = get_random_ip();
        $leads[$index]["url"] = "arbitrary.com";
        $leads[$index]["sub_1"] = "still dont know";
    }
    return $leads;
}

function insert_many_leads($leads_arr) {
    $conn = mysqli_connect(DB_SERVERNAME, DB_USERNAME, DB_PASSWORD, DB_NAME);

    if ($conn->errno) {
        die("Connection failed: " . $conn->error);
    }

    $stmnt = $conn->prepare("INSERT INTO leads (first_name, last_name, email, phone_number, ip, country, url, note, sub_1, called, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, FALSE, NOW())");

    foreach ($leads_arr as $lead) {
        $first_name = $lead['first_name'];
        $last_name = $lead['last_name'];
        $email = $lead['email'];
        $phone = substr($lead['phone'], 0, 10);
        $ip = $lead['ip'];
        $country = $lead['country'];
        $url = $lead['url'];
        $note = $lead['note'];
        $sub_1 = $lead['sub_1'];
        $stmnt->bind_param("sssssssss", $first_name, $last_name, $email, $phone, $ip, $country, $url, $note, $sub_1);
        $stmnt->execute();
    }

    $stmnt->close();
    $conn->close();

    return true;
}

$url = "https://jsonplaceholder.typicode.com/users";

clean_leads_table();
$users_arr = fetch_data($url);
$leads = extract_data($users_arr);
insert_many_leads($leads);


?>