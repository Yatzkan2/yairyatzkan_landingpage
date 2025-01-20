<?php 

include_once("./config.php");
include_once("./db_ops.php");

//ALLOW ACCESS FROM CLIENT
header("Access-Control-Allow-Origin: *"); 
header("Access-Control-Allow-Methods: POST, GET, OPTIONS"); 
header("Access-Control-Allow-Headers: Content-Type"); 

//GENERATING COUNTRY BY IP OF THE LEAD
function get_country_by_ip($ip) {
    $location_json = file_get_contents("http://ip-api.com/json/$ip");
    $location = json_decode($location_json);
    if($location->status == "fail") {
        return "Israel";
    }
    return $location->country;
}

//RESPONSE TO THE CLIENT
$response = ['status' => 'error', 'message' => ''];

if($_SERVER["REQUEST_METHOD"] == "POST") {
    //CREATING LEAD PARAMETERS
    $first_name = $_POST["first-name"];
    $last_name = $_POST["last-name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $note = $_POST["note"];

    $ip = $_SERVER['REMOTE_ADDR'];
    $country = get_country_by_ip($ip);
    $url = $_SERVER['REQUEST_URI'];
    $sub_1 = $_POST['sub-1'];

    //ADDING LEAD TO DB
    $result = add_lead($first_name, $last_name, $email, $phone, $ip, $country, $url, $note, $sub_1);
    $response['status'] = 'success';
    $response['message'] = ($result) ? "Thank you $first_name, we'll contact you soon" : "Sorry, this email is already registered";
   
}

//SETTING THE HEADER AND RETURNING THE RESPONSE TO THE CLIENT
header("Content-type: application/json");
echo json_encode($response);

?>
