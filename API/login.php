<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header("Access-Control-Allow-Origin: *");
header("Access-Control-Expose-Headers: Content-Length, X-JSON");
header("Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: *");

// files for decoding jwt will be here


// files needed to connect to database
include('config/database.php');
include('config/user.php');

include_once 'config/core.php';
include_once 'config/JWT.php';
include('config/BeforeValidException.php');
include('config/ExpiredException.php');
include('config/SignatureInvalidException.php');

use \Firebase\JWT\JWT;
// get database connection
$database = new Database();
$db = $database->getConnection();

// instantiate user object
$user = new User($db);

// get posted data
$data = json_decode(file_get_contents("php://input"));

// set product property values
$user->email = $data->email;
$email_exists = $user->emailExists();
// check if email exists and if password is correct
if ($email_exists && password_verify($data->password, $user->password)) {
    $token = array(
        "iat" => $issued_at,
        "exp" => $expiration_time,
        "iss" => $issuer,
        "data" => array(
            "id" => $user->id,
            "fName" => $user->fName,
            "lName" => $user->lName,
            "email" => $user->email
        )
    );

    // set response code
    http_response_code(200);
    // generate jwt
    $jwt = JWT::encode($token, $key, 'HS256');
    echo json_encode(
        array(
            "message" => "Successful login.",
            "jwt" => $jwt
        )
    );
} else {
    http_response_code(401);

    echo json_encode(
        array(
            "message" => "No Account or Wrong Password.",
        )
    );
}