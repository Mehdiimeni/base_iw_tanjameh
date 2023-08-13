<?php
///controller/look/look_post.php
function user_look_post($file_all_data, $post_all_data)
{
    $filds = array(
        'image1' => $file_all_data['image1'],
        'image2' => $file_all_data['image2'],
        'image3' => $file_all_data['image3'],
        'image4' => $file_all_data['image4'],
        'itemm1' => $post_all_data['itemm1'],
        'iteml1' => $post_all_data['iteml1'],
        'itemm2' => $post_all_data['itemm2'],
        'iteml2' => $post_all_data['iteml2'],
        'itemm3' => $post_all_data['itemm3'],
        'iteml3' => $post_all_data['iteml3'],
        'itemm4' => $post_all_data['itemm4'],
        'iteml4' => $post_all_data['iteml4'],
        'look_group' => $post_all_data['look_group'],
        'user_id' => (int) base64_decode($_COOKIE['user_id'])
    );

    $objIAPI = set_server();
    return json_decode($objIAPI->GetPostApi('look/look_post', $filds));
}

function user_look_post_info($post_id)
{
    $filds = array(
        'user_id' => (int) base64_decode($_COOKIE['user_id']),
        'post_id' => $post_id,
    );

    $objIAPI = set_server();
    return json_decode($objIAPI->GetPostApi('look/look_post_info', $filds));
}



function user_look_item()
{
    $filds = array(
        'user_id' => (int) base64_decode($_COOKIE['user_id'])
    );

    $objIAPI = set_server();
    return json_decode($objIAPI->GetPostApi('look/look_post_item', $filds));
}

function get_look_group()
{
    $filds = array(
        'user_id' => (int) base64_decode($_COOKIE['user_id'])
    );

    $objIAPI = set_server();
    return json_decode($objIAPI->GetPostApi('look/look_group', $filds));
}