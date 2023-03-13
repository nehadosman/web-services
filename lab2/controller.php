<?php
require_once("config.php");
require_once("MySQLHandler.php");


function conn()
{
    $url = $_SERVER["REQUEST_URI"];
    $url_piecies = explode("/", $url);
    $resource = (isset($url_piecies[5])) ? $url_piecies[5] : "";
    $MySQLHandler = new MySQLHandler("$url_piecies[5]");
    return $MySQLHandler;
}

function resource_id()
{
    $url_piecies = explode("/", $_SERVER["REQUEST_URI"]);
    $resource_id = isset($url_piecies[6]) ? (int)$url_piecies[6] : 0;
    return $resource_id;
}

function resource(){
    $url_piecies = explode("/", $_SERVER["REQUEST_URI"]);
    $resource = $url_piecies[5];
    return $resource;  
}

function getItems($id = null)
{
    $MySQLHandler = conn();
    if (!$id) {
        $getAllData = $MySQLHandler->get_data();
        echo ("All Product data " . json_encode($getAllData));
        return returnRes($getAllData, 200);
    } else {
        $MySQLHandler = conn();
        $resource_id = resource_id();
        $response = $MySQLHandler->get_record_by_id($resource_id);
        if (!empty($response)) {
            echo (json_encode($response));
            return returnRes($response, 200);
        } else {
            echo ("not found");
            return returnRes([], 404);
        }
    }
}

function returnRes(array $data, $statusCode)
{
    header('Content-Type: application/json');
    http_response_code($statusCode);
}
