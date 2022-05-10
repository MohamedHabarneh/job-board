<?php

// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include("config/database.php");
include("config/employer.php");


// database connection will be here
$database = new Database();
$db = $database->getConnection();

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->userId)) {
    $user = new Employer($db);
    $user->id = $data->userId;
} else {
    http_response_code(400);
    echo json_encode(array("message" => "ID not found."));
    return;
}

if (!empty($data->streetAddress)) {
    $user->companyAddress->zip = $data->zipCode;
    $user->companyAddress->state = $data->state;
    $user->companyAddress->streetAddress = $data->streetAddress;
    if (!$user->addAddress()) {
        http_response_code(400);
        echo json_encode(array("message" => "Unable to add address to user.", "error" => $user->error));
    }
}

$user->companyName = $data->companyName;
$user->companyPhone = $data->companyPhone;
$user->companyPhone = preg_replace("/[^0-9]/", "", $user->companyPhone);;
$user->companyEmail = $data->companyEmail;
$user->hiringRole = $data->hiringRoleId;

if (!empty($user->companyPhone) && !empty($user->companyName) && !empty($user->companyEmail) && is_numeric($user->hiringRole) && $user->addEmployerInfo()) {
    http_response_code(200);
    echo json_encode(array('message' => "Employer Info Successfully Added."));
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Unable to create user.", "error" => $user->error));
}