<?php
//web help_contact 
require("./iweb/core/code_cacher.php");

$_SESSION['page_name_system'] = 'help_contact';

$codeCacher = new CodeCacher();
$codeKey = $_SESSION['page_name_system'];
$cachedCode = $codeCacher->getCachedCode($codeKey);

if ($cachedCode === false) {
    ob_start();
(new FileCaller)->FileIncluderWithControler('./iweb', 'temp', 'top');
(new FileCaller)->FileIncluderWithControler('./iweb', 'global', 'top');
(new FileCaller)->FileIncluderWithControler('./iweb', 'global', 'nav');
(new FileCaller)->FileIncluderWithControler('./iweb', 'global', 'menu');
(new FileCaller)->FileIncluderWithControler('./iweb', 'help', 'help_contact', '0');
(new FileCaller)->FileIncluderWithControler('./iweb', 'global', 'footer');
(new FileCaller)->FileIncluderWithControler('./iweb', 'temp', 'down');

$codeContent = ob_get_clean();
$codeCacher->cacheCode($codeKey, $codeContent);
$cachedCode = $codeCacher->getCachedCode($codeKey);

echo $cachedCode;
} else {
echo $cachedCode;
}