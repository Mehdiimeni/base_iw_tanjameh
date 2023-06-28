<?php
//url.php

$group = @$_GET["group"];
$gender = @$_GET["gender"];

if(@$_GET['loaddata'] == 22)
{
    include_once("./iweb/page/data_gather.php");
    exit(); 
}

if ($gender == '' and $group == '') {

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