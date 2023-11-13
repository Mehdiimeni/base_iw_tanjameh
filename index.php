<?php
//index.php 

require "./iweb/vendor/autoload.php";
SessionTools::init();


$requests_limit = 10; // تعداد مجاز درخواست‌ها
$time_interval = 3; // بازه زمانی (ثانیه) میان درخواست‌ها

if (!isset($_SESSION['last_request_time'])) {
    $_SESSION['last_request_time'] = time();
    $_SESSION['request_count'] = 1;
} else {
    $current_time = time();
    $time_diff = $current_time - $_SESSION['last_request_time'];

    if ($time_diff < $time_interval) {
        $_SESSION['request_count']++;
        if ($_SESSION['request_count'] > $requests_limit) {
            http_response_code(429); // کد خطای "تعداد درخواست‌ها زیاد است" (Too Many Requests)
            exit(" تعداد درخواست‌ها زیاد است. لطفاً به مدت 7 ثانیه صبر کنید.");
        }
    } else {
        $_SESSION['request_count'] = 1;
    }

    $_SESSION['last_request_time'] = $current_time;
}

$objIAPI = new IAPI($_SERVER["HTTP_HOST"], "iweb");
$objIAPI->SetLocalProjectName("tanjameh");


$jsonHost = json_decode($objIAPI->GetGeneralApi("global/host_name"));


if (str_contains(@$jsonHost->host, "localhost")) {
    error_reporting(E_ALL);
} else {
    error_reporting(0);
}


//error_reporting(E_ALL);

$objFileToolsInit = new FileTools("./icore/idefine/conf/init.iw");

(new MakeDirectory)->MKDir("./irepository/log/error/", "iweb", 0755);
$objInitTools = new InitTools($objFileToolsInit->KeyValueFileReader(), "./irepository/log/error/iweb/viewerror.log");


include "./iweb/lang/" . $objInitTools->getLang() . "_web.php";
include "./iweb/lang/" . $objInitTools->getLang() . "_product.php";

require("./iweb/core/caller.php");
require("./iweb/core/urls.php");
exit();