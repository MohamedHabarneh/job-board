<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include('config/employer.php');
include('config/employee.php');
include('config/database.php');

include('config/core.php');
include('config/JWT.php');
include('config/BeforeValidException.php');
include('config/ExpiredException.php');
include('config/SignatureInvalidException.php');
include('config/Key.php');

use \Firebase\JWT\JWT;
use Firebase\JWT\Key;


$data = json_decode(file_get_contents("php://input"));
$url = explode('/', $_SERVER['REQUEST_URI']);
$type = $url[3];

$database = new Database();
$db = $database->getConnection();

$user = new User($db);
$decoded = "";
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

        $decoded = JWT::decode($jwt, new Key($key, 'HS256'));
    } catch (Exception $e) {
        // set response code
        http_response_code(401);

        // show error message
        echo json_encode(array(
            "message" => "Access denied.",
            "error" => $e->getMessage()
        ));
        return;
    }
}

switch ($type) {
    case 'all':
        $user = new Employee($db);
        $user->id = $decoded->data->id;
        $user->fName = $decoded->data->fName;
        $user->lName = $decoded->data->lName;
        $user->email = $decoded->data->email;
        echo json_encode($user->getAllPosts());
        break;
    case 'employer':
        $user = new Employer($db);
        $user->id = $decoded->data->id;
        $user->fName = $decoded->data->fName;
        $user->lName = $decoded->data->lName;
        $user->email = $decoded->data->email;
        if (!$user->isEmployer()) {
            http_response_code(401);
            // show error message
            echo json_encode(array(
                "message" => "Access denied.",
                "error" => "Not an Employer!"
            ));
            return;
        }
        echo json_encode($user->getPostedJobs());
        break;
    case 'user':
        $user = new Employee($db);
        $user->id = $decoded->data->id;
        $user->fName = $decoded->data->fName;
        $user->lName = $decoded->data->lName;
        $user->email = $decoded->data->email;
        $type = '';
        if (!isset($_GET['type'])) {
            http_response_code(401);
            echo json_encode(array(
                "message" => "Invalid Request.",
            ));
            return;
        }
        $type = $_GET['type'];
        if ($type == 'saved') {
            echo json_encode($user->getSavedPosts());
        } else if ($type == 'applied') {
            echo json_encode($user->getAppliedPosts());
        } else {
            http_response_code(401);
            echo json_encode(array(
                "message" => "Invalid Request.",
            ));
        }

        break;
    case 'post':
        echo $_GET['id'];
        echo "post";
        break;

    default:
        http_response_code(400);
        echo json_encode(array("error" => "Invalid Request"));
        break;
}