<?php
//web index 


$_SESSION['page_name_system'] = 'login';

(new FileCaller)->FileIncluderWithControler('./iweb', 'temp', 'top_user');
(new FileCaller)->FileIncluderWithControler('./iweb', 'user', 'login', '0');
(new FileCaller)->FileIncluderWithControler('./iweb', 'temp', 'down_user');