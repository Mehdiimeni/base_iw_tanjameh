<?php
//url.php

$group = @$_GET["group"];
$gender = @$_GET["gender"];
$brand = @$_GET["brand"];
$trend = @$_GET["trend"];
$search = @$_GET["search"];
$item = @$_GET["item"];
$page = @$_GET["page"];
$category = @$_GET["category"];
$look = @$_GET["look"];
$post = @$_GET["post"];


if ($category != '' and $group == '') {

    include_once("./iweb/page/category.php");
    exit();

}

if ($look != '') {

    if ($post == '') {
        include_once("./iweb/page/look_creater.php");
        exit();
    } else {

        include_once("./iweb/page/look_post_details.php");
        exit();
    }
}


if (!empty($page)) {

    switch ($page) {

        case 'signup':
            include_once("./iweb/page/help_signup.php");
            exit();
            break;

        case 'tanjameh':
            include_once("./iweb/page/help_tanjameh.php");
            exit();
            break;

        case 'buy':
            include_once("./iweb/page/help_buy.php");
            exit();
            break;

        case 'note':
            include_once("./iweb/page/help_note.php");
            exit();
            break;

        case 'complaint':
            include_once("./iweb/page/help_complaint.php");
            exit();
            break;

        case 'law':
            include_once("./iweb/page/help_law.php");
            exit();
            break;

        case 'contact':
            include_once("./iweb/page/help_contact.php");
            exit();
            break;


    }

}


if (@$_GET['user'] != '') {

    if (empty($_COOKIE['user_id'])) {
        switch ($_GET['user']) {

            case 'login':
                include_once("./iweb/page/login.php");
                exit();
                break;

            case 'cart':
                include_once("./iweb/page/login.php");
                exit();
                break;

            default:
                include_once("./iweb/page/index.php");
                exit();
                break;
        }
    } else {


        switch ($_GET['user']) {

            case 'exit':
                session_destroy();
                unset($_COOKIE['user_id']);
                setcookie('user_id', '', -1, '/');
                include_once("./iweb/page/index.php");
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

            case 'myaccount-order-detail':
                include_once("./iweb/page/myaccount_order_detail.php");
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

            case 'favorite':
                include_once("./iweb/page/favorite.php");
                exit();
                break;

            case 'last_view':
                include_once("./iweb/page/last_view.php");
                exit();
                break;

            case 'checkout_address':
                include_once("./iweb/page/checkout_address.php");
                exit();
                break;

            case 'checkout_confirm':
                include_once("./iweb/page/checkout_confirm.php");
                exit();
                break;

            case 'set_bank':
                include_once("./iweb/page/set_bank.php");
                exit();
                break;

            case 'ref_bank':
                include_once("./iweb/page/ref_bank.php");
                exit();
                break;

            case 'myaccount_look':
                include_once("./iweb/page/myaccount_look.php");
                exit();
                break;

            case 'look_user':
                include_once("./iweb/page/look_user.php");
                exit();
                break;

            case 'look_page':
                include_once("./iweb/page/look_page.php");
                exit();
                break;

            case 'look_post':
                include_once("./iweb/page/look_post.php");
                exit();
                break;

            case 'look_post_all':
                include_once("./iweb/page/look_post_all.php");
                exit();
                break;


        }
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

    if ($search != '') {
        include_once("./iweb/page/search.php");
        exit();

    }

    include_once("./iweb/page/index.php");
    exit();

} elseif ($gender != '') {

    if (@$_GET["group"] == null) {
        include_once("./iweb/page/gender.php");
        exit();
    } else {

        if ($category == 'look') {
            include_once("./iweb/page/look.php");
            exit();
        } else {
            include_once("./iweb/page/group.php");
            exit();

        }



    }

}

http_response_code(404);