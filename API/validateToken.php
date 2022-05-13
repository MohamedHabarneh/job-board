<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
// files needed to connect to database
include('config/database.php');
include('config/user.php');

include('config/core.php');
include('config/JWT.php');
include('config/BeforeValidException.php');
include('config/ExpiredException.php');
include('config/SignatureInvalidException.php');
include('config/Key.php');


use \Firebase\JWT\JWT;
use Firebase\JWT\Key;

// get posted data
$data = json_decode(file_get_contents("php://input"));

// get jwt
$jwt = isset($data->jwt) ? $data->jwt : "";
if ($jwt) {

    // if decode succeed, show user details
    try {

        $decoded = JWT::decode($jwt, new Key($key, 'HS256'));
        http_response_code(200);

        // show user details
        echo json_encode(array(
            "message" => "Access granted.",
            "data" => $decoded->data
        ));
    } catch (Exception $e) {

        // set response code
        http_response_code(401);

        // show error message
        echo json_encode(array(
            "message" => "Access denied.",
            "error" => $e->getMessage()
        ));
    }
}