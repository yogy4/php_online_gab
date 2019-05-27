<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type application/json; charset = UTF8");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../objects/content.php';

$database = new Database();
$db = $database->getConnection();
$content = new Content($db);

$data = json_decode(file_get_contents("php://input"));

$content->id = $data->id;

if($content->delete()){
    http_response_code(200);
    echo json_encode(array("message" => "content was deletes"));
}else {
    http_response_code(503);
    echo json_encode(array("message" => "unable to delete content"));
}