<?php

include('./_jwt.php');


$req_headers = getallheaders();
$JWT_Token = $req_headers['JWT'];
$jwt = JWT_decode($JWT_Token);

$valid = $jwt->isValid("ghibran_is_amazing");

if (!$valid) {
    http_response_code(401);
    exit();
}



?>