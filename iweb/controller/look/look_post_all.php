<?php
///controller/look/look_post_all.php
function user_look_item()
{
    $filds = array(
        'user_id' => (int) base64_decode($_COOKIE['user_id'])
    );

    $objIAPI = set_server();
    return json_decode($objIAPI->GetPostApi('look/look_post_item', $filds));
}

function look_creator_all()
{
    $filds = array(
        'user_id' => (int) base64_decode($_COOKIE['user_id'])
    );

    $objIAPI = set_server();
    return json_decode($objIAPI->GetPostApi('look/look_creator_all', $filds));

}


function is_look_reg_post($post_id)
{

    $filds = array(
        'user_id' => (int) base64_decode($_COOKIE['user_id']),
        'post_id' => $post_id,
    );
    $objIAPI = set_server();

    return json_decode($objIAPI->GetPostApi('look/is_post', $filds));

}

function get_look_group()
{
    $filds = array(
        'user_id' => (int) base64_decode($_COOKIE['user_id'])
    );

    $objIAPI = set_server();
    return json_decode($objIAPI->GetPostApi('look/look_group', $filds));
}