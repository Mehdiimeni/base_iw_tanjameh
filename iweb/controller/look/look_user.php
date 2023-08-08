<?php
///controller/look/look_user.php
function user_look_reg($file_all_data)
{
    $filds = array(
        'id_cart_front' => $file_all_data['id_cart_front'],
        'id_cart_back' => $file_all_data['id_cart_back'],
        'user_face' => $file_all_data['user_face'],
        'user_id' =>(int) base64_decode($_COOKIE['user_id'])
    );

    $objIAPI = set_server();
    return json_decode($objIAPI->GetPostApi('look/look_reg', $filds));
}