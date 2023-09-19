<?php
require_once "../global/CommonInclude.php";

if (
    !empty($_POST['secretkey']) and
    !empty($_POST['token'])
) {

    $secretKey = trim($_POST['secretkey']);
    $token = trim($_POST['token']);

    require "../../../iassets/classes/token_tools.php";
    $tokenGenerator = new TokenTools($secretKey);
    echo $tokenGenerator->verifyToken($token);

} else {
    echo false;
}