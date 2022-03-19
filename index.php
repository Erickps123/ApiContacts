<?php

header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Methods: GET, POST, DELETE');
header("Access-Control-Allow-Headers: X-Requested-With");
header('Content-Type: text/html; charset=utf-8');

include_once 'includes/DbParams.php';
require_once 'includes/Request.php';

$conn = new Request();


switch ($_SERVER['REQUEST_METHOD']) {
    case "GET":
        if(isset($_GET["id"])){
            Response($conn -> getcontact($_GET["id"]));
        }
        else{
            Response($conn -> getcontacts());
        }
      break;
    case "POST":
        Autorization();
        RequiredParams(array('name','lastname','email','cellphone'));
        $param["name"]=$_POST['name'];
        $param["lastname"] = $_POST["lastname"];
        $param["email"] = $_POST["email"];
        $param["cellphone"] = $_POST["cellphone"];
        Response($conn -> addcontact($param));
        
      break;
    case "DELETE":
        Autorization();
        Response($conn -> deletecontact($_GET["id"]));
        
      break;
    default:
        $conn -> getcontacts();
  }

function Autorization() {
    $headers = apache_request_headers();
    if (isset($headers['Authorization'])) {
        $API_KEY = $headers['Authorization'];
        if ($API_KEY != API_KEY) { 
            Response("Access Denied.");
            exit();
        }
    }else {
        Response("You need an API KEY.");
        exit();
    }
}

function Response($res) {
    header('Content-Type: application/json;charset=UTF-8');
    echo json_encode($res);
}

function RequiredParams($fields) {
    $missing_params=false;
    $req = $_REQUEST;
    foreach ($fields as $field) {
        if (!isset($req[$field]) || empty($req[$field])) {
            $missing_params = true;
        }
    }
    if ($missing_params) {
        $message = "Missing Fields.";
        Response($message);
        exit();
    }
}

?>