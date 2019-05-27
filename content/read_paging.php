<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF8");

include_once '../config/database.php';
include_once '../objects/content.php';

include_once '../shared/utilities.php';

$utilities = new Utilities();
$database = new Database();
$db = $database->getConnection();
$content = new Content($db);

$statement = $content->readPaging($from_record_num, $records_per_page);
$num = $statement->rowCount();

if ($num > 0){
    $content_arr = array();
    $content_arr["records"] = array();
    $content_arr["paging"] = array();
    while ($row = $statement->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        $content_item = array(
            "id" => $id,
            "author" => $author,
            "isi" => html_entity_decode($isi)
        );
        array_push($content_arr["records"], $content_item);
    }
    $total_rows = $content->count();
    $page_url = "{$home_url}content/read_paging.php?";
    // untuk penamaan parameter/variable harus sesuai pada fungsi yang telah didefinisikan sebelumnya
    $paging = $utilities->getPaging($page, $total_rows, $records_per_page, $page_url);
    $content_item["paging"] = $paging;
    http_response_code(200);
    echo json_encode($content_arr);
} else {
    http_response_code(404);
    echo json_encode(array("message" => "no content found"));
}


