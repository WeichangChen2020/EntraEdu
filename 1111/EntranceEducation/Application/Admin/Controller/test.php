<?php
$url = 'http://testroom-upload.stor.sinaapp.com/2018-01-03/1d73a8d688491f2c.jpg';
if(@fopen($url,'r')){   
    echo 'File Exits';
}else{    
    echo 'File Do Not Exits';
}