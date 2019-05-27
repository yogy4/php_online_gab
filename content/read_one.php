<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF8");
header("Access-Control-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");

include_once '../config/database.php';
include_once '../objects/content.php';

$database = new Database();
$db = $database->getConnection();
$content = new Content($db);
$content->id = isset($_GET['id']) ? $_GET['id'] : die();

if($content->author != null){
    $content_arr = array (
        "id" => $content->id,
        "author" => $content->author,
        "isi" => $content->isi
    );
    http_response_code(200);
    echo json_encode($content_arr);
}else{
    http_response_code(404);
    echo json_encode(array("message" => "content not found"));

}
