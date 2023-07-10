<?php
//url.php

$group = @$_GET["group"];
$gender = @$_GET["gender"];
$brand = @$_GET["brand"];
$trend = @$_GET["trend"];
$item = @$_GET["item"];


if (@$_GET['user'] != '') {


    switch ($_GET['user']) {

        case 'exit':
            session_destroy();
            unset($_COOKIE['user_id']);
            setcookie('user_id', '', -1, '/');
            include_once("./iweb/page/index.php");
            exit();
            break;

        case 'login':
            include_once("./iweb/page/login.php");
            exit();
            break;

        case 'cart':
            include_once("./iweb/page/cart.php");
            exit();
            break;

        case 'myaccount':
            include_once("./iweb/page/myaccount.php");
            exit();
            break;

        case 'myaccount-orders':
            include_once("./iweb/page/myaccount_orders.php");
            exit();
            break;

        case 'myaccount-details':
            include_once("./iweb/page/myaccount_details.php");
            exit();
            break;


        case 'myaccount-addresses':
            include_once("./iweb/page/myaccount_addresses.php");
            exit();
            break;

        case 'myaccount-giftvouchers':
            include_once("./iweb/page/myaccount_giftvouchers.php");
            exit();
            break;

        case 'myaccount-messages':
            include_once("./iweb/page/myaccount_messages.php");
            exit();
            break;

        case 'myaccount-owned':
            include_once("./iweb/page/myaccount_owned.php");
            exit();
            break;

        case 'myaccount-preferences':
            include_once("./iweb/page/myaccount_preferences.php");
            exit();
            break;

        case 'faq':
            include_once("./iweb/page/faq.php");
            exit();
            break;

        case 'myaccount-privacy':
            include_once("./iweb/page/myaccount_privacy.php");
            exit();
            break;



        default:
            include_once("./iweb/page/index.php");
            exit();
            break;
    }

}

if (@$_GET['loaddata'] == 22) {
    include_once("./iweb/page/data_gather.php");
    exit();
}

if ($item != '') {
    include_once("./iweb/page/product.php");
    exit();

}

if ($gender == '' and $group == '') {

    if ($brand != '') {
        include_once("./iweb/page/brand.php");
        exit();

    }

    if ($trend != '') {
        include_once("./iweb/page/trend.php");
        exit();

    }

    include_once("./iweb/page/index.php");
    exit();

} elseif ($gender != '') {

    if (@$_GET["group"] == null) {
        include_once("./iweb/page/gender.php");
        exit();
    } else {

        include_once("./iweb/page/group.php");
        exit();

    }

}

http_response_code(404);