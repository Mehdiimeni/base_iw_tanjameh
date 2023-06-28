<?php
//url.php

$group = @$_GET["group"];
$gender = @$_GET["gender"];
$brand = @$_GET["brand"];
$trend = @$_GET["trend"];
$item = @$_GET["item"];

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