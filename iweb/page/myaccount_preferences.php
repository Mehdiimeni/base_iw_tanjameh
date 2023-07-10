<?php
//web index 

$_SESSION['page_name_system'] = 'myaccount_preferences';

(new FileCaller)->FileIncluderWithControler('./iweb', 'temp', 'top');
(new FileCaller)->FileIncluderWithControler('./iweb', 'global', 'top');
(new FileCaller)->FileIncluderWithControler('./iweb', 'global', 'nav');
(new FileCaller)->FileIncluderWithControler('./iweb', 'global', 'menu');
(new FileCaller)->FileIncluderWithControler('./iweb', 'user', 'menu', '0');
(new FileCaller)->FileIncluderWithControler('./iweb', 'user', 'myaccount_preferences', '0');
(new FileCaller)->FileIncluderWithControler('./iweb', 'global', 'footer');
(new FileCaller)->FileIncluderWithControler('./iweb', 'temp', 'down');