<?php
///controller/user/menu_look.php
function is_look_reg_doc(){

    $filds = array(
        'user_id' => (int) base64_decode($_COOKIE['user_id']),
    );
    $objIAPI = set_server();
    return json_decode($objIAPI->GetPostApi('look/is_doc', $filds));
   
}
