<?php

class JWT{

    var $header = [];
    var $payload =  [];
    var $signature ;

    function __construct($header,$payload, $signature){
        $this->header = $header;
        $this->payload = $payload;
        // echo $signature;
        $this->signature = $signature;
    }

    function toString(){

        $header_json = json_encode($this->header);
        $payload_json = json_encode($this->payload);

        $header_b64 = base64_encode($header_json);
        $payload_b64 = base64_encode($payload_json);
        $signature_b64 = base64_encode($this->signature);
        return $header_b64 . "." . $payload_b64 . "." . $signature_b64;
    }

    function isValid(string $secret){
        $header_json = json_encode($this->header);
        $payload_json = json_encode($this->payload);

        $header_b64 = base64_encode($header_json);
        $payload_b64 = base64_encode($payload_json);

        $alg = $this->header['alg'];
        // echo $this->signature. "\r\n";
        $hash = hash($alg,$header_b64 . "." . $payload_b64 . "." . $secret);
        // echo $hash. "\r\n";

        return $this->signature == $hash;
    }
}

function JWT_decode($JWT){
    $JWT_parts = explode('.', $JWT);
    $header_b64 = $JWT_parts[0];
    $payload_b64 = $JWT_parts[1];
    $signature_b64 = $JWT_parts[2];

    // echo $signature_b64 . "\r\n";
    $signature = base64_decode($signature_b64 , true);
    // echo $signature . "\r\n";

    $jwt_header = json_decode(base64_decode($header_b64), true);
    $payload = json_decode(base64_decode($payload_b64), true);

    return new JWT($jwt_header, $payload, $signature);
}


function JWT_encode($header ,$payload, $secret){
    $alg = $header['alg'];
    $header_json = json_encode($header);
    $payload_json = json_encode($payload);
    
    $header_b64 = base64_encode($header_json);
    $payload_b64 = base64_encode($payload_json);
    
    $signature = hash($alg, $header_b64 .  "." . $payload_b64 . "." . $secret);

    return new JWT($header, $payload, $signature);
}
