<?php
///controller/look/look_user.php
function user_look_reg($post_all_data)
{
    $filds = array(
        'id_cart_front' => $post_all_data['id_cart_front'],
        'id_cart_back' => $post_all_data['id_cart_back'],
        'user_face' => $post_all_data['user_face'],
        'user_id' =>(int) base64_decode($_COOKIE['user_id'])
    );

    $objIAPI = set_server();
    var_dump($objIAPI->GetPostApi('look/look_reg', $filds));
    exit();
    return json_decode($objIAPI->GetPostApi('look/look_reg', $filds));
}