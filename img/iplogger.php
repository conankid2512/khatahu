<?php 
$log = 'logger.html'; 
$ip = @$_SERVER['REMOTE_ADDR']; 
$page = @$_SERVER['REQUEST_URI']; 
$refer = @$_SERVER['HTTP_REFERER']; 
$date_time = date("l j F Y g:ia", time() - date("Z")) ; 
$agent = @$_SERVER['HTTP_USER_AGENT']; 
$fp = fopen("logger.html", "a"); 
fputs($fp, " 
<b>$date_time</b> <br> <b>IP: </b>$ip<br><b>Page: </b>$page<br><b>Refer: </b>$refer<br><b>Useragent: 

</b>$agent <br><br> 
"); 
flock($fp, 3); 
fclose($fp);
header('Content-Type: image/jpeg');
readfile("123.jpg");
?> 