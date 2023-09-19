<?php
//web category 
require("./iweb/core/code_cacher.php");
$_SESSION['gender'] = str_ireplace('%20',' ',$_GET['gender']);
$_SESSION['category'] = str_ireplace('%20',' ',$_GET['category']);


$_SESSION['page_name_system'] = 'category';
$_SESSION['actual_link'] =  "?gender=".$_GET['gender']."&category=".$_GET['category'].$_GET['page'];
$codeCacher = new CodeCacher();
$codeKey = $_SESSION['page_name_system'].$_SESSION['actual_link'];
$cachedCode = $codeCacher->getCachedCode($codeKey);

if ($cachedCode === false) {
    ob_start();

(new FileCaller)->FileIncluderWithControler('./iweb', 'temp', 'top');
(new FileCaller)->FileIncluderWithControler('./iweb', 'global', 'top');
(new FileCaller)->FileIncluderWithControler('./iweb', 'global', 'nav');
(new FileCaller)->FileIncluderWithControler('./iweb', 'global', 'menu');
(new FileCaller)->FileIncluderWithControler('./iweb', 'global', 'mobile_view');
(new FileCaller)->FileIncluderWithControler('./iweb', 'product', 'category', '0');
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