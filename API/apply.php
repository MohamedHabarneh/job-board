<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include("config/database.php");
include("config/employee.php");
include('config/core.php');
include('config/JWT.php');
include('config/BeforeValidException.php');
include('config/ExpiredException.php');
include('config/SignatureInvalidException.php');
include('config/Key.php');

use \Firebase\JWT\JWT;
use Firebase\JWT\Key;
// database connection will be here
$database = new Database();
$db = $database->getConnection();

$data = json_decode(file_get_contents("php://input"));
if (empty($data->jwt)) {
    http_response_code(401);
    echo json_encode(
        array(
            "message" => "Not Authorized.",
            "error" => "Token not found."
        )
    );
    return;
} else {
    $jwt = $data->jwt;
    try {
        $user = new Employee($db);
        $decoded = JWT::decode($jwt, new Key($key, 'HS256'));
        $user->id = $decoded->data->id;
        $user->fName = $decoded->data->fName;
        $user->lName = $decoded->data->lName;
        $user->email = $decoded->data->email;

        if (isset($data->postID)) {
            $user->applyToPost($data->postID);
        } else {
            http_response_code(401);

            // show error message
            echo json_encode(array(
                "message" => "No Post ID",
            ));
            return;
        }
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