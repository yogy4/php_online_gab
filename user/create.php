<?php 
header("Access-Control-Allow-Origin: http://localhost/url");
header("Content-Type: application/json; charset = UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Contol-Max-Age: 3600");
header("Access-Control-Allow-Haaders: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../objects/user.php';

$database = new Database();
$db = $database->getConnection();
$user = new User($db);
$data = json_decode(file_get_contents("php://input"));
// untuk $user adalah sesuai dengan variable yang diset di class User sedang $data sesuai dengan yang diinputkan(kata setalah tanda :)
$user->firtname = $data->firstname;
$user->lastname = $data->lastname;
$user->email = $data->email;
$user->password = $data->password;

if ($user->create()){
    http_response_code(200);
    echo json_encode(array("message" => "User was insert"));
}else {
    http_response_code(400);
    echo json_encode(array("message" => "Unable to create"));
}