<?php
header("Access-Control-Allow-Origin: http://localhost");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods");

include_once '../config/database.php';
include_once '../objects/user.php';
include_once '../config/core.php';
include_once '../shared/php-jwt/src/BeforeValidException.php';
include_once '../shared/php-jwt/src/ExpiredException.php';
include_once '../shared/php-jwt/src/SignatureInvalidException.php';
include_once '../shared/php-jwt/src/JWT.php';
use \Firebase\JWT\JWT;
$database = new Database();
$db = $database->getConnection();
$user = new User($db);



$data = json_decode(file_get_contents("php://input"));
$user->email = $data->email;
$email_exists = $user->emailExists();

if($email_exists && password_verify($data->password, $user->password)){
    $token = array(
        "iss" => $iss,
        "aud" => $aud,
        "iat" => $iat,
        "nbf" => $nbf,
        "data" => array (
            "id" => $user->id,
            "firstname" => $user->firtname,
            "lastname" => $user->lastname,
            "email" => $user->email
        )
    );
    http_response_code(200);
    $jwt = JWT::encode($token, $key);
    echo json_encode(array("message" => "Success Login",
                            "jwt" => $jwt));
} else {
    http_response_code(401);
    echo json_encode(array ("message" => "Login Failed"));
}