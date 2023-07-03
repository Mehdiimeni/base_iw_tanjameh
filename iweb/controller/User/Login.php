<?php
///controller/user/login.php

function set_server()
{
    $_SERVER['HTTP_HOST'] != 'localhost' ? $server_address = 'https://'.$_SERVER['HTTP_HOST'] : $server_address = $_SERVER['HTTP_HOST'];

    $objIAPI = new IAPI($server_address, 'iweb');
    $objIAPI->SetLocalProjectName('tanjameh');
    return $objIAPI;
}

function get_user_id()
{
    isset($_REQUEST['_IWUserIdKey']) ? $UserIdKey = $_REQUEST['_IWUserIdKey']  : $UserIdKey = null;
    return $UserIdKey;

}

function get_user_acl()
{
    if (get_user_id() == null) {
        return false;
    } else {
        $filds = array('user_idkey' => get_user_id());
        $objIAPI = set_server();
        return $objIAPI->GetPostApi('user/acl', $filds);

    }

}

function get_user_cart()
{
        $filds = array('user_idkey' => get_user_id());
        $objIAPI = set_server();
        return $objIAPI->GetPostApi('user/cart', $filds);

}

function user_login($username,$password)
{
    $filds = array(
        'username' => $username,
        'password' => $password
    );
    $objIAPI = set_server();
    return json_decode($objIAPI->GetPostApi('user/login', $filds));

}


function user_signup($post_all_data)
{
    $filds = array(
        'Name' => $post_all_data['Name'],
        'CellNumber' => $post_all_data['CellNumber'],
        'Email' => $post_all_data['Email'],
        'Password' => $post_all_data['Password'],
        'Fashionpreference' => $post_all_data['Fashionpreference'],
        'accept' => $post_all_data['accept']
    );
    $objIAPI = set_server();
    return json_decode($objIAPI->GetPostApi('user/signup', $filds));

}


