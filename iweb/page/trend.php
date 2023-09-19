<?php
//web trend 
require("./iweb/core/code_cacher.php");
$_SESSION['trend'] = $_GET['trend'];
$_SESSION['trend_id'] = $_GET['id'];
$_SESSION['page_name_system'] = 'trend';

$codeCacher = new CodeCacher();
$codeKey = $_SESSION['page_name_system'].$_SESSION['trend'].$_SESSION['trend_id'].$_GET['page'];
$cachedCode = $codeCacher->getCachedCode($codeKey);

if ($cachedCode === false) {
    ob_start();
(new FileCaller)->FileIncluderWithControler('./iweb', 'temp', 'top');
(new FileCaller)->FileIncluderWithControler('./iweb', 'global', 'top');
(new FileCaller)->FileIncluderWithControler('./iweb', 'global', 'nav');
(new FileCaller)->FileIncluderWithControler('./iweb', 'global', 'menu');
(new FileCaller)->FileIncluderWithControler('./iweb', 'global', 'mobile_view');
(new FileCaller)->FileIncluderWithControler('./iweb', 'product', 'trend', '0');
(new FileCaller)->FileIncluderWithControler('./iweb', 'adver', 'title_adver_1', '0');
(new FileCaller)->FileIncluderWithControler('./iweb', 'adver', 'brand_box', '0');
(new FileCaller)->FileIncluderWithControler('./iweb', 'adver', 'trend_categories', '0');
(new FileCaller)->FileIncluderWithControler('./iweb', 'global', 'footer');
(new FileCaller)->FileIncluderWithControler('./iweb', 'temp', 'down');

$codeContent = ob_get_clean();
$codeCacher->cacheCode($codeKey, $codeContent);
$cachedCode = $codeCacher->getCachedCode($codeKey);

echo $cachedCode;
} else {
echo $cachedCode;
}