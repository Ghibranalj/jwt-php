
<?php
include('./_jwt.php');
$request = json_decode(file_get_contents('php://input'), true);

$password = $request['password'];
$username = $request['username'];

$authenticated = $username == "hello" && $password == "world";

if(!$authenticated){
    echo "Authentication failed";
    echo $password;
    http_response_code(403);
    exit();
}

$header = array('alg' => "SHA256", 'typ' => 'JWT');
$payload = array('username' => $username , 'authenticated' => 'true');

$jwt = JWT_encode($header, $payload, "ghibran_is_amazing");

echo $jwt->toString();
?>