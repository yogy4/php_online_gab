<?php 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset = uTF8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/core.php';
include_once '../shared/php-jwt/src/BeforeValidException.php';
include_once '../shared/php-jwt/src/ExpiredException.php';
include_once '../shared/php-jwt/src/SignatureInvalidException.php';
include_once '../shared/php-jwt/src/JWT.php';
include_once '../config/database.php';
include_once '../objects/content.php';
use Firebase\JWT\JWT;

$database = new Database();
$db = $database->getConnection();

$content = new Content($db);

$data = json_decode(file_get_contents("php://input"));
// kemungkinan $data-jwt diambil dari inputan dengan variable/parameter jwt
$jwt = isset($data->jwt) ? $data->jwt : "";

if($jwt){
    try{
        $decoded = JWT::decode($jwt, $key, array('HS256'));
        $content->author = $data->author;
        $content->isi = $data->isi;
        $content->created = date('Y-m-d H:i:s');
        if($content->created()){
            http_response_code(201);
            echo json_encode(array("message" => "content was created"));
        }
        else {
            http_response_code(503);
            echo json_encode(array("message" => "unable to create content"));
        }
    } catch(Exception $e){
        http_response_code(401);
        echo json_encode(array("message" => $e->getMessage()));

    }
    // if (!empty($author) && !empty($isi)){
    // $content->author = $data->author;
    // $content->isi = $data->isi;
    // $content->created = date('Y-m-d H:i:s');
    //     if($content->create()){
    //         http_response_code(201);
    //         echo json_encode(array("message" => "content was created"));
    //     }else {
    //         http_response_code(503);
    //         echo json_encode(array("message" => "unable to create content"));
    //     }

    // } 
}
else {
    // http_response_code(400);
    http_response_code(401);
    // echo json_encode(array("message" => "data is incomplete"));
    echo json_encode(array("message" => "access denided"));
}
