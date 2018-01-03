<?php
$url = 'http://testroom-upload.stor.sinaapp.com/2018-01-03/11_02261639_09.jpg';
if(@fopen($url,'r')){   
    echo 'File Exits';
}else{    
    echo 'File Do Not Exits';
}