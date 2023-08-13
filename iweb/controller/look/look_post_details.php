<?php
///controller/look/look_post_details.php
function look_post_details($post_id)
{
    $filds = array(
        'post_id' => $post_id,
        'currencies_conversion_id' => get_currency()
    );


    $objIAPI = set_server();
    return json_decode($objIAPI->GetPostApi('look/look_post_details', $filds));
}