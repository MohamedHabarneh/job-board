<?php
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
$data = json_decode(file_get_contents("php://input"));
$user = new User($db);

$user->email = $data->email;
$email_exists = $user->emailExists();

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
    echo json_encode(
        array(
            "message" => "No Account or Wrong Password.",
        )
    );
}