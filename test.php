<?php
echo '<pre>111 ';
print_r($_SERVER);
echo 'ip: '.$_SERVER['REMOTE_ADDR'];;
echo '<br/>Useragent: '.$_SERVER['HTTP_USER_AGENT'];