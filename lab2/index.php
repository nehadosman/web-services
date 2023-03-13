<?php
require_once("controller.php");

$resources = resource();
if ($resources != "products") {
    return returnRes([], 404);
}

$method = $_SERVER['REQUEST_METHOD'];
$MySQLHandler = conn();
$resource_id = resource_id();
switch ($method) {
    case 'GET':
        getItems($resource_id);
        break;

    case 'POST':
        $data = json_decode(file_get_contents('php://input'), true);
        $response = $MySQLHandler->save($data);
        echo json_encode($response);
        break;

    case 'PUT':
        // $data = json_decode(file_get_contents('php://input'), true);
        // echo (json_encode($data));
        // $MySQLHandler->update($data, $resource_id);

        if ($resource_id) {
            if ($MySQLHandler->search("id", $resource_id)) {
                $MySQLHandler->connect();
                $data = json_decode(file_get_contents('php://input'), true);
                $MySQLHandler->update($data, $resource_id);
                echo ("updated data" . json_encode($data));
                return returnRes([], 200);
            }
        } else {
            return returnRes([], 404);
        }
        break;

    case 'DELETE':

        if ($resource_id) {
            if ($MySQLHandler->search("id", $resource_id)) {
                $MySQLHandler->connect();
                $MySQLHandler->delete($resource_id);
                return returnRes([], 200);
            }
        } else {
            return returnRes([], 404);
        }
        break;
}
