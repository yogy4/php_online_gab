<?php
header("Access-Control-Allow-Origin: http://localhost");
header("Content-Type: application/json; charset = UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/core.php';
include_once '../shared/php-jwt/src/BeforeValidException.php';
include_once '../shared/php-jwt/src/ExpiredException.php';
include_once '../shared/php-jwt/src/SignatureInvalidException.php';
include_once '../shared/php-jwt/src/JWT.php';
use \Firebase\JWT\JWT;

// untuk menerima data yang telah dipost / dikirim
$data = json_decode(file_get_contents("php://input"));
// token ini kemungkinan berisi data awal ketika login jadi bila diupdate maka yang ditampilkan dari token ini adalah data awal
$jwt = isset($data->jwt) ? $data->jwt : ""; 

if($jwt){
    try{
        $decoded = JWT::decode($jwt, $key, array('HS256'));
        http_response_code(200);
        // tanda koma(,) untuk pindah baris
        echo json_encode(array("message" => "Access granted", "data" => $decoded->data));
    }catch(Exception $e){
        http_response_code(401);
        echo json_encode(array("message" => "Access Denided", "error" => $e->getMessage()));
    }
}else{
    http_response_code(401);
    echo json_encode(array("message" => "Access Denided"));
}
