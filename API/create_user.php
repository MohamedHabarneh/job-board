<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include("config/database.php");
include("config/employer.php");
include("config/employee.php");

// database connection will be here
$database = new Database();
$db = $database->getConnection();

$data = json_decode(file_get_contents("php://input"));

if ($data->isEmployer) {
    $user = new Employer($db);
} else {
    $user = new Employee($db);
}
$user->fName = $data->fName;
$user->lName = $data->lName;
$user->email = $data->email;
if (empty($data->phone)) {
    $user->phone = NULL;
}
$user->phone = $data->phone;
$user->password = $data->password;

if (!empty($user->fName) && !empty($user->email) && !empty($user->password) && $user->create()) {
    http_response_code(200);
    echo json_encode(array('message' => "User was created."));
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Unable to create user.", "error" => $user->error));
}