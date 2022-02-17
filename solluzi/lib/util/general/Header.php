<?php
namespace Solluzi\Lib\General\Header;

$http_origin = isset($_SERVER['HTTP_ORIGIN']) ? $_SERVER['HTTP_ORIGIN'] : null ;

/* header("Content-Type: application/json; charset=UTF-8");
header('Access-Control-Allow-Credentials: true');
if(in_array($http_origin, $allowedEndpoints)){
    header("Access-Control-Allow-Origin: " . $http_origin);
}
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method,Access-Control-Request-Headers, Authorization");
header("Access-Control-Allow-Methods: HEAD, GET, POST, PATCH, PUT, DELETE, OPTIONS");
header('Access-Control-Max-Age: 1000');
header("Access-Control-Expose-Headers: Content-Length, X-JSON");
 */
if(in_array($http_origin, $allowedEndpoints)){
    header("Access-Control-Allow-Origin: " . $http_origin);
}
header("Access-Control-Allow-Methods: HEAD, GET, POST, PUT, PATCH, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method,Access-Control-Request-Headers, Authorization");
header('Access-Control-Allow-Credentials: true');
header('Content-Type: application/json; charset=utf-8');

$method = $_SERVER['REQUEST_METHOD'];
if ($method === "OPTIONS") {
    header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method,Access-Control-Request-Headers, Authorization");
    header("HTTP/1.1 200 OK");
    die();
}