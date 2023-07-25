<?php
///controller/user/ref_bank.php

function set_server()
{
    $_SERVER['HTTP_HOST'] != 'localhost' ? $server_address = 'https://' . $_SERVER['HTTP_HOST'] : $server_address = $_SERVER['HTTP_HOST'];

    $objIAPI = new IAPI($server_address, 'iweb');
    $objIAPI->SetLocalProjectName('tanjameh');
    return $objIAPI;
}

function get_currency($currency_id = 1)
{
    return $currency_id;
}



function get_user_address_default()
{

    if (base64_decode($_COOKIE['user_id']) == null) {
        return false;
    } else {
        $filds = array('user_id' => (int) base64_decode($_COOKIE['user_id']));
        $objIAPI = set_server();
        return json_decode($objIAPI->GetPostApi('user/default_address', $filds));

    }

}

function get_user_info()
{

    if (base64_decode($_COOKIE['user_id']) == null) {
        return false;
    } else {
        $filds = array('user_id' => (int) base64_decode($_COOKIE['user_id']));
        $objIAPI = set_server();
        return json_decode($objIAPI->GetPostApi('user/user_info', $filds));

    }

}

function get_user_acl()
{
    if (base64_decode($_COOKIE['user_id']) == null) {
        return false;
    } else {

        if (file_exists('./irepository/log/login/user/' . base64_decode($_COOKIE['user_id']) . '.iw')) {

            return true;
        } else {
            return false;
        }

    }

}

function set_bank($post_all_data)
{


    get_user_address_default()[0]->OtherTel != '' ? $user_cell_number = get_user_address_default()[0]->OtherTel : $user_cell_number = get_user_info()[0]->CellNumber;
    $filds = array(
        'bank' => $post_all_data['bank'],
        'user_address_id' => get_user_address_default()[0]->id,
        'user_cell_number' => $user_cell_number,
        'price' => ((int) $post_all_data['price']) * 10,
        'user_id' => (int) base64_decode($_COOKIE['user_id']),
        'res_number' => (int) base64_decode($_COOKIE['user_id']) . date("YmdHis") . rand(1111, 9999),

    );

    if ($filds['bank'] == 'saman') {
        $objBankSaman = new SamanPayment(base64_encode(base64_encode($filds['user_id'])));
        JavaTools::JsTimeRefresh(
            0, 'https://sep.shaparak.ir/OnlinePG/SendToken?token=' . $objBankSaman->getToken(
                $filds['price'],
                $filds['res_number'],
                $filds['user_address_id'],
                $filds['user_cell_number']
            )
        );
        exit();

    }


}


function set_payment($retun_bank_data)
{
    if (isset($_COOKIE['user_id'])) {
        if (((int) base64_decode($_COOKIE['user_id'])) > 0) {
            $filds = array_merge(array('user_id' => (int) base64_decode($_COOKIE['user_id'])), $retun_bank_data);
        } else {
            $filds = $retun_bank_data;
        }

    } else {
        $filds = $retun_bank_data;
    }
    $objIAPI = set_server();
    return json_decode($objIAPI->GetPostApi('user/set_payment', $filds));


}