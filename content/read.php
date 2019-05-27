<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF8");

include_once '../config/database.php';
include_once '../objects/content.php';

$database = new Database();
$db = $database->getConnection();
$content = new Content($db);
$statement = $content->readAll();
$num = $statement->rowCount();

if($num > 0){
    $content_arr = array();
    $content_arr["records"] = array();
    while($row = $statement->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        $content_item = array (
            "id" => $id,
            "author" => $author,
            "isi" => html_entity_decode($isi)
        );
        array_push($content_arr["records"], $content_item);
        http_response_code(200);
        echo json_encode($content_arr);
    }
} else {
    http_response_code(404);
    echo json_encode(array("message" => "content not found"));
}