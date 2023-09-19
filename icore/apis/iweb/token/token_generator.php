<?php

require_once "../global/CommonInclude.php";

if (
    !empty($_POST['username']) and
    !empty($_POST['password']) and
    !empty($_POST['secretkey'])
) {
    $username = base64_encode(base64_encode(trim($_POST['username'])));
    $password = sha1(md5($_POST['password']));
    $secretKey = trim($_POST['secretkey']);
 
    $SCondition = "(username = '$username' and password = '$password') and  enabled = 1 and secret_key = '$secretKey' ";
    if ($objORM->DataExist($SCondition, TableIWApiUsers)) {
        require "../../../iassets/classes/token_tools.php";
     
        $tokenGenerator = new TokenTools($secretKey);
        $token = $tokenGenerator->generateToken($username, 1);
        if ($token) {
            echo $token;
        } else {
            echo "Invalid username or password.";
        }
    } else {
        echo "Invalid username or password.";
    }

} else {
    echo false;
}